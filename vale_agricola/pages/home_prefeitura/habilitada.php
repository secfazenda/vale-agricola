<?php
require_once "../../settings/config.php";
// toggle_habilitada.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['idEmpresa']) && isset($_POST['habilitar'])) {
        $idEmpresa = $_POST['idEmpresa'];
        $habilitada = $_POST['habilitar'];
        
        // Aqui você precisa implementar a lógica para atualizar a coluna "habilitada" no banco de dados, com base nos valores recebidos.
        // Por exemplo, você pode usar o método save() da classe Empresa para salvar os dados atualizados.
        
        // Exemplo:
        $empresa = Empresa::find($idEmpresa);
        $empresa->setHabilitada($habilitada);
        $empresa->save();
    }
}

// Redirecionar de volta para a página principal
header("Location: index.php");
exit();
?>
