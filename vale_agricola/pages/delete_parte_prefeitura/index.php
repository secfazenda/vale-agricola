<?php
require_once "../../settings/config.php";
session_start();

if (!isset($_SESSION["idEmpresa"])) {
    header("location: ../login");
    exit;
}

if (!isset($_GET["idEmpresa"])) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

$idEmpresa = $_GET["idEmpresa"];

if ($idEmpresa == 1) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

$empresa = Empresa::find($idEmpresa);
$empresa->delete();

header("Location: ../home_prefeitura");
exit;
?>
