<?php
require_once "../../settings/config.php";
session_start();

// Verificando se o ID do documento foi fornecido na URL
if (isset($_GET["idDocumento"])) {
    $idDocumento = $_GET["idDocumento"];

    // Verificando se o ID do documento é um número inteiro válido
    if (is_numeric($idDocumento)) {
        // Usando o ID do documento para buscar as informações correspondentes
        $documento = Documento::find($idDocumento);

        // Verificando se o documento foi encontrado
        if ($documento) {
            // Excluindo o documento
            $documento->delete();

            // Redirecionando para a página inicial ou exiba uma mensagem de sucesso
            header("Location: ../home");
            exit();
        } else {
            echo "Documento não encontrado.";
        }
    } else {
        echo "ID do documento inválido.";
    }
} else {
    echo "ID do documento não fornecido na URL.";
}
