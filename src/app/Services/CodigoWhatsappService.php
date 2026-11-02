<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class CodigoWhatsappService
{
    public static function normalizarTelefone(string $telefone): string
    {
        $digitos = preg_replace('/\D+/', '', $telefone) ?? '';
        return strlen($digitos) === 11 ? '55' . $digitos : $digitos;
    }

    public static function telefoneValido(string $telefone): bool
    {
        // Celular brasileiro com +55, DDD de 2 dígitos e celular começando em 9.
        return preg_match('/^55[1-9][0-9]9[0-9]{8}$/', $telefone) === 1;
    }

    public function disponivel(): bool
    {
        $driver = config('whatsapp.driver');
        if ($driver === 'log') {
            return app()->environment('local');
        }
        if ($driver !== 'meta') {
            return false;
        }

        return filled(config('whatsapp.phone_number_id'))
            && filled(config('whatsapp.access_token'))
            && filled(config('whatsapp.template_name'));
    }

    public function modoTeste(): bool
    {
        return config('whatsapp.driver') === 'log' && app()->environment('local');
    }

    public function enviar(string $email, string $telefone, string $ip): void
    {
        if (!$this->disponivel()) {
            abort(503, 'A verificação por WhatsApp não está disponível. Escolha e-mail.');
        }

        $email = CodigoEmailService::normalizarEmail($email);
        $telefone = self::normalizarTelefone($telefone);

        if (!self::telefoneValido($telefone)) {
            throw ValidationException::withMessages(['telefone' => 'Informe um celular brasileiro válido com DDD.']);
        }

        $chaveDestino = 'otp:whatsapp:cadastro:' . hash('sha256', $telefone);
        $chaveEmail = 'otp:whatsapp:email:' . hash('sha256', $email);
        $chaveIp = 'otp:ip:' . hash('sha256', $ip);

        if (RateLimiter::tooManyAttempts($chaveDestino, 1)
            || RateLimiter::tooManyAttempts($chaveEmail, 1)
            || RateLimiter::tooManyAttempts($chaveIp, 20)) {
            abort(429, 'Aguarde antes de solicitar outro código.');
        }

        RateLimiter::hit($chaveDestino, 60);
        RateLimiter::hit($chaveEmail, 60);
        RateLimiter::hit($chaveIp, 3600);

        $codigo = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // A mesma chave email+finalidade permite só um código ativo por cadastro,
        // independentemente do canal selecionado.
        DB::table('tbl_codigos_verificacao')->updateOrInsert(
            ['email' => $email, 'finalidade' => CodigoEmailService::CADASTRO],
            [
                'canal' => 'whatsapp',
                'telefone' => $telefone,
                'codigo_hash' => Hash::make($codigo),
                'tentativas' => 0,
                'expira_em' => now()->addMinutes(10),
                'updated_at' => now(),
            ]
        );

        try {
            if ($this->modoTeste()) {
                // Nunca usar o driver log fora do ambiente local.
                Log::debug('CODIGO_WHATSAPP_TESTE: ' . $codigo . ' | destinatario=' . substr($telefone, -4));
                return;
            }

            // Modelo AUTHENTICATION / COPY_CODE previamente aprovado pela Meta.
            $endpoint = sprintf(
                'https://graph.facebook.com/%s/%s/messages',
                rawurlencode((string) config('whatsapp.graph_version')),
                rawurlencode((string) config('whatsapp.phone_number_id'))
            );

            $resposta = Http::withToken((string) config('whatsapp.access_token'))
                ->acceptJson()
                ->timeout(15)
                ->post($endpoint, [
                    'messaging_product' => 'whatsapp',
                    'to' => $telefone,
                    'type' => 'template',
                    'template' => [
                        'name' => config('whatsapp.template_name'),
                        'language' => ['code' => config('whatsapp.template_language')],
                        'components' => [
                            ['type' => 'body', 'parameters' => [['type' => 'text', 'text' => $codigo]]],
                            ['type' => 'button', 'sub_type' => 'url', 'index' => '0',
                             'parameters' => [['type' => 'text', 'text' => $codigo]]],
                        ],
                    ],
                ]);

            if (!$resposta->successful() || blank($resposta->json('messages.0.id'))) {
                Log::warning('WhatsApp Meta: envio recusado', [
                    'status' => $resposta->status(),
                    'error_code' => $resposta->json('error.code'),
                ]);
                abort(502, 'Não foi possível solicitar o código por WhatsApp. Tente novamente ou escolha e-mail.');
            }
        } catch (\Throwable $e) {
            // Nunca conservar um OTP que não foi enviado com sucesso.
            DB::table('tbl_codigos_verificacao')
                ->where('email', $email)
                ->where('finalidade', CodigoEmailService::CADASTRO)
                ->where('canal', 'whatsapp')
                ->where('telefone', $telefone)
                ->delete();

            if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                throw $e;
            }
            Log::warning('Falha de conexão com provedor WhatsApp', ['exception' => get_class($e)]);
            abort(502, 'Falha no envio por WhatsApp. Tente novamente ou escolha e-mail.');
        }
    }
}
