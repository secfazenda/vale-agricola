<?php

require_once __DIR__."/../../settings/config.php";

if (isset($_POST["button"])) {
    $empresa = new Empresa();
    $empresa->constructLogin($_POST["email"], $_POST["senha"]);
    
    if ($empresa->authenticate()) {
        header("location: ../home");
    } else {
        header("location: index.php");
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Vale Agrícola | Login</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="login-util">
    <header class="header">
        <div class="logo">
            <img src="../../settings/imagens/logo-alto-feliz.png" alt="logoaf">
        </div>
        <div class="icone">
            <img src="../../settings/imagens/icone-contraste.png" alt="iconedl">
        </div>
    </header>
		<div class="login">
      <div class="form-util">
        <form action="index.php" method="post" enctype="multipart/form-data">
        <div class="titulo">  
          <h1 claas="titulo">Login</h1>
        </div>
        <div class="div-email">
          <label for="email">E-mail</label>
          <input type="email" name="email" id="email" required placeholder="Digite seu e-mail aqui">
        </div>
        <div class="div-senha">
          <label for="senha">Senha</label>
          <input type="password" name="senha" id="senha" maxlength="20" required placeholder="Digite sua senha aqui">
          <button type="button" id="olho-senha"><i class="fa fa-eye"></i></button>
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
          
          <div class="div-login">
            <input type="submit" value="Login" class="botao" name="button">
          </div class="botao-voltar">
          <div class="div-criar-conta">
            <a class="create-account" href="../new">Crie sua conta aqui</a>
          </div>
          <div class="div-sair">
            <a href="../../index.php"><img src="../../settings/imagens/botao-voltar.png" alt="" class="botao-voltar"></a>
          </div>
			  </form>
      </div>
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