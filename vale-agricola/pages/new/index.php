<?php

require_once "../../settings/config.php";
ini_set('error_reporting', E_ALL); // mesmo resultado de: error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST["button"])) {
    $empresa = new Empresa();
    $empresa->constructorCreate(
        trim($_POST["nome"]),
        trim($_POST["senha"]),
        trim($_POST["email"]),
        $_POST["cnpj"]
    );
    $empresa->save();
    
    header("location: ../login/");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../../assets/images/olifx_logo.png" type="image/png">
  <title>Vale Agrícola | Criar conta</title>
  <link rel="stylesheet" href="cadastro.css">
</head>
<body>
    <section class="form">
        <h1 class="titulo">Criar Conta</h1>
        <form action="index.php" method="post" enctype="multipart/form-data">

            <label for="cnpj">Cnpj</label>
            <input type="int" name="cnpj" id="cnpj" required>

            <label for="fullname">Nome</label>
            <input type="text" name="nome" id="nome" required>

            <label for="email">E-Mail</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Senha</label>
            <input type="password" name="password" id="password" required>

            <input type="submit" value="Criar" name="button" class="botao">
        </form>
    </section>
</body>
</html>
