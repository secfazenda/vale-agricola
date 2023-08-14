<?php
require_once "../../settings/config.php";
session_start();

if (!isset($_SESSION["idEmpresa"])) {
    header("location: ../login");
}

$mode = isset($_COOKIE['mode']) ? $_COOKIE['mode'] : '';
$isDarkMode = $mode === 'dark';

$documentos = Documento::findallByEmpresa($_SESSION['idEmpresa']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vale Agrícola | Página de Usuário</title>
    <link rel="stylesheet" href="style.css">
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

    <div class="home-page-util">
        <div class="home-page">
        <?php echo "<h2 class='titulo'>Olá ".$_SESSION['nome'].", <span id='saudacao'></span>! <br></h2>";?>
            <h2 class="subtitulo">Lista de Documentos</h2>
            <?php foreach($documentos as $documento){?>
                <div>
                <a href="../edit_document?idDocumento=<?php echo $documento->getIdDocumento(); ?>" class="document">
                <div class="informacoes-documento">
                        <div>
                            <?php 
                            echo "<td>{$documento->getNome()}</td>";
                            ?>
                        </div>
                        <div>
                            <?php 
                            $validade = $documento->getValidade();
                            echo "Validade - <td>{$validade->format("d/m/Y")}</td>";
                            ?>
                        </div>
                        <!-- Comentei o trecho abaixo pois não está claro o que é o campo PDF -->
                        <div>
                            <?php 
                            // echo "<td>{$documento->getPdf()}</td>";
                            ?>
                        </div>
                    </div>

                    </a>
                </div>
            <?php } ?>
            
            <div class="buttons">
                <a href="../new_document" class="botao-cadastrar">Cadastrar Documento</a>
                <a href="../edit" class="botao-editar">Editar Conta</a>
                <a href="../logout" class="botao-sair">Sair</a>
            </div>
        </div>
    </div>
</body>
</html>

<script>
    function confirmarExclusao() {
        if (confirm("Tem certeza que deseja excluir esse documento?")) {
            alert("Documento excluído com sucesso.");
            return true;
        } else {
            return false;
        }
    }

  function saudacaoPorHorario() {
    const data = new Date();
    const hora = data.getHours();

    let saudacao;

    if (hora >= 5 && hora < 12) {
      saudacao = "Bom dia";
    } else if (hora >= 12 && hora < 18) {
      saudacao = "Boa tarde";
    } else {
      saudacao = "Boa noite";
    }

    return saudacao;
  }

  const saudacaoElemento = document.getElementById("saudacao");
  const saudacao = saudacaoPorHorario();
  saudacaoElemento.textContent = saudacao;

</script>
