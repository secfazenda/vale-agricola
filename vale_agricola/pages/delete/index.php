<?php
require_once "../../settings/config.php";
session_start();
$empresa = Empresa::find($_SESSION['idEmpresa']);
$empresa->delete();
header("location: ../login");