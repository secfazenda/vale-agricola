<?php
require_once "../../settings/config.php";

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
                $empresa->setSenha($novaSenha);
                $empresa->setNome(trim($_POST['nome']));
                $empresa->setEmail(trim($_POST['email']));
                $empresa->setCnpj(trim($_POST['cnpj']));

                if ($empresa->save()) {
                    header('location: ../home');
                    exit();
                } else {
                    echo "<script>alert('Ocorreu um erro ao editar o seu perfil');</script>";
                }
            } else {
                echo "<script>alert('A nova senha e a confirmação de senha não coincidem');</script>";
            }
        } else {
            echo "<script>alert('A senha atual está incorreta');</script>";
        }
    }
} else {
    header("location: ../login");
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

    <title>Vale Agrícola | Editar Conta</title>
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

    <div class="edit-account-util">
        <div class="edit-account">
            <h1 class="titulo">Editar conta</h1>
            <form action="index.php" method="post" enctype="multipart/form-data">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($empresa->getNome()) ?>" required>

                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($empresa->getEmail()) ?>" required>

                <label for="senha_atual">Senha atual</label>
                <input type="password" name="senha_atual" id="senha_atual" required>

                <label for="nova_senha">Nova senha</label>
                <input type="password" name="nova_senha" id="nova_senha" required>

                <label for="confirmar_senha">Confirmar nova senha</label>
                <input type="password" name="confirmar_senha" id="confirmar_senha" required>

                <input type="submit" value="Editar" class="botao" name="button">
            </form>

            <div class="buttons">
                <a class="excluir" href="../delete" onclick="return confirmarExclusao()">Excluir Conta</a>
                <a href="../home" class="botao-voltar"><img src="../../settings/imagens/botao-voltar.png" alt=""></a>
            </div>
        </div>
    </div>

    <script>
        function validarEmail(email) {
            let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return regex.test(email);
        }

        document.querySelector('.botao').addEventListener('click', function(event) {
            var nome = document.getElementById("nome").value;
            var email = document.getElementById("email").value;

            if (nome.trim() === '' || !validarEmail(email)) {
                alert("Por favor, preencha os campos corretamente.");
                event.preventDefault();
            } else if (confirm("Tem certeza que deseja editar sua conta?")) {
                alert("Sua conta foi editada com sucesso.");
            } else {
                event.preventDefault();
            }
        });

        function confirmarExclusao() {
            if (confirm("Tem certeza que deseja excluir sua conta?")) {
                alert("Sua conta foi excluída com sucesso.");
                return true;
            } else {
                return false;
            }
        }
    </script>

</body>

</html>
