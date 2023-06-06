<?php
require_once "../../settings/config.php";
session_start();

if (!isset($_SESSION["idEmpresa"])) {
    header("location: ../login");
}

$idEmpresa = $_GET['idEmpresa'];
// Use o ID da empresa para exibir os documentos correspondentes

$empresas = Empresa::findall($_SESSION['idEmpresa']);
$documentos = Documento::findallByEmpresa($_SESSION['idEmpresa']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        <div class="home-page-util">
        <div class="home-page">
            <h2 class="subtitulo">Lista de Documentos</h2>
            <?php foreach($documentos as $documento){?>
                <div>
                <a href="../edit-document?idDocumento=<?php echo $documento->getIdDocumento(); ?>" class="document">
                        <?php 
                        echo "<td>{$documento->getNome()}</td>";
                        $validade = $documento->getValidade();
                        echo " - ";
                        echo "<td>{$validade->format("d/m/Y")}</td>";
                        ?>
                    </a>
                </div>
            <?php } ?>

                <a href="../home_prefeitura" class="botao-voltar">Voltar</a>
                
            </div>
        </div>
    </div>
</body>
</html>