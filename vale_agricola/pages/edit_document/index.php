<?php
require_once "../../settings/config.php";
session_start();

$mode = isset($_COOKIE['mode']) ? $_COOKIE['mode'] : '';
$isDarkMode = $mode === 'dark';

if (isset($_GET["idDocumento"])) {
    $idDocumento = $_GET["idDocumento"];

    $documento = Documento::findByID($idDocumento);

    if ($documento) {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome = $_POST["nome"];
            $validade = $_POST["validade"];

            $documento->setNome($nome);
            $documento->setValidade(DateTime::createFromFormat('Y-m-d', $validade));
            $documento->save();
            header("location: ../home");
        }
    } else {
        echo "Documento não encontrado.";
        exit();
    }
} else {
    echo "ID do documento não foi fornecido na URL.";
    exit();
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
    <link rel="stylesheet" href="style.css">
    <script>
        function toggleDarkMode() {
            var body = document.body;
            var isDarkMode = body.classList.toggle('dark-mode');
            
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

    <div class="edit-document-util">
        <div class="edit-document">
            <h1 class="titulo">Editar Documento</h1>

            <form action="index.php?idDocumento=<?php echo $idDocumento; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idDocumento" value="<?php echo $idDocumento; ?>">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" value="<?php echo $documento->getNome(); ?>" minlength="3" maxlength="20" required><br>
                <label for="validade">Validade</label>
                <input type="date" id="validade" name="validade" value="<?php echo $documento->getValidade()->format("Y-m-d"); ?>"><br>

                <input type="submit" value="Salvar" class="botao" name="button">
            </form>
                        
            <?php
                $caminhoDocumento = '../../documentos/?idDocumento=<?php echo $idDocumento; ?>' . $documento->getPdf();

            ?>

            <?php
            $caminhoDocumento = '../../documentos/' . $idDocumento . '/' . $documento->getPdf();
            ?>

            <div class="buttons">
                <a href="<?php echo $caminhoDocumento; ?>" download="<?php echo basename($caminhoDocumento); ?>" class="botao-baixar">Baixar Documento</a>
            
                <a class="botao-excluir" href="../delete_document?idDocumento=<?php echo $documento->getIdDocumento(); ?>" onclick="return confirmarExclusao()">Excluir Documento</a>
            </div>
            <a href="../home" class="botao-voltar"><img src="../../settings/imagens/botao-voltar.png" alt=""></a>
            
        </div>
    </div>

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
</body>
</html>
