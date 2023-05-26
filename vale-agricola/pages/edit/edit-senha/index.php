<?php
require_once "../../../settings/config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="../../../settings/imagens/logo-alto-feliz.png" alt="logoaf">
        </div>
        <div class="icone">
            <img src="../../../settings/imagens/icone-contraste.png" alt="iconedl">
        </div>
    </header>
    <div class="edit-senha-util">
        <div class="edit-senha">
            <h1 class="titulo">Editar Senha</h1>
            <form action="index.php" method="post" enctype="multipart/form-data">
                <label for="senha_atual">Senha atual</label>
                <input type="password" name="senha_atual" id="senha_atual" required>

                <label for="nova_senha">Nova senha</label>
                <input type="password" name="nova_senha" id="nova_senha" required>

                <label for="confirmar_senha">Confirmar nova senha</label>
                <input type="password" name="confirmar_senha" id="confirmar_senha" required>
             
                <input type="submit" value="Salvar" class="botao" name="button">
            </form>
            <a href="../../home" class="botao-voltar"><img src="../../../settings/imagens/botao-voltar.png" alt=""></a>
        </div>
    </div>
</body>
</html>
