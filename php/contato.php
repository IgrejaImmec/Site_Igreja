<?php
require_once('src/PHPMailer.php');
require_once('src/SMTP.php');
require_once('src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 $primeiroNome = addslashes($_POST['primeiroNome']);
 $segundoNome = addslashes($_POST['segundoNome']);
 $email = addslashes($_POST['email']);
 $telefone = addslashes($_POST['telefone']);
 $mensagem = addslashes($_POST['mensagem']);

if (empty($primeiroNome) || empty($segundoNome) || empty($email) || empty($telefone) || empty($mensagem)) {
    echo 'Erro: Preencha todos os campos.';
    return;
}


    
    enviaEmail($primeiroNome, $segundoNome, $email, $telefone, $mensagem);

}

function enviaEmail($primeiroNome, $segundoNome, $email, $telefone, $mensagem)
{
    // Ativando o debug do PHPMailer para acompanhar o envio dos emails
    $mail = new PHPMailer(true);

    try {
       // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.outlook.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'SuporteImmecChurch2023@outlook.com';
        $mail->Password = 'SomosUmaIgrejaSaudavel';
        $mail->Port = 587;

        $mail->setFrom('SuporteImmecChurch2023@outlook.com');
        $mail->addAddress('1923333070@uezo.edu.br');

        $mail->isHTML(true);
        $mail->Subject = 'Usuario Visitante do Site';
        $mail->Body = '<h3>Oi, me chamo ' . $primeiroNome . ' ' . $segundoNome . '<h3>
        <br> ' . $mensagem . '<br>' . 'Meu email de contato ' . $email . '<br>Telefone: ' . $telefone . '<br>  ';
        
        $mail->AltBody = 'Chegou um Email';

        if ($mail->send()) {
                    
            // Encaminha um JSON com a resposta para o AJAX caso não tenha recebido os dados
            $response = array(
                'success' => true,
                'message' => 'Mensagem enviada!'
            );
            echo json_encode($response);
            echo 'Email enviado';
        } else {
            echo 'Email não enviado';
        }
    } catch (Exception $e) {
        echo "Erro ao enviar mensagem: {$email->ErrorInfo}";
    }
}
?>