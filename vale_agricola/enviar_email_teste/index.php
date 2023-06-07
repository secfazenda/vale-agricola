<?php
require_once '../vendor/autoload.php';
require_once '../src/Empresa.php';
require_once '../src/Documento.php';

use PHPMailer\PHPMailer\PHPMailer;

$EMAIL_ADDRESS = 'marcelo.ost7@gmail.com';
$EMAIL_PASSWORD = 'jqolwaclkzozhrum';

// Obtém todas as empresas cadastradas
$empresas = Empresa::findall();

// Itera sobre as empresas
foreach ($empresas as $empresa) {
    $emailEmpresa = $empresa->getEmail();
    $nomeEmpresa = $empresa->getNome();
    
    // Obtém os documentos da empresa
    $documentos = Documento::findByEmpresa($empresa->getIdEmpresa());
    
    // Verifica se algum documento está prestes a expirar
    foreach ($documentos as $documento) {
        $dataAtual = new DateTime();
        $dataExpiracao = $documento->getValidade();
        $diasRestantes = $dataAtual->diff($dataExpiracao)->days;
        
        if ($diasRestantes <= 7) {
            enviarEmail($emailEmpresa, $EMAIL_ADDRESS, $EMAIL_PASSWORD, $nomeEmpresa);
            break; // Interrompe o loop caso um email seja enviado
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
    $mail->Body = "Olá, {$nomeEmpresa}! Esse é um aviso para você dar uma olhada na validade dos documentos cadastrados no Vale Agricola, pois algum está prestes a expirar.";

    if (!$mail->send()) {
        echo 'Erro ao enviar o e-mail: ' . $mail->ErrorInfo;
    } else {
        echo "E-mail enviado para {$nomeEmpresa} com sucesso!";
    }
}


?>
