<?php
require_once '../vendor/autoload.php';
require_once '../src/Empresa.php';
require_once '../src/Documento.php';

use PHPMailer\PHPMailer\PHPMailer;

$EMAIL_ADDRESS = 'marcelo.ost7@gmail.com';
$EMAIL_PASSWORD = 'jqolwaclkzozhrum';

$intervalo = 86400; // Um dia em segundos

while (true) {
    enviarEmailsParaEmpresas($EMAIL_ADDRESS, $EMAIL_PASSWORD);

    sleep($intervalo);
}

function enviarEmailsParaEmpresas($email, $senha) {
    $empresas = Empresa::findall();

    foreach ($empresas as $empresa) {
        $emailEmpresa = $empresa->getEmail();
        $documentos = Documento::findByEmpresa($empresa->getIdEmpresa());

        foreach ($documentos as $documento) {
            $validade = $documento->getValidade();
            $hoje = new DateTime();
            $diferenca = $hoje->diff($validade);
            $diasRestantes = $diferenca->days;

            if ($diasRestantes <= 7) {
                enviarEmail($emailEmpresa, $senha);
                break; // Se um documento estiver prestes a expirar, envia apenas um e-mail e passa para a próxima empresa
            }
        }
    }
}

function enviarEmail($email, $senha) {
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
