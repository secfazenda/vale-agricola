<?php
require_once "../../settings/config.php";
session_start();
if (isset($_SESSION['idEmpresa'])) {
    $empresa = Empresa::find($_SESSION['idEmpresa']);
    if (isset($_POST["button"])) {

        $empresa->setNome(trim($_POST['nome']));
        $empresa->setEmail(trim($_POST['email']));
        $empresa->setCnpj(trim($_POST['cnpj']));

        if ($empresa->save()) {
            header('location: ../home');
        } else {
            echo "<script>alert('Ocorreu um erro ao editar o seu perfil');</script>";
        };
    }
} else {
    header("location: ../login");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../home/style.css">

    <link rel="stylesheet" href="style.css">
    <title>Vale Agrícola | Editar Conta </title>

</head>

<body>
<div class="edit-account-util">
    <div class="edit-account">
        <h1 class="titulo">Editar conta</h1>
        <form action="index.php" method="post" enctype="multipart/form-data">

            <label for="nome">Usuário:</label>
            <input type="text" name="nome" id="nome" value="<?php echo $empresa->getNome() ?>" required>

            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" value="<?php echo $empresa->getEmail() ?>" required>

            <input type="submit" value="Editar" class="botao" name="button">
            <!-- <button type="submit" name="excluir">Excluir conta</button> -->
        </form>
        <a class="excluir" href="../delete" onclick="return confirmarExclusao()">Excluir Conta</a>
        <a class="go-home" href="../home">Voltar para a tela inicial</a>
    </div>
</div>

<script>
    /*
    document.querySelector('.botao').addEventListener('click', function() {
    if (window.confirm("Tem certeza que deseja editar sua conta?")) {
        confirmarEdicao();
    } else {
        event.preventDefault();
    }
    });

    function confirmarEdicao() {
    var confirmacao = window.confirm("Sua conta foi editada com sucesso.");
    window.location.href = '../home';
    }

    window.confirm = function (mensagem) {
    return !!window.confirm(mensagem.toString().replace("OK", "Sim"));
    };
    */


      
    document.querySelector('.botao').addEventListener('click', function() {
    if (confirm("Tem certeza que deseja editar sua conta?")) {
        alert("Sua conta foi editada com sucesso.");
        //confirmarEdicao();
    } else {
        event.preventDefault();
    }
    });

    /* function confirmarEdicao() {
    alert("Sua conta foi editada com sucesso.");
    } */
    /*
    function confirmarExclusao() {
        if (confirm("Tem certeza que deseja excluir sua conta?")) {
          alert("Sua conta foi excluída com sucesso.");
          return true;
        } else {
          return false;
        }
    } */
    /*
    function confirmarEdicao() {
        if (confirm("Tem certeza que deseja editar sua conta?")) {
          alert("Sua conta foi editada com sucesso.");
          return true;
        } else {
          return false;
        }
    } */
</script>

</body>
</html>