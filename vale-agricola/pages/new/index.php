<?php

require_once "../../settings/config.php";
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

if (isset($_POST["button"])) {
  $empresas = Empresa::findall();
  
  $nome = trim($_POST["nome"]);
  $cnpj = trim($_POST["cnpj"]);
  $email = trim($_POST["email"]);

  $erro = false;

  foreach ($empresas as $empresa) {
    if($empresa->getNome() == $nome){
      echo "<div class='div-mensagem-erro'><h3 class='mensagem-erro'>O nome já está sendo utilizado.</h3></div>";
      $erro = true;
      break;
    } else if($empresa->getEmail() == $email){
      echo "<div class='div-mensagem-erro'><h3 class='mensagem-erro'>E-mail já está sendo utilizado.</h3></div>";
      $erro = true;
      break;
    } else if($empresa->getCnpj() == $cnpj){
      echo "<div class='div-mensagem-erro'><h3 class='mensagem-erro'>Cnpj já está sendo utilizado.</h3></div>";
      $erro = true;
      break;
    }
  }

  if (!$erro){
    $empresa = new Empresa();
    $empresa->constructorCreate(
      $nome,
      trim($_POST["senha"]),
      $email,
      $cnpj
    );
    $empresa->save();
    header("location: ../new-confirm/");
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vale Agrícola | Criar Conta</title>
  <script src="scripts.js"></script>
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

    <div class="create-account-util">
        <div class="create-account">
            <h1 class="titulo">Criar Conta</h1>
            <form action="index.php" method="post" enctype="multipart/form-data">

                <label for="cnpj">Cnpj</label>
                <input type="string" name="cnpj" id="cnpj" minlength="14" required>

                <label for="fullname">Nome</label>
                <input type="text" name="nome" id="nome" minlength="3" maxlength="20" required>

                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" required>

                <label for="password">Senha</label>
                <input type="password" name="senha" id="senha" minlength="6" required>

                <label for="password">Confirmar Senha</label>
                <input type="password" name="confirmar-senha" id="confirmar-senha" minlength="6" required>

                <input type="submit" value="Criar Conta" class="botao" name="button">

                <a href="../login" class="botao-voltar"><img src="../../settings/imagens/botao-voltar.png" alt=""></a>
            </form>
        </div>
    </div>
</body>
</html>

<!-- Incluindo o jQuery e o jQuery Mask Plugin -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
  document.querySelector('.botao').addEventListener('click', function() {
    var cnpj = document.getElementById("cnpj").value;
    var nome = document.getElementById("nome").value;
    var email = document.getElementById("email").value;
    var senha = document.getElementById("senha").value;
    var confirmarSenha = document.getElementById("confirmar-senha").value;
    //alert("Sua conta foi criada com sucesso.");
    // Não está conseguindo passar por dentro desse if 

    if (cnpj.trim() === '' || nome.trim() === '' || email.trim() === '' || senha.trim() === '' || confirmarSenha.trim() === '' || !validarEmail(email)) {
        alert("Por favor, preencha os campos corretamente.");
        event.preventDefault();
    } else if (senha !== confirmarSenha) {
        alert("As senhas não coincidem.");
        event.preventDefault();
    } else {
        alert("Sua conta foi criada com sucesso.");
        // confirmarCriacao();
    }
});
</script>

<!-- Aplicando a máscara de CNPJ -->
<script>
$(document).ready(function(){
  $('#cnpj').mask('00.000.000/0000-00', {
    onComplete: function(cnpj) {
      var cnpjLength = cnpj.replace(/\D/g, '').length;
      if (cnpjLength < 14) {
        $('#cnpj').val('');
      }
    }
  });
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
$(document).ready(function(){
  $('#confirmar-senha').on('input', function() {
    if ($(this).val() != $('#senha').val()) {
      this.setCustomValidity("As senhas não coincidem");
    } else {
      this.setCustomValidity('');
    }
  });
});

</script>