<?php

require_once '../vendor/autoload.php';
//echo PHPMailer\PHPMailer\PHPMailer::VERSION;

use PHPMailer\PHPMailer\PHPMailer;

$EMAIL_ADDRESS = 'marcelo.ost7@gmail.com';
$EMAIL_PASSWORD = 'jqolwaclkzozhrum';

$intervalo = 86400;

while (true) {
    enviarEmail($EMAIL_ADDRESS, $EMAIL_PASSWORD);

    sleep($intervalo);
}

function enviarEmail($email, $senha){
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = $email;
    $mail->Password = $senha;
    $mail->setFrom($email);
    $mail->addAddress($email);
    $mail->Subject = 'Vencimento de Documentos';
    $mail->Body = 'Olá, esse é um aviso para você dar uma olhada na validade dos documentos cadastrados no Vale Agricola, pois algum está prestes a expirar.';

    if (!$mail->send()) {
        echo 'Erro ao enviar o e-mail: ' . $mail->ErrorInfo;
    } else {
        echo 'E-mail enviado com sucesso!';
    }
}
?>
