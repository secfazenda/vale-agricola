-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11-Jul-2023 às 19:22
-- Versão do servidor: 10.4.28-MariaDB
-- versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `vale-agricola`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `documento`
--

CREATE TABLE `documento` (
  `idDocumento` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `validade` date DEFAULT NULL,
  `pdf` blob NOT NULL,
  `idEmpresa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `documento`
--

INSERT INTO `documento` (`idDocumento`, `nome`, `validade`, `pdf`, `idEmpresa`) VALUES
(49, 'Patrimonio', '2023-07-07', 0x2e2e2f2e2e2f646f63756d656e746f732f416c696d656e7461c3a7c3a36f2042616c616e63656164612e706466, 119);

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresa`
--

CREATE TABLE `empresa` (
  `idEmpresa` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cnpj` varchar(18) DEFAULT NULL,
  `habilitada` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `empresa`
--

INSERT INTO `empresa` (`idEmpresa`, `nome`, `senha`, `email`, `cnpj`, `habilitada`) VALUES
(1, 'Prefeitura', '$2y$10$gcVOgSxcOdmk/BXEdLtar.4Zgfzc/3a/bWH.zTHq6yQgFBWmLeTAy', 'marcelo.ost7@gmail.com', '92.123.926/0001-92', 0),
(119, 'Marcelo Agroferagem', '$2y$10$Hp8.jq9hTpnU4irSQingGuFWNyAfkwkSqKISjT2CjvVP3YCU3r1/O', 'marcelo@gmail.com', '20.548.484/1548-48', 0),
(120, 'Agro Ost', '$2y$10$j4MimnucpTAmEZ1NVJpxN.WZK438VgNf4mjQAg8ZskI0F2zgSNVTG', 'agroindrustria@gmail.com', '02.154.789/5422-36', 0),
(121, 'Agroferagem Marcelo', '$2y$10$Ivg1tIk506Qgsj3DQnAji.yzZxk9Kbj/Qqg9eQC65UdejaLlAkTjG', 'marceloost17@gmail.com', '06.250.652/0520-50', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`idDocumento`),
  ADD KEY `fk_empresa_documento` (`idEmpresa`);

--
-- Índices para tabela `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idEmpresa`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `documento`
--
ALTER TABLE `documento`
  MODIFY `idDocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de tabela `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idEmpresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `fk_empresa_documento` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
