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
		<div class="login">
			<h1 class="titulo">Vale Agrícola</h1>
			<form action="index.php" method="post" enctype="multipart/form-data">

				<label for="usuario">E-mail:</label>
				<input type="email" name="email" id="email" required placeholder="Digite seu e-mail aqui">

				<label for="senha">Senha:</label>
				<input type="password" name="senha" id="senha" maxlength="20" required placeholder="Digite sua senha aqui">
        <button type="button" id="olho-senha"><i class="fa fa-eye"></i></button>

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

				<a class="create-account" href="../new">Crie sua conta aqui</a>

            	<input type="submit" value="Login" class="botao" name="button">

				<a href="../../index.php">Voltar</a>
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