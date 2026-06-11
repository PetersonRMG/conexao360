<?php
$ok = 0;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

try {
    if (isset($_POST["email"])) {
        // só vai entrar aqui... se preencher o form e clicar no btn enviar 

        require 'vendor/phpmailer/Exception.php';
        require 'vendor/phpmailer/PHPMailer.php';
        require 'vendor/phpmailer/SMTP.php';

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(exceptions: true);

        $nome = $_POST["nome"];
        $email =  $_POST["email"];
        $tel = $_POST["telefone"];


        // var_dump($nome);
        // var_dump($email);
        // var_dump($tel);
        // var_dump($motivo);
        // var_dump($mensagem);

        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'tipi05.360criativo.com.br';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'contato@tipi05.360criativo.com.br';                     //SMTP username
        $mail->Password   = 'TIPI05**2025';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('contato@tipi05.360criativo.com.br'); // quem dispara o email
        $mail->addAddress('peterson.rmgraciano@senacsp.edu.br');     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Formulario Palestra';
        $mail->Body    = "
            Nome:$nome <br>
            Email: $email<br>
            Telefone: $tel<br>
           
        ";
        $mail->AltBody = "
            Nome:$nome/n
            Email: $email/n
            Telefone: $tel/n           
        ";

        $mail->send();
        $ok = 1;
        // echo $nome .  ',sua mensagem foi enviada com sucesso!';
    } // fim do if 
} catch (Exception $e) {
    //echo $nome . ", não foipossivel o envio de email: {$mail->ErrorInfo}";
    $ok = 2;
}



?>

<section id="conexao" class="sessao-formulario">
    <div class="container">
        <div class="tit-for">
            <h2>Entre para a lista prioritária da Conexão 360º</h2>
            <p>Conteúdos estratégicos, acesso antecipado e prioridade nas vagas.</p>
        </div>

        <div class="lista-bene">
            <ul>
                <li><span class="check">✓</span> Conteúdos exclusivos</li>
                <li><span class="check">✓</span> Bastidores do evento</li>
                <li><span class="check">✓</span> Avisos antecipados</li>
                <li><span class="check">✓</span> Prioridade em vagas</li>
            </ul>

            <div class="formulario">
                <h3>Entre Para o Grupo do <br> Evento Conexão 360º </h3>
 
                    <form id="ent-formulario" method="post" onsubmit="window.open('https://chat.whatsapp.com/G4h7Ow7XWiw8b9jq7TSk4V?mode=gi_t','_blank')">

                    <div class="input-container">
                        <img src="{{asset('conexao360/img/icones_adv (12).svg')}}" alt="" width="30px">
                        <input type="text" name="nome" placeholder="Nome completo">
                    </div>

                    <div class="input-container">
                        <img src="{{asset('conexao360/img/icones_adv (11).svg" alt="" width="30px">
                        <input type="tel" name="telefone" placeholder="WhatsApp">
                    </div>

                    <div class="input-container">
                        <img src="{{asset('conexao360/img/icones_adv (10).svg" alt="" width="30px">
                        <input type="email" name="Email" placeholder="email">
                    </div>

                    <button type="submit" class="cta-for"> Entrar no Grupo VIP</button>

                    <h6>
                        <?php
                        if ($ok == 1) {
                            echo $nome . ", sua mensagem foi enviada com sucesso.";
                        } else if ($ok == 2) {
                            echo $nome . ", não foi possivel enviar sua mensagem. Tente mais tarde.";
                        }
                        ?>
                    </h6>
                </form>

                <div class="icon-whats">
                    <p>
                        Redirecionamento imediato para o WhatsApp.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>