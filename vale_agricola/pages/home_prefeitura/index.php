<?php
require_once "../../settings/config.php";
session_start();

if (!isset($_SESSION["idEmpresa"])) {
    header("location: ../login");
}

$empresas = Empresa::findall($_SESSION['idEmpresa']);
$documentos = Documento::findallByEmpresa($_SESSION['idEmpresa']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vale Agrícola | Página de Administração</title>
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
            <?php echo "<h2 class='titulo'>Olá ".$_SESSION['nome'].", Bem-vindo(a)! <br></h2>";?>
            <h2 class="subtitulo">Lista de Documentos</h2>
            <?php foreach($empresas as $empresa) {
            if ($empresa->getIdEmpresa() !== 1) {
                ?>
                <div class="lista-empresas">
                    <a href="../ver_documentos?idEmpresa=<?php echo $empresa->getIdEmpresa(); ?>" class="empresa">
                        <table class="lista-empresas">
                            <tr>
                                <td class="campo-nome"><?php echo $empresa->getNome(); ?></td>
                                <td class="campo-cnpj"><?php echo $empresa->getCnpj(); ?></td>
                                <td class="campo-email"><?php echo $empresa->getEmail(); ?></td>
                            </tr>
                        </table>
                    </a>
                </div>
                <?php
            }
        } ?>

            <div class="buttons">
            <!--<a href="../new-document" class="botao-cadastrar">Cadastrar Documento</a> -->
                <a href="../edit_prefeitura" class="botao-editar">Editar Conta</a>
                <a href="../logout" class="botao-sair">Sair</a>
                <a href="../../enviar_email" class="botao-enviar-email">Enviar Avisos</a>
            </div>
        </div>
    </div>
    
</body>
</html>