<?php
require_once('src/PHPMailer.php');
require_once('src/SMTP.php');
require_once('src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $primeiroNome = filter_input(INPUT_POST, 'primeiroNome', FILTER_SANITIZE_STRING);
    $segundoNome = filter_input(INPUT_POST, 'segundoNome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
    $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_STRING);

    enviaEmail($primeiroNome, $segundoNome, $email, $telefone, $mensagem);

    // Encaminha um JSON com a resposta para o AJAX caso não tenha recebido os dados
    $response = array(
        'success' => true,
        'message' => 'Mensagem enviada!'
    );

    echo json_encode($response);
}

function enviaEmail($primeiroNome, $segundoNome, $email, $telefone, $mensagem)
{
    // Ativando o debug do PHPMailer para acompanhar o envio dos emails
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.outlook.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'SuporteImmecChurch@outlook.com';
        $mail->Password = 'SomosUmaIgrejaSaudavel';
        $mail->Port = 587;

        $mail->setFrom('SuporteImmecChurch@outlook.com');
        $mail->addAddress('immecChurch@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = 'Usuario Site';
        $mail->Body = '<h3>Oi, me chamo ' . $primeiroNome . ' ' . $segundoNome . '<h3>
        <br> ' . $mensagem . '<br>' . 'Meu email de contato ' . $email . '<br>Telefone: ' . $telefone . '<br>  :)';
        $mail->AltBody = 'Chegou um Email';

        if ($mail->send()) {
            echo 'Email enviado';
        } else {
            echo 'Email não enviado';
        }
    } catch (Exception $e) {
        echo "Erro ao enviar mensagem: {$email->ErrorInfo}";
    }
}
?>