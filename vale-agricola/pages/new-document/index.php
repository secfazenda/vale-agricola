<?php

require_once "../../settings/config.php";

session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vale Agrícola | Cadastro de Documento</title>
</head>
<body>
    <div class="home-page-util">
        <div class="home-page">
            <h1>Cadastre um Documento</h1>
            <form action="index.php" method="post">
                <label for="nome">Nome:</label>
                <input type="text" class="nome" id="nome" minlength="3" maxlength="20" required placeholder="Digite o nome do Documento aqui">

                <label for="validade">Validade do Documento:</label>
                <input type="date" class="validade" id="validade" required>

                <label for="pdf">Selecione o arquivo PDF do documento:</label>
                <input type="file" class="pdf" id="pdf" accept=".pdf" required>

                <input type="submit" value="Cadastrar" class="botao" name="button">
            </form>
            <a href="../home">Voltar</a>
        </div>
    </div>
</body>
</html>