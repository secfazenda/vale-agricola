<?php

require 'vendor/autoload.php';


$EMAIL_ADDRESS = 'marcelo.ost7@gmail.com';
$EMAIL_PASSWORD = 'jqolwaclkzozhrum';

$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = $EMAIL_ADDRESS;
$mail->Password = $EMAIL_PASSWORD;
$mail->setFrom($EMAIL_ADDRESS);
$mail->addAddress($EMAIL_ADDRESS);
$mail->Subject = 'Jogo Grêmio';
$mail->Body = 'Jogo do Grêmio hoje contra o Cruzeiro.';

if (!$mail->send()) {
    echo 'Erro ao enviar o e-mail: ' . $mail->ErrorInfo;
} else {
    echo 'E-mail enviado com sucesso!';
}
?>
