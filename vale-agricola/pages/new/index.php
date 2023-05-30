<?php
require_once "../../settings/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $empresas = Empresa::findall();
    
    $nome = trim($_POST["nome"]);
    $cnpj = trim($_POST["cnpj"]);
    $email = trim($_POST["email"]);

    $erro = false;

    foreach ($empresas as $empresa) {
        if (strtolower($empresa->getNome()) === strtolower($nome)) {
            $erro = true;
            $mensagemErro = "O nome já está sendo utilizado.";
            break;
        } else if (strtolower($empresa->getEmail()) === strtolower($email)) {
            $erro = true;
            $mensagemErro = "E-mail já está sendo utilizado.";
            break;
        } else if ($empresa->getCnpj() === $cnpj) {
            $erro = true;
            $mensagemErro = "CNPJ já está sendo utilizado.";
            break;
        }
      if (strlen($cnpj) < 14) {
        $erro = true;
        $mensagemErro = "CNPJ inválido.";
    }

    }

    if ($erro) {
        echo "<div class='div-mensagem-erro'><h3 class='mensagem-erro'>$mensagemErro</h3></div>";
    } else {
        $empresa = new Empresa();
        $empresa->constructorCreate(
            $nome,
            trim($_POST["senha"]),
            $email,
            $cnpj
        );
        $empresa->save();
        header("location: ../new-confirm/");
        exit;
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
            <form action="index.php" method="post" enctype="multipart/form-data" id="create-account-form">

                <label for="cnpj">CNPJ</label>
                <input type="string" name="cnpj" id="cnpj" minlength="14" required>

                <label for="fullname">Nome</label>
                <input type="text" name="nome" id="nome" minlength="3" maxlength="20" required>

                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" maxlength="50" required>

                <label for="password">Senha</label>
                <div>
                  <input type="password" name="senha" id="senha" minlength="6" required>
                  <button type="button" class="olho-senha" name="olho-senha-nova-senha"><i class="fa fa-eye"></i></button>
                </div>

                <label for="password">Confirmar Senha</label>
                <div>
                  <input type="password" name="confirmar-senha" id="confirmar-senha" minlength="6" required>
                  <button type="button" class="olho-senha" name="olho-senha-nova-senha"><i class="fa fa-eye"></i></button>
                </div>

                <input type="submit" value="Criar Conta" class="botao" name="button">

                <a href="../login" class="botao-voltar"><img src="../../settings/imagens/botao-voltar.png" alt=""></a>
            </form>
        </div>
    </div>

    <!-- Incluindo o jQuery e o jQuery Mask Plugin -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script>
      var botoesOlhoSenha = document.getElementsByClassName("olho-senha");

      Array.from(botoesOlhoSenha).forEach(function(botaoOlhoSenha) {
          botaoOlhoSenha.addEventListener("click", function() {
              var senhaInput = this.previousElementSibling;
              
              if (senhaInput.type === "password") {
                  senhaInput.type = "text";
                  this.innerHTML = '<i class="fa fa-eye-slash"></i>';
              } else {
                  senhaInput.type = "password";
                  this.innerHTML = '<i class="fa fa-eye"></i>';
              }
          });
      });

      document.getElementById("create-account-form").addEventListener("submit", function(event) {
          var cnpj = document.getElementById("cnpj").value;
          var nome = document.getElementById("nome").value;
          var email = document.getElementById("email").value;
          var senha = document.getElementById("senha").value;
          var confirmarSenha = document.getElementById("confirmar-senha").value;

          if (cnpj.trim() === '' || nome.trim() === '' || email.trim() === '' || senha.trim() === '' || confirmarSenha.trim() === '' || !isValidEmail(email)) {
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

      $(document).ready(function() {
        $('#nome').mask('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', {
          translation: {
          'A': { pattern: /[A-Za-zÀ-ú\s]/ }
          }
        });
      });

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
</body>
</html>
