<?php

namespace App\Services;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class CodigoEmailService
{
    public const CADASTRO = 'cadastro';
    public const RECUPERAR_SENHA = 'recuperar_senha';
    public const ALTERAR_SENHA = 'alterar_senha';

    public static function normalizarEmail(string $email): string
    {
        return mb_strtolower(trim($email));
    }

    public function enviar(string $email, string $finalidade, string $ip): void
    {
        $email = self::normalizarEmail($email);

        $chaveEmail = 'otp:email:' . $finalidade . ':' . hash('sha256', $email);
        $chaveIp = 'otp:ip:' . hash('sha256', $ip);

        if (
            RateLimiter::tooManyAttempts($chaveEmail, 1) ||
            RateLimiter::tooManyAttempts($chaveIp, 20)
        ) {
            abort(429, 'Aguarde antes de solicitar outro código.');
        }

        // 1 solicitação/min por e-mail; 20 solicitações/h por IP.
        RateLimiter::hit($chaveEmail, 60);
        RateLimiter::hit($chaveIp, 3600);

        // GERAÇÃO DO CÓDIGO DE 6 DÍGITOS
        $codigo = str_pad(
            (string) random_int(0, 999999),
            6,
            '0',
            STR_PAD_LEFT
        );

        // ARMAZENAMENTO SEGURO
        DB::table('tbl_codigos_verificacao')->updateOrInsert(
            [
                'email' => $email,
                'finalidade' => $finalidade,
            ],
            [
                'codigo_hash' => Hash::make($codigo),
                'tentativas' => 0,
                'expira_em' => now()->addMinutes(10),
                'updated_at' => now(),
            ]
        );

        // CONTEÚDO PERSONALIZADO PARA CADA FINALIDADE
        $assunto = match ($finalidade) {
            self::CADASTRO => 'Confirmação de e-mail - Conexão 360°',
            self::RECUPERAR_SENHA => 'Recuperação de senha - Conexão 360°',
            default => 'Alteração de senha - Conexão 360°',
        };

        $titulo = match ($finalidade) {
            self::CADASTRO => 'Confirme seu e-mail',
            self::RECUPERAR_SENHA => 'Recupere sua senha',
            default => 'Confirme a alteração',
        };

        $descricao = match ($finalidade) {
            self::CADASTRO =>
                'Utilize o código abaixo para concluir seu cadastro.',
            self::RECUPERAR_SENHA =>
                'Utilize o código abaixo para redefinir sua senha.',
            default =>
                'Utilize o código abaixo para confirmar a alteração de senha.',
        };

        // TEMPLATE HTML DO E-MAIL
        $html = <<<HTML
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Conexão 360°</title>
</head>

<body style="
    margin:0;
    padding:0;
    background-color:#F1F3F5;
    font-family:Arial,Helvetica,sans-serif;
">

    <div style="
        display:none;
        max-height:0;
        overflow:hidden;
        opacity:0;
        color:transparent;
    ">
        Seu código de segurança do Conexão 360° está disponível nesta mensagem.
    </div>

    <table
        role="presentation"
        cellpadding="0"
        cellspacing="0"
        border="0"
        width="100%"
        style="background-color:#F1F3F5;"
    >
        <tr>
            <td align="center" style="padding:40px 16px;">

                <table
                    role="presentation"
                    cellpadding="0"
                    cellspacing="0"
                    border="0"
                    width="100%"
                    style="
                        max-width:520px;
                        background-color:#151A20;
                        border:1px solid #30343A;
                        border-radius:18px;
                    "
                >
                    <tr>
                        <td
                            align="center"
                            style="padding:42px 24px 30px;"
                        >

                            <!-- IDENTIDADE -->
                            <p style="
                                margin:0 0 12px;
                                color:#DDB967;
                                font-size:26px;
                                font-weight:700;
                                letter-spacing:1px;
                            ">
                                Conexão 360°
                            </p>

                            <p style="
                                margin:0 0 32px;
                                color:#A7ACB4;
                                font-size:12px;
                                letter-spacing:2px;
                                text-transform:uppercase;
                            ">
                                Verificação de segurança
                            </p>

                            <!-- TÍTULO -->
                            <h1 style="
                                margin:0 0 16px;
                                color:#FFFFFF;
                                font-size:25px;
                                line-height:32px;
                            ">
                                {$titulo}
                            </h1>

                            <!-- DESCRIÇÃO -->
                            <p style="
                                margin:0 0 28px;
                                color:#CED3DA;
                                font-size:15px;
                                line-height:24px;
                            ">
                                {$descricao}
                            </p>

                            <!-- CÓDIGO EM DESTAQUE -->
                            <table
                                role="presentation"
                                cellpadding="0"
                                cellspacing="0"
                                border="0"
                                width="100%"
                                style="
                                    background-color:#252B34;
                                    border:2px solid #DDB967;
                                    border-radius:12px;
                                "
                            >
                                <tr>
                                    <td
                                        align="center"
                                        style="padding:24px 8px;"
                                    >
                                        <span style="
                                            display:block;
                                            color:#F6D68C;
                                            font-size:38px;
                                            font-weight:700;
                                            letter-spacing:6px;
                                            line-height:46px;
                                            font-family:Arial,Helvetica,sans-serif;
                                        ">
                                            {$codigo}
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <!-- INSTRUÇÕES -->
                            <p style="
                                margin:22px 0 8px;
                                color:#FFFFFF;
                                font-size:14px;
                                font-weight:600;
                            ">
                                Digite os 6 números no aplicativo.
                            </p>

                            <p style="
                                margin:0 0 30px;
                                color:#CED3DA;
                                font-size:14px;
                                line-height:22px;
                            ">
                                Este código expira em
                                <strong style="color:#DDB967;">
                                    10 minutos
                                </strong>.
                            </p>

                            <!-- AVISO DE SEGURANÇA -->
                            <table
                                role="presentation"
                                cellpadding="0"
                                cellspacing="0"
                                border="0"
                                width="100%"
                                style="
                                    background-color:#1E242C;
                                    border-radius:10px;
                                "
                            >
                                <tr>
                                    <td style="
                                        padding:18px;
                                        color:#AEB5BE;
                                        font-size:13px;
                                        line-height:21px;
                                        text-align:center;
                                    ">
                                        Não compartilhe este código
                                        com ninguém.

                                        <br>

                                        Se você não solicitou esta
                                        verificação, ignore este e-mail.
                                    </td>
                                </tr>
                            </table>

                            <!-- RODAPÉ -->
                            <div style="
                                border-top:1px solid #39414B;
                                margin-top:32px;
                                padding-top:24px;
                            ">
                                <p style="
                                    margin:0 0 8px;
                                    color:#DDB967;
                                    font-size:14px;
                                    font-weight:700;
                                ">
                                    Conexão 360°
                                </p>

                                <p style="
                                    margin:0;
                                    color:#8F98A4;
                                    font-size:12px;
                                    line-height:19px;
                                ">
                                    Conectando pessoas e oportunidades.
                                </p>
                            </div>

                        </td>
                    </tr>
                </table>

                <p style="
                    max-width:520px;
                    margin:22px auto 0;
                    color:#77808B;
                    font-size:12px;
                    line-height:19px;
                    text-align:center;
                ">
                    Esta mensagem foi enviada automaticamente.
                    Por favor, não responda.
                </p>

            </td>
        </tr>
    </table>

</body>
</html>
HTML;

        // ENVIO REAL PELO SMTP CONFIGURADO NO LARAVEL
        Mail::html($html, function ($mail) use ($email, $assunto) {
            $mail->to($email)->subject($assunto);
        });
    }

    /**
     * Consome o código e executa a operação na mesma transação.
     *
     * Retorna null quando o código é inválido, expirado
     * ou teve suas tentativas esgotadas.
     */
    public function consumir(
        string $email,
        string $finalidade,
        string $codigo,
        Closure $operacao
    ): mixed {
        $email = self::normalizarEmail($email);

        return DB::transaction(function () use (
            $email,
            $finalidade,
            $codigo,
            $operacao
        ) {
            $query = DB::table('tbl_codigos_verificacao')
                ->where('email', $email)
                ->where('finalidade', $finalidade);

            $registro = (clone $query)->lockForUpdate()->first();

            if (
                !$registro ||
                now()->greaterThanOrEqualTo($registro->expira_em) ||
                $registro->tentativas >= 5
            ) {
                return null;
            }

            if (!Hash::check($codigo, $registro->codigo_hash)) {
                (clone $query)->update([
                    'tentativas' => $registro->tentativas + 1,
                    'updated_at' => now(),
                ]);

                return null;
            }

            $resultado = $operacao();

            (clone $query)->delete();

            return $resultado;
        }, 3);
    }
}
