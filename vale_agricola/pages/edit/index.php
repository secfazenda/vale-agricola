<?php
require_once "../../settings/config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mode = isset($_COOKIE['mode']) ? $_COOKIE['mode'] : '';
$isDarkMode = $mode === 'dark';

if (isset($_SESSION['idEmpresa'])) {
    $empresa = Empresa::find($_SESSION['idEmpresa']);

    if (isset($_POST["button"])) {

        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);

        if ($nome !== $empresa->getNome() || $email !== $empresa->getEmail()) {
            $empresas = Empresa::findAll();

            $erro = false;
            $mensagemErro = "";

            foreach ($empresas as $outraEmpresa) {
                if ($outraEmpresa->getIdEmpresa() !== $empresa->getIdEmpresa() && $outraEmpresa->getNome() === $nome) {
                    $mensagemErro = "O nome já está sendo utilizado.";
                    $erro = true;
                    break;
                } else if ($outraEmpresa->getIdEmpresa() !== $empresa->getIdEmpresa() && $outraEmpresa->getEmail() === $email) {
                    $mensagemErro = "E-mail já está sendo utilizado.";
                    $erro = true;
                    break;
                }
            }

            if ($erro) {
                echo "<script>alert('$mensagemErro');</script>";
            } else {
                $empresa->setNome($nome);
                $empresa->setEmail($email);
                if ($empresa->save()) {
                    header('location: ../home');
                    exit();
                } else {
                    echo "<script>alert('Ocorreu um erro ao editar o seu perfil');</script>";
                }
            }
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

    <div class="edit-account-util">
        <div class="edit-account">
            <h1 class="titulo">Editar conta</h1>
            <form action="index.php" method="post" enctype="multipart/form-data">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($empresa->getNome()) ?>" required>

                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($empresa->getEmail()) ?>" required>

                <input type="submit" value="Salvar" class="botao" name="button">
            </form>

            <div class="buttons">
                <a href="../edit/edit-senha" class="editar-senha">Editar Senha</a>
                <a class="excluir" href="../delete" onclick="return confirmarExclusao()">Excluir Conta</a>
            </div>
            <a href="../home" class="botao-voltar"><img src="../../settings/imagens/botao-voltar.png" alt=""></a>
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
