<?php

require_once "../../settings/config.php";
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

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
    
    // Verifica se os campos obrigatórios foram preenchidos
    if (!empty($_POST["nome"])) {
        // Converte a data para um objeto DateTime
        $validade = isset($_POST["validade"]) ? new DateTime($_POST["validade"]) : null;
        
        // Armazena o caminho completo do arquivo em uma variável
        $caminho_arquivo = $caminho_completo;
        
        // Cria o objeto Documento
        $documento = new Documento();
        $documento->constructorCreate(
            trim($_POST["nome"]),
            $validade,
            $caminho_arquivo
        );
        $documento->save();          
        
        // header("location: ../home/");
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
</head>
<body>
    <div class="home-page-util">
        <div class="home-page">
            <h1>Cadastre um Documento</h1>
            <form action="index.php" method="post" enctype="multipart/form-data">
                <label for="fullname">Nome:</label>
                <input type="text" name="nome" id="nome" minlength="3" maxlength="20" required placeholder="Digite o nome do documento aqui">

                <label for="validade">Validade do Documento:</label>
                <input type="date" name="validade" id="validade" required>

                <label for="pdf">Selecione o arquivo PDF do documento:</label>
                <input type="file" name="pdf" id="pdf" accept=".pdf" required>

                <input type="submit" value="Cadastrar" class="botao" name="button">
            </form>
            <a href="../home">Voltar</a>
        </div>
    </div>
</body>
</html>