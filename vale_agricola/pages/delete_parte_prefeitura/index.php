<?php
require_once "../../settings/config.php";
session_start();

if (!isset($_SESSION["idEmpresa"])) {
    header("location: ../login");
    exit;
}

if (!isset($_GET["idEmpresa"])) {
    // Redirecionar para a página anterior ou exibir uma mensagem de erro
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

$idEmpresa = $_GET["idEmpresa"];

// Verificar se o ID da empresa não é igual ao ID da prefeitura (1)
if ($idEmpresa == 1) {
    // Redirecionar para a página anterior ou exibir uma mensagem de erro
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

// Excluir a empresa com o ID correspondente
$empresa = Empresa::find($idEmpresa);
$empresa->delete();

// Redirecionar para a página anterior ou exibir uma mensagem de sucesso
header("Location: {$_SERVER['HTTP_REFERER']}");
exit;
?>
