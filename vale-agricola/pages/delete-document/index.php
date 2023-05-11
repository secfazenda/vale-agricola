<?php
require_once "../../settings/config.php";
session_start();
$documento = Documento::find($_SESSION['idDocumento']);
$documento->delete();
header("location: ../home");