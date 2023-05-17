<?php
require_once "../../settings/config.php";
session_start();

// Verifique se o ID do documento foi fornecido na URL
if (isset($_GET["idDocumento"])) {
    $idDocumento = $_GET["idDocumento"];

    // Use o ID do documento para buscar as informações correspondentes
    $documento = Documento::find($idDocumento);

    // Verifique se o documento foi encontrado
    if ($documento) {
        // Exclua o documento
        $documento->delete();

        // Redirecione para a página inicial ou exiba uma mensagem de sucesso
        header("Location: ../home");
        exit();
    } else {
        echo "Documento não encontrado.";
    }
} else {
    echo "ID do documento não fornecido na URL.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>erro</h1>
</body>
</html>
