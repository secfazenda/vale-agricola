<?php

require_once __DIR__."/../../settings/config.php";

if (isset($_POST["button"])) {
    $empresa = new Empresa();
    $empresa->constructLogin($_POST["email"], $_POST["senha"]);    
    
    $id_da_prefeitura = 1;

    if ($empresa->authenticate($_SESSION['idEmpresa'])) {
        if ($_SESSION['idEmpresa'] == $id_da_prefeitura) {
            header("Location: ../home_prefeitura");
            exit();
        } else {
            header("Location: ../home");
            exit();
            }
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vale Agrícola | Login</title>
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
    <div class="login-util">
        <div class="login">
            <h1 class="titulo">Login</h1>
            
            <form action="index.php" method="post" enctype="multipart/form-data">

                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" required>
    
                <label for="senha">Senha</label>
                <div class="div-senha">
                    <input type="password" name="senha" id="senha" maxlength="50" required>
                    <button type="button" id="olho-senha" name="olho-senha"><i class="fa fa-eye"></i></button>
                </div>
                
                <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
                <script>
                var senha = document.getElementById("senha");
                var olhoSenha = document.getElementById("olho-senha");

                olhoSenha.addEventListener("click", function() {
                    if (senha.type === "password") {
                    senha.type = "text";
                    olhoSenha.innerHTML = '<i class="fa fa-eye-slash"></i>';
                    } else {
                    senha.type = "password";
                    olhoSenha.innerHTML = '<i class="fa fa-eye"></i>';
                    }
                });
                </script>
            
                <input type="submit" value="Login" class="botao" name="button">

                <a class="create-account" href="../new">Crie sua conta aqui</a>

                <a href="../../index.php" class="botao-voltar"><img src="../../settings/imagens/botao-voltar.png" alt=""></a>

            </form>
        </div>
    </div>
</body>
</html>
<script>
// <!-- Incluindo o jQuery e o jQuery Mask Plugin -->
src="https://code.jquery.com/jquery-3.6.0.min.js">
src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js">

// <!-- Aplicando a máscara de usuário -->

$(document).ready(function(){
  $('#email').mask("A", {
    translation: {
      "A": { pattern: /[\w@\-.+]/, recursive: true }
    }
  }).on("blur", function(){
    let email = $(this).val();
    if(!isValidEmail(email)){
      $(this).val("");
    }
  });
});

function isValidEmail(email) {
  let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return regex.test(email);
}
</script>