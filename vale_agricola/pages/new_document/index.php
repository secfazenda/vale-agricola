<?php

require_once "../../settings/config.php";
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
session_start();
if(!isset($_SESSION['idEmpresa'])){
    header("../login");
}

$mode = isset($_COOKIE['mode']) ? $_COOKIE['mode'] : '';
$isDarkMode = $mode === 'dark';

if (isset($_POST["button"])) {
    if(isset($_FILES["pdf"])) {
        $nome_arquivo = $_FILES["pdf"]["name"];
        $extensao_arquivo = pathinfo($nome_arquivo, PATHINFO_EXTENSION);
        if($extensao_arquivo == "pdf") {
            $diretorio_destino = "../../documentos/";
            $caminho_completo = $diretorio_destino . $nome_arquivo;
            if(move_uploaded_file($_FILES["pdf"]["tmp_name"], $caminho_completo)) {
                echo "Arquivo enviado com sucesso.";
            } else {
                echo "Ocorreu um erro ao enviar o arquivo.";
            }
        } else {
            echo "Apenas arquivos PDF são permitidos.";
        }
    }
    
    if (!empty($_POST["nome"])) {
        $validade = isset($_POST["validade"]) ? new DateTime($_POST["validade"]) : null;
        $caminho_arquivo = $caminho_completo;
        
        $documento = new Documento();
        $documento->constructorCreate(
            trim($_POST["nome"]),
            $validade,
            $caminho_arquivo
        );
        $documento->setIdEmpresa($_SESSION['idEmpresa']);
        $documento->save();          
        
        header("location: ../home/");
    } else {
        echo "Por favor, preencha o nome do documento.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vale Agrícola | Cadastro de Documento</title>
    <link rel="stylesheet" href="style.css">

    <script>
        function toggleDarkMode() {
            var body = document.body;
            var isDarkMode = body.classList.toggle('dark-mode');
            
            // Define um cookie para lembrar a preferência de modo
            document.cookie = 'mode=' + (isDarkMode ? 'dark' : 'light') + '; expires=Fri, 31 Dec 9999 23:59:59 UTC; path=/';
        }
    </script>
</head>
<body <?php if ($isDarkMode) echo 'class="dark-mode"'; ?>>
    <header class="header">
        <div class="brasao">
            <img src="../../settings/imagens/logo-alto-feliz-brasao.png" alt="brasaoaf">
        </div>
        <div class="logo">
            <img src="../../settings/imagens/logo-alto-feliz-letras.png" alt="logoaf">
        </div>
        <div class="icone" onclick="toggleDarkMode()">
            <img src="../../settings/imagens/icone-contraste.png" alt="iconedl">
        </div>
    </header>

    <div class="home-page-util">
        <div class="home-page">
            <h1 class="titulo">Cadastre um Documento</h1>
            <form action="index.php" method="post" enctype="multipart/form-data">
                <label for="fullname">Nome</label>
                <input type="text" name="nome" id="nome" minlength="3" maxlength="50" required>

                <label for="validade">Validade</label>
                <input type="date" name="validade" id="validade" required>

                <label for="pdf">Selecione ou arraste o arquivo PDF</label>
                <input type="file" name="pdf" id="pdf" accept=".pdf" required>

                <input type="submit" value="Cadastrar" class="botao" name="button">
            </form>
            <a href="../home" class="botao-voltar"><img src="../../settings/imagens/botao-voltar.png" alt=""></a>
        </div>
    </div>
</body>
</html>