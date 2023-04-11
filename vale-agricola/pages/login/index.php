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

				<label for="usuario">Usuário:</label>
				<input type="email" name="email" id="email" required>

				<label for="senha">Senha:</label>
				<input type="password" name="senha" id="senha" maxlength="20" required>

				<a class="create-account" href="../new">Crie sua conta aqui</a>

            	<input type="submit" value="Login" class="botao" name="button">

				<a href="../../index.php">Voltar</a>
			</form>
		</div>
	</div>
</body>
</html>

<!-- Incluindo o jQuery e o jQuery Mask Plugin -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<!-- Aplicando a máscara de usuário -->
<script>
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