<?php
require_once "../../settings/config.php";
session_start();

$mode = isset($_COOKIE['mode']) ? $_COOKIE['mode'] : '';
$isDarkMode = $mode === 'dark';

if (!isset($_SESSION["idEmpresa"])) {
    header("location: ../login");
}

$empresas = Empresa::findall($_SESSION['idEmpresa']);
$documentos = Documento::findallByEmpresa($_SESSION['idEmpresa']);

// Função de comparação para ordenar as empresas pelo nome
function compararEmpresas($a, $b) {
    return strcmp($a->getNome(), $b->getNome());
}

// Ordenar as empresas pelo nome
usort($empresas, 'compararEmpresas');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vale Agrícola | Página de Administração</title>
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
            <?php echo "<h2 class='titulo'>Olá ".$_SESSION['nome'].", Bem-vindo(a)! <br></h2>";?>
            <h2 class="subtitulo">Lista de Empresas</h2>
            <?php foreach($empresas as $empresa) {
                if ($empresa->getIdEmpresa() !== 1) {
                    ?>
                    <a href="../ver_documentos?idEmpresa=<?php echo $empresa->getIdEmpresa(); ?>" class="empresa">
                        <div class="lista-empresas">
                            <tr>
                                <div class="nome-uppercase">
                                    <td class="campo-nome"><?php echo $empresa->getNome(); ?></td>
                                </div>
                                <td class="campo-cnpj"><?php echo $empresa->getCnpj(); ?></td> --- 
                                <td class="campo-email"><?php echo $empresa->getEmail(); ?></td>
                                <td class="campo-habilitada">
                                    <form method="POST" action="habilitada.php">
                                        <input type="hidden" name="idEmpresa" value="<?php echo $empresa->getIdEmpresa(); ?>">
                                        <button class="button-habilitar" type="submit" name="habilitar" value="1">Habilitar</button>
                                        <button class="button-desabilitar" type="submit" name="habilitar" value="0">Desabilitar</button>
                                    </form>
                                </td>
                            </tr>
                        </div>
                    </a>
                    <?php
                }
            } ?>

            <div class="buttons">
                <!--<a href="../new-document" class="botao-cadastrar">Cadastrar Documento</a>-->
                <a href="../edit_prefeitura" class="botao-editar">Editar Conta</a>
                <!--<a href="../../enviar_email" class="botao-enviar-email">Enviar Avisos</a>-->
                <a href="../logout" class="botao-sair">Sair</a>
            </div>
        </div>
    </div>
    
</body>
</html>
