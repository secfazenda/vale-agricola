<?php
require_once __DIR__.'/settings/config.php';
session_start();


// Verifica se o cookie de modo está definido
$mode = isset($_COOKIE['mode']) ? $_COOKIE['mode'] : '';

// Verifica se o modo é dark
$isDarkMode = $mode === 'dark';

$empresas = Empresa::findall();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/olifx_logo.png" type="image/png">
    <link rel="stylesheet" href="style.css">
    <title>Vale Agrícola</title>
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
            <img src="settings/imagens/logo-alto-feliz-brasao.png" alt="brasaoaf">
        </div>
        <div class="logo">
            <img src="settings/imagens/logo-alto-feliz-letras.png" alt="logoaf">
        </div>
        <div class="icone" onclick="toggleDarkMode()">
            <img src="settings/imagens/icone-contraste.png" alt="iconedl">
        </div>
    </header>
    <div class="homepage-container">
        <div class="homepage-util-area">
            <div class="hp-superior-part">
                <div class="hp-title">
                    <h1 class="titulo">Bem-vindo(a) ao Vale Agrícola</h1>
                </div>
                
                <div class="hp-bottom-part">
                    <div class="hp-button-space">
                        <a href="./pages/login" class="hp-button">Login</a>
                    </div>
                </div>

                <div class="tabela-empresas">
                    <h3 class="titulo-tabela">Lista de Empresas Credenciadas</h3>
                    <?php foreach($empresas as $empresa) {
                        if ($empresa->getIdEmpresa() !== 1) {
                            ?>
                            <p href="../ver_documentos?idEmpresa=<?php echo $empresa->getIdEmpresa(); ?>" class="empresa">
                                <div class="lista-empresas">
                                    <tr>
                                        <div class="nome-uppercase">
                                            <td class="campo-nome">- <?php echo $empresa->getNome(); ?></td>
                                        </div>
                                    </tr>
                                </div>
                            </p>
                        <?php
                        }
                    } ?>
                </div>


            </div>
            <div class="hp-mid-part">
                <div class="hp-subtitle">
                    <h3 class="subtitulo">Como funciona?</h3>
                </div>
                <div class="content">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;O incentivo concedido aos agricultores sob forma de Vale Agrícola, de acordo com o disposto na <a href="https://cespro.com.br/visualizarDiploma.php?cdMunicipio=7221&cdDiploma=20211468&NroLei=1.468&Word=&Word2=" class="link">Lei 1211/2017</a> e alterações instituídas pela Lei 1468/2021,  prevê o reembolso, mediante apresentação de nota fiscal de compras de mudas, produtos e insumos agrícolas, ferramentas agrícolas e combustíveis na Prefeitura Municipal.</p>

                    <p>&nbsp;&nbsp;&nbsp;&nbsp;Dos bônus já gerados e ainda válidos, referentes à produção do ano de 2018 e 2019, 30% pode ser gasto nos estabelecimentos acima relacionados. A contar do ano de 2021, ano base 2020, este valor passa a ser de 40% do valor, uma das alterações instituídas pela lei 1468.</p>

                    <p>&nbsp;&nbsp;&nbsp;&nbsp;O limite a ser concedido de bônus também passou para R$2000,00 por produtor, um aumento de mais de 100% em comparação ao que era concedido até então, ao mesmo tempo que foi retirado o critério de um  valor mínimo para ter direito ao benefício.</p>

                    <p>&nbsp;&nbsp;&nbsp;&nbsp;O valor do bônus ao qual o produtor tem direito é de 1,6% do Valor Adicionado Fiscal gerado no ano base. 

                    <p>&nbsp;&nbsp;&nbsp;&nbsp;Para ser beneficiado, o produtor deverá adquirir a mercadoria em um  dos estabelecimentos credenciados e solicitar a inclusão do seu CPF na nota fiscal. Somente serão aceitas notas com CPF do titular  do talão de produtor que deu origem ao bônus. </p>

                    <p>&nbsp;&nbsp;&nbsp;&nbsp;Após, o produtor se dirige à prefeitura municipal com esta nota fiscal, e protocola pedido de ressarcimento, indicando uma conta bancária da qual seja titular.</p>

                    <p>&nbsp;&nbsp;&nbsp;&nbsp;De posse dos documentos indicados, a Secretaria da Fazenda emitirá o empenho em favor do produtor e transferirá o valor devido para a conta bancária indicada.</p>

                    <p>&nbsp;&nbsp;&nbsp;&nbsp;O produtor poderá apresentar notas de mais de um estabelecimento, porém, será feito somente um empenho para cada ano base de Bônus, ou seja, deverá resgatar todo o valor de uma só vez, não sendo permitido fracionamento do valor.</p>

                    <p>Obs.: Se o produtor possuir dívidas com o município referentes a serviços de máquinas prestados e de materiais fornecidos pelo município, o bônus gerados será automaticamente usado para quitar estes débitos.</p>
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>