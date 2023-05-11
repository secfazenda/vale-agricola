<?php
require_once "../../settings/config.php";
session_start();

if (!isset($_SESSION['idEmpresa'])) {
    header("location: ../home");
}

$documentos = Documento::findallByDocumento($_SESSION['idEmpresa']);

if (isset($_SESSION["idDocumento"])) {
    $documentos_indv = Documento::findallByDocumento($_SESSION['idDocumento']);
}else{
    header("location: ../home");
}

    /*if (isset($_POST["button"])) {
        $documento->setNome(trim($_POST['nome']));
        $documento->setValidade(trim($_POST['validade']));
        $documento->setPdf(trim($_POST['pdf']));

        if ($documento->save()) {
            header('location: ../edit-document');
            exit();
        } else {
            echo "<script>alert('Ocorreu um erro ao editar o seu perfil');</script>";
        }
    
} else {
    header("location: ../home");
    exit();
}*/
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
            <form action="index.php" method="post" enctype="multipart/form-data">
            <?php foreach($documentos as $documento){?>
                <div><a href="../edit-document" class="document">
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

                <input type="submit" value="Editar" class="botao" name="button">

                <!-- <button type="submit" name="excluir">Excluir conta</button> -->
            </form>

            <a class="excluir" href="../delete-document" onclick="return confirmarExclusao()">Excluir Documento</a>
            <a href="../home" class="botao-voltar"><img src="../../settings/imagens/botao-voltar.png" alt=""></a>
        </div>
    </div>
</body>
</html>

<script>
    function confirmarExclusao() {
        if (confirm("Tem certeza que deseja excluir esse documento?")) {
            alert("Documento excluido com sucesso.");
            return true;
        } else {
            return false;
        }
    }
</script>