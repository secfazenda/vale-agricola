<?php
require_once "../../../settings/config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mode = isset($_COOKIE['mode']) ? $_COOKIE['mode'] : '';
$isDarkMode = $mode === 'dark';

if (isset($_SESSION['idEmpresa'])) {
    $empresa = Empresa::find($_SESSION['idEmpresa']);

    if (isset($_POST["button"])) {
        $senhaAtual = $_POST['senha_atual'];
        $novaSenha = $_POST['nova_senha'];
        $confirmarSenha = $_POST['confirmar_senha'];

        function senhaCorreta($senha, $empresa) {
            $senhaArmazenada = $empresa->getSenha();
            return password_verify($senha, $senhaArmazenada);
        }

        if (senhaCorreta($senhaAtual, $empresa)) {
            if ($novaSenha === $confirmarSenha) {
                if ($empresa->atualizarSenha($novaSenha)) {
                    header('location: ../../home');
                    exit();
                } else {
                    echo "<script>alert('Ocorreu um erro ao editar a sua senha');</script>";
                }
            } else {
                echo "<script>alert('A nova senha e a confirmação de senha não coincidem');</script>";
            }
        } else {
            echo "<script>alert('A senha atual está incorreta');</script>";
        }
    }
} else {
    header("location: ../../login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vale Agrícola | Editar Senha</title>
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
            <img src="../../../settings/imagens/logo-alto-feliz-brasao.png" alt="brasaoaf">
        </div>
        <div class="logo">
            <img src="../../../settings/imagens/logo-alto-feliz-letras.png" alt="logoaf">
        </div>
        <div class="icone" onclick="toggleDarkMode()">
            <img src="../../../settings/imagens/icone-contraste.png" alt="iconedl">
        </div>
    </header>
    <div class="edit-senha-util">
        <div class="edit-senha">
            <h1 class="titulo">Editar Senha</h1>
            <form action="index.php" method="post" enctype="multipart/form-data">
            <div class="input-wrapper">
    <label for="senha_atual">Senha atual</label>
    <div class="input-group">
        <input type="password" name="senha_atual" id="senha_atual" minlength="6" required>
        <button type="button" class="olho-senha" name="olho-senha-senha-atual"><i class="fa fa-eye"></i></button>
    </div>
</div>

<div class="input-wrapper">
    <label for="nova_senha">Nova senha</label>
    <div class="input-group">
        <input type="password" name="nova_senha" id="nova_senha" minlength="6" required>
        <button type="button" class="olho-senha" name="olho-senha-nova-senha"><i class="fa fa-eye"></i></button>
    </div>
</div>

<div class="input-wrapper">
    <label for="confirmar_senha">Confirmar nova senha</label>
    <div class="input-group">
        <input type="password" name="confirmar_senha" id="confirmar_senha" required>
        <button type="button" class="olho-senha" name="olho-senha-confirmar-senha"><i class="fa fa-eye"></i></button>
    </div>
</div>

                
                <input type="submit" value="Salvar" class="botao" name="button">
            </form>
            <a href="../../home" class="botao-voltar"><img src="../../../settings/imagens/botao-voltar.png" alt=""></a>
        </div>
    </div>
</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
<script>
var botoesOlhoSenha = document.getElementsByClassName("olho-senha");

Array.from(botoesOlhoSenha).forEach(function(botaoOlhoSenha) {
    botaoOlhoSenha.addEventListener("click", function() {
        var senhaInput = this.previousElementSibling;
        
        if (senhaInput.type === "password") {
            senhaInput.type = "text";
            this.innerHTML = '<i class="fa fa-eye-slash"></i>';
        } else {
            senhaInput.type = "password";
            this.innerHTML = '<i class="fa fa-eye"></i>';
        }
    });
});
</script>
