<?php

require_once "../../settings/config.php";
ini_set('error_reporting', E_ALL); 
ini_set('display_errors', 1);

if (isset($_POST["button"])) {
    $empresa = new Empresa();
    $empresa->constructorCreate(
        trim($_POST["nome"]),
        trim($_POST["senha"]),
        trim($_POST["email"]),
        $_POST["cnpj"]
    ); 
    $empresa->save();
    
    header("location: ../new-confirm/");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../../assets/images/olifx_logo.png" type="image/png">
  <title>Vale Agrícola | Criar conta</title>
  <script src="scripts.js"></script>
  <link rel="stylesheet" href="new.css">
</head>
<body>
    <section class="form">
        <h1 class="titulo">Criar Conta</h1>
        <form action="index.php" method="post" enctype="multipart/form-data">

            <label for="cnpj">Cnpj:</label>
            <input type="string" name="cnpj" id="cnpj" required>

            <label for="fullname">Nome:</label>
            <input type="text" name="nome" id="nome" required>

            <label for="email">E-Mail:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Senha:</label>
            <input type="password" name="senha" id="senha" maxlength="20" required>

            <input type="submit" value="Criar" name="button" class="botao">

            <a href="../login">Voltar</a>
        </form>
    </section>
</body>
</html>

<!-- Incluindo o jQuery e o jQuery Mask Plugin -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<!-- Aplicando a máscara de CNPJ -->
<script>
$(document).ready(function(){
  $('#cnpj').mask('00.000.000/0000-00');
});
</script>

<!-- Aplicando a máscara de Nome -->
<script>
  $(document).ready(function() {
    $('#nome').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {
      translation: {
      'A': { pattern: /[A-Za-zÀ-ú\s]/ }
      }
    });
  });
</script>

<!-- Aplicando a máscara de e-mail -->
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