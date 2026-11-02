<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use App\Services\CodigoEmailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class VerificacaoEmailController extends Controller
{
    public function codigoCadastro(Request $request, CodigoEmailService $codigos): JsonResponse
    {
        $dados = $request->validate([
            'email' => ['required', 'string', 'email:rfc,dns', 'max:80', 'unique:tbl_usuarios,email_usuario'],
        ]);

        $codigos->enviar($dados['email'], CodigoEmailService::CADASTRO, $request->ip());

        return response()->json([
            'success' => true,
            'message' => 'Enviamos um código para seu e-mail. Ele é válido por 10 minutos.',
        ]);
    }

    public function codigoRecuperacao(Request $request, CodigoEmailService $codigos): JsonResponse
    {
        $dados = $request->validate([
            'email' => ['required', 'string', 'email:rfc,dns', 'max:80'],
        ]);

        $email = CodigoEmailService::normalizarEmail($dados['email']);

        // Mesmo resultado público para e-mails cadastrados e não cadastrados.
        if (Usuarios::where('email_usuario', $email)->exists()) {
            $codigos->enviar($email, CodigoEmailService::RECUPERAR_SENHA, $request->ip());
        } else {
            // Limitar abuso mesmo para solicitações a e-mails inexistentes.
            $chave = 'otp:ip:' . hash('sha256', $request->ip());
            if (RateLimiter::tooManyAttempts($chave, 20)) {
                abort(429, 'Aguarde antes de solicitar outro código.');
            }
            RateLimiter::hit($chave, 3600);
        }

        return response()->json([
            'success' => true,
            'message' => 'Se o e-mail estiver cadastrado, enviaremos um código de verificação.',
        ]);
    }

    /**
     * Confirma o código de recuperação ANTES de mostrar a nova senha.
     * Não consome o código: a operação /reset o valida novamente e o consome.
     * A quantidade de tentativas incorretas continua limitada a 5.
     */
    public function verificarCodigoRecuperacao(Request $request): JsonResponse
    {
        $dados = $request->validate([
            'email' => ['required', 'string', 'email:rfc,dns', 'max:80'],
            'codigo' => ['required', 'digits:6'],
        ]);

        $email = CodigoEmailService::normalizarEmail($dados['email']);
        $correto = DB::transaction(function () use ($email, $dados) {
            $query = DB::table('tbl_codigos_verificacao')
                ->where('email', $email)
                ->where('finalidade', CodigoEmailService::RECUPERAR_SENHA);

            $registro = (clone $query)->lockForUpdate()->first();
            if (!$registro ||
                now()->greaterThanOrEqualTo($registro->expira_em) ||
                $registro->tentativas >= 5) {
                return false;
            }

            if (!Hash::check($dados['codigo'], $registro->codigo_hash)) {
                (clone $query)->update([
                    'tentativas' => $registro->tentativas + 1,
                    'updated_at' => now(),
                ]);
                return false;
            }

            return true;
        }, 3);

        if (!$correto) {
            throw ValidationException::withMessages([
                'codigo' => 'Código inválido, expirado ou com tentativas esgotadas.',
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Código confirmado. Escolha uma nova senha.']);
    }

    public function redefinirSenha(Request $request, CodigoEmailService $codigos): JsonResponse
    {
        $dados = $request->validate([
            'email' => ['required', 'string', 'email:rfc,dns', 'max:80'],
            'codigo' => ['required', 'digits:6'],
            'senha' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
        ]);

        $email = CodigoEmailService::normalizarEmail($dados['email']);

        $usuario = $codigos->consumir(
            $email,
            CodigoEmailService::RECUPERAR_SENHA,
            $dados['codigo'],
            function () use ($email, $dados) {
                $usuario = Usuarios::where('email_usuario', $email)->first();
                if (!$usuario) {
                    throw ValidationException::withMessages(['codigo' => 'Código inválido ou expirado.']);
                }
                $usuario->senha_usuario = Hash::make($dados['senha']);
                $usuario->save();
                $usuario->tokens()->delete();
                return $usuario;
            }
        );

        if (!$usuario) {
            throw ValidationException::withMessages(['codigo' => 'Código inválido, expirado ou com tentativas esgotadas.']);
        }

        return response()->json(['success' => true, 'message' => 'Senha redefinida. Entre novamente.']);
    }

    public function codigoAlteracao(Request $request, CodigoEmailService $codigos): JsonResponse
    {
        $dados = $request->validate(['senha_atual' => ['required', 'string']]);
        $usuario = $request->user();

        // A tela de alteração recebe a senha atual e a nova ANTES do OTP.
        if (!Hash::check($dados['senha_atual'], $usuario->senha_usuario)) {
            throw ValidationException::withMessages([
                'senha_atual' => 'Senha atual incorreta.',
            ]);
        }

        $codigos->enviar($usuario->email_usuario, CodigoEmailService::ALTERAR_SENHA, $request->ip());
        return response()->json(['success' => true, 'message' => 'Código enviado para o e-mail da sua conta.']);
    }

    public function alterarSenha(Request $request, CodigoEmailService $codigos): JsonResponse
    {
        $dados = $request->validate([
            'codigo' => ['required', 'digits:6'],
            'senha_atual' => ['required', 'string'],
            'senha' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
        ]);

        $usuario = $request->user();
        $tokenAtual = $usuario->currentAccessToken();

        if (!Hash::check($dados['senha_atual'], $usuario->senha_usuario)) {
            throw ValidationException::withMessages(['senha_atual' => 'Senha atual incorreta.']);
        }

        $resultado = $codigos->consumir(
            $usuario->email_usuario,
            CodigoEmailService::ALTERAR_SENHA,
            $dados['codigo'],
            function () use ($usuario, $dados, $tokenAtual) {
                $usuario->senha_usuario = Hash::make($dados['senha']);
                $usuario->save();
                // Mantém o token desta sessão e encerra sessões de outros dispositivos.
                // Recuperação de senha continua invalidando TODOS os tokens.
                if ($tokenAtual instanceof \Laravel\Sanctum\PersonalAccessToken) {
                    $usuario->tokens()
                        ->where('id', '!=', $tokenAtual->getKey())
                        ->delete();
                }
                return true;
            }
        );

        if (!$resultado) {
            throw ValidationException::withMessages(['codigo' => 'Código inválido, expirado ou com tentativas esgotadas.']);
        }

        return response()->json(['success' => true, 'message' => 'Senha alterada com sucesso. Sua sessão continua ativa.']);
    }
}
