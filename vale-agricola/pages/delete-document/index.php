<?php
require_once "../../settings/config.php";
session_start();

if (isset($_SESSION['idDocumento'])) {
    $documento = Documento::find($_SESSION['idDocumento']);
    
    // Verificar se o documento foi encontrado antes de tentar excluí-lo
    if ($documento) {
        // Obtenha o caminho completo do arquivo
        $caminhoArquivo = $documento->getCaminhoArquivo();
        
        // Excluir o arquivo físico do sistema
        if (unlink($caminhoArquivo)) {
            // Se a exclusão do arquivo for bem-sucedida, exclua o documento do banco de dados
            $documento->delete();
        }
    }

    header("location: ../home");
} else {
    header("location: ../delete-document/erro.php");
}

