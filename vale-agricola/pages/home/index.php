<?php

require_once "../../settings/config.php";

session_start();

if (!isset($_SESSION["idEmpresa"])) {
    header("location: ../login");
}

$documentos = Documento::findall();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vale Agrícola | Página de Usuário</title>
</head>
<body>
    <div class="home-page-util">
        <div class="home-page">
            <h1>Usuário Logado</h1>
            <?php echo "Olá ".$_SESSION['nome'].", Bem vindo! <br>";
            foreach($documentos as $documento){?>
                <div><a href="">
                <?php 
                echo "<td>{$documento->getNome()}</td>";
                $validade = $documento->getValidade();
                echo " - ";
                echo "<td>{$validade->format("d/m/Y")}</td>";
                // echo " - ";
                // echo "<td>{$documento->getPdf()}</td>";
                ?>
                </a></div>
            <?php } ?>
            
            <div class="buttons">
                <div class="new-document"><a href="../new-document">Cadastrar Documento</a></div>
                <div class="edit-account"><a href="../edit">Editar Conta</a></div>
                <div class="back-account"><a href="../logout">Sair</a></div>
            </div>
        </div>
    </div>
</body>
</html>