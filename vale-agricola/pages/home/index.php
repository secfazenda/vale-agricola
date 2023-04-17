<?php

require_once "../../settings/config.php";

session_start();

if (!isset($_SESSION["idEmpresa"])) {
    header("location: ../login");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vale Agrícola | Página de Usuário</title>
</head>
<body>
    <div class="home-page-util">
        <div class="home-page">
            <h1>Usuário Logado</h1>

            <a href="../edit">Editar Conta</a>
            <a href="../logout">Sair</a>
        </div>
    </div>
</body>
</html>