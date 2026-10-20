<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Usuarios;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    public function index(): JsonResponse
    {
        $users = Usuarios::where('status_usuario', 'ATIVO')
            ->inRandomOrder()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    public function show(Request $request): JsonResponse
    {
        $usuario = $request->user();

        return response()->json([
            'success' => true,
            'data' => $usuario,
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        // O token Sanctum determina quem pode ser editado.
        // Nenhum ID fornecido pelo aplicativo é aceito nesta rota.
        /** @var Usuarios $usuario */
        $usuario = $request->user();

        $dados = $request->validate([
            'nome_usuario' => ['sometimes', 'required', 'string', 'min:2', 'max:100'],
            'area_atuacao_usuario' => ['sometimes', 'nullable', 'string', 'max:150'],
            'estado_usuario' => ['sometimes', 'required', 'string', 'size:2', 'in:AC,AL,AP,AM,BA,CE,DF,ES,GO,MA,MT,MS,MG,PA,PB,PR,PE,PI,RJ,RN,RS,RO,RR,SC,SP,SE,TO'],
            'sobre_usuario' => ['sometimes', 'nullable', 'string', 'max:200'],
            'instagram_usuario' => ['sometimes', 'nullable', 'string', 'max:255'],
            'linkedin_usuario' => ['sometimes', 'nullable', 'string', 'max:255'],
            'youtube_usuario' => ['sometimes', 'nullable', 'string', 'max:255'],
            'tiktok_usuario' => ['sometimes', 'nullable', 'string', 'max:255'],
            'facebook_usuario' => ['sometimes', 'nullable', 'string', 'max:255'],
            'site_usuario' => ['sometimes', 'nullable', 'string', 'max:255'],
            'foto_usuario' => ['sometimes', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        // No esquema original estes dois campos não aceitam NULL.
        // A conversão de strings vazias para NULL ocorre no middleware Laravel.
        // Permite que o usuário limpe a área de atuação e a descrição sem violar NOT NULL.
        foreach (['area_atuacao_usuario', 'sobre_usuario'] as $campo) {
            if (array_key_exists($campo, $dados) && $dados[$campo] === null) {
                $dados[$campo] = '';
            }
        }

        // A foto é tratada separadamente: nunca passar um UploadedFile para o model.
        unset($dados['foto_usuario']);

        if ($request->hasFile('foto_usuario')) {
            // Compatível com o caminho já utilizado pelo getUrlFotoUsuario do app:
            // /dash/assets/img/ + foto_usuario (ex.: usuario/nome.jpg)
            $diretorio = public_path('dash/assets/img/usuario');
            File::ensureDirectoryExists($diretorio);

            $arquivo = $request->file('foto_usuario');
            $nomeArquivo = (string) Str::uuid() . '.' . $arquivo->extension();
            $arquivo->move($diretorio, $nomeArquivo);

            $dados['foto_usuario'] = 'usuario/' . $nomeArquivo;
        }

        // Apenas os campos validados são alterados. Perfil, status, senha,
        // e-mail e outros campos sensíveis não podem ser modificados por esta rota.
        $usuario->fill($dados);
        $usuario->save();

        return response()->json([
            'success' => true,
            'message' => 'Perfil atualizado com sucesso.',
            'data' => $usuario->fresh(),
        ]);
    }
}
