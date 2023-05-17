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
        echo "<h1>{$documento->getNome()}</h1>";
        echo "<p>Validade: {$documento->getValidade()->format("d/m/Y")}</p>";
        // Resto do código para exibir as informações do documento
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
</head>
<body>
    <div class="edit-document-util">
        <div class="edit-document">
            <h1 class="titulo">Editar Documento</h1>
            <!-- Formulário de edição do documento -->
            <form action="index.php" method="post" enctype="multipart/form-data">
                <!-- Campos do formulário -->
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo $documento->getNome(); ?>"><br>
                <label for="validade">Validade:</label>
                <input type="text" id="validade" name="validade" value="<?php echo $documento->getValidade()->format("d/m/Y"); ?>"><br>
                <!-- ... outros campos do formulário ... -->

                <input type="submit" value="Editar" class="botao" name="button">
            </form>

            <a class="excluir" href="../delete-document?idDocumento=<?php echo $documento->getIdDocumento(); ?>" onclick="return confirmarExclusao()">Excluir Documento</a>
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
