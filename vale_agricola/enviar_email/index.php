<?php
require_once '../vendor/autoload.php';
require_once '../src/docs.php';

use PHPMailer\PHPMailer\PHPMailer;

$EMAIL_ADDRESS = 'fazenda@altofeliz.rs.gov.br';
$EMAIL_PASSWORD = 'gL!16DP@5q';

$empresas = Empresa::findall();

foreach ($empresas as $empresa) {
    $emailEmpresa = $empresa->getEmail();
    $nomeEmpresa = $empresa->getNome();
    $habilitada = $empresa->getHabilitada();

    $documentos = Documento::findByEmpresa($empresa->getIdEmpresa());
    
    if ($habilitada === 1) {
        foreach ($documentos as $documento) {
            $dataAtual = new DateTime();
            $dataExpiracao = $documento->getValidade();
            $diasRestantes = $dataAtual->diff($dataExpiracao)->days;
            
            if ($diasRestantes <= 7) {
                enviarEmail($emailEmpresa, $EMAIL_ADDRESS, $EMAIL_PASSWORD, $nomeEmpresa);
                break;
            }
        }
    }

}

echo 'Verificação concluída com sucesso!';
exit();

function enviarEmail($email, $emailRemetente, $senhaRemetente, $nomeEmpresa){
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = $emailRemetente;
    $mail->Password = $senhaRemetente;
    $mail->setFrom($emailRemetente);
    $mail->addAddress($email);
    $mail->Subject = 'Vencimento de Documentos';
    $mail->Body = "Olá, {$nomeEmpresa}!

Esse é um aviso para você dar uma olhada na validade dos documentos cadastrados no Vale Agricola, pois algum está prestes a expirar.

Não esqueça de atualiza-los o mais breve possível!

Atenciosamente, Prefeitura de Alto Feliz";

    if (!$mail->send()) {
        echo 'Erro ao enviar o e-mail: ' . $mail->ErrorInfo;
    } else {
        echo "E-mail enviado para {$nomeEmpresa} com sucesso!";
    }
}

?>
