<?php
require_once "../../settings/config.php";
session_start();

$mode = isset($_COOKIE['mode']) ? $_COOKIE['mode'] : '';
$isDarkMode = $mode === 'dark';

if (!isset($_SESSION["idEmpresa"])) {
    header("location: ../login");
    exit;
}

if (!isset($_GET["idEmpresa"])) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

$idEmpresa = $_GET["idEmpresa"];

if ($idEmpresa == 1) {
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

$documentos = Documento::findallByEmpresa($idEmpresa);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vale Agrícola | Documentos da Empresa</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function toggleDarkMode() {
            var body = document.body;
            var isDarkMode = body.classList.toggle('dark-mode');
            
            // Define um cookie para lembrar a preferência de modo
            document.cookie = 'mode=' + (isDarkMode ? 'dark' : 'light') + '; expires=Fri, 31 Dec 9999 23:59:59 UTC; path=/';
        }
    </script>
</head>
<body <?php if ($isDarkMode) echo 'class="dark-mode"'; ?>>
    <header class="header">
        <div class="brasao">
            <img src="../../settings/imagens/logo-alto-feliz-brasao.png" alt="brasaoaf">
        </div>
        <div class="logo">
            <img src="../../settings/imagens/logo-alto-feliz-letras.png" alt="logoaf">
        </div>
        <div class="icone" onclick="toggleDarkMode()">
            <img src="../../settings/imagens/icone-contraste.png" alt="iconedl">
        </div>
    </header>

    <div class="home-page-util">
        <div class="home-page">
            <h2 class="titulo">Documentos da Empresa</h2>
            <?php if (empty($documentos)) { ?>
                <p class="nenhum-doc">Nenhum documento cadastrado para essa empresa.</p>
            <?php } else { ?>
                <?php foreach ($documentos as $documento) { ?>
                    <?php
                    $caminhoDocumento = '../../documentos/' . $documento->getIdDocumento() . '/' . $documento->getPdf();
                    ?>
                    <a href="<?php echo $caminhoDocumento; ?>" download="<?php echo basename($caminhoDocumento); ?>" class="document">
                        <p><?php echo $documento->getNome();?> - <?php echo $documento->getValidade()->format("d/m/Y"); ?></p>
                    </a>
                <?php } ?>
            <?php } ?>
            
            <div class="buttons">
                <a href="../home_prefeitura" class="botao-voltar">Voltar</a>
                <a class="botao-excluir" href="../delete_parte_prefeitura?idEmpresa=<?php echo $idEmpresa; ?>" onclick="return confirmarExclusao()">Excluir Empresa</a>
                <!--<a href="../../enviar_email/enviarEmail.php">Enviar Email</a>-->
            </div>
        </div>
    </div>
    
</body>
</html>

<script>
    function confirmarExclusao() {
        if (confirm("Tem certeza que deseja excluir sua conta?")) {
            alert("Sua conta foi excluída com sucesso.");
            return true;
        } else {
            return false;
        }
    }
</script>
