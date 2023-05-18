<?php
require_once "../../settings/config.php";
session_start();

// Verifique se o ID do documento foi fornecido na URL
if (isset($_GET["idDocumento"])) {
    $idDocumento = $_GET["idDocumento"];

    // Use o ID do documento para buscar as informações correspondentes
    $documento = Documento::findByID($idDocumento);

    // Verifique se o documento foi encontrado
    if ($documento) {
        // echo "<h1>{$documento->getNome()}</h1>";
        // echo "<p>Validade: {$documento->getValidade()->format("d/m/Y")}</p>";
        // Resto do código para exibir as informações do documento

        if (isset($_POST["idDocumento"])) {
            $idDocumento = $_POST["idDocumento"];
            $nome = $_POST["nome"];
            $validade = $_POST["validade"];

            // Resto do código de edição...
            $documento->setNome($nome);
            $documento->setValidade($validade);
            $documento->save(); // Salvar as alterações no banco de dados
        }
    } else {
        echo "Documento não encontrado.";
    }
} else {
    echo "ID do documento não fornecido na URL.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Vale Agrícola | Documento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="header">
        <div class="logo">
            <img src="../../settings/imagens/logo-alto-feliz.png" alt="logoaf">
        </div>
        <div class="icone">
            <img src="../../settings/imagens/icone-contraste.png" alt="iconedl">
        </div>
    </header>

    <div class="edit-document-util">
        <div class="edit-document">
            <h1 class="titulo">Editar Documento</h1>

            <form action="index.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idDocumento" value="<?php echo $idDocumento; ?>">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" value="<?php echo $documento->getNome(); ?>"><br>
                <label for="validade">Validade</label>
                <input type="date" id="validade" name="validade" value="<?php echo $documento->getValidade()->format("d/m/Y"); ?>"><br>

                <input type="submit" value="Editar" class="botao" name="button">
            </form>
            
            <a class="botao-excluir" href="../delete-document?idDocumento=<?php echo $documento->getIdDocumento(); ?>" onclick="return confirmarExclusao()">Excluir Documento</a>
            <a href="../home" class="botao-voltar"><img src="../../settings/imagens/botao-voltar.png" alt=""></a>
            
        </div>
    </div>
</body>
</html>

<script>
    function confirmarExclusao() {
        if (confirm("Tem certeza que deseja excluir esse documento?")) {
            alert("Documento excluído com sucesso.");
            return true;
        } else {
            return false;
        }
    }
</script>
