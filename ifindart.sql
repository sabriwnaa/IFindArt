-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10/12/2024 às 21:34
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ifindart`
--
CREATE DATABASE IF NOT EXISTS `ifindart` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ifindart`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `item`
--

CREATE TABLE `item` (
  `idItem` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `imagem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `item`
--

INSERT INTO `item` (`idItem`, `titulo`, `imagem`) VALUES
(7, 'Clarice Lispector', 'Claricelispector.png'),
(8, 'Carolina Maria De Jesus', 'carolina.jpg'),
(9, 'João Guimarães Rosa', 'guimaraesrosa.webp'),
(10, 'Machado de Assis', 'machado.jpg'),
(11, 'Lygia Fagundes Telles', 'lygia.jpg'),
(12, 'Elis Regina', 'elis.jpg'),
(13, 'Gal Costa', 'gal.jpg'),
(14, 'Caetano Veloso', 'caetano.jpg'),
(15, 'Gilberto Gil', 'gil.jpg'),
(16, 'Maria Bethânia', 'beth.jpeg'),
(17, 'Fernanda Montenegro', 'fernanda-montenegro.jpg'),
(18, 'Mar Becker', 'marbecker.jpg'),
(19, 'Kehinde Wiley', 'kehinde.jpg'),
(20, 'Jenny Saville', 'JennySaville.jpg'),
(21, 'Yoko Ono', 'Yokoono.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nome` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `senha` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nome`, `email`, `senha`) VALUES
(12, 'sabriwnaa', 'sabrina.melo@aluno.feliz.ifrs.edu.br', '$2y$10$YE1cFMOX0jiunz/JV879Eu8o5y0b9j95Wx7xpRHS1DfsRQvmM8KkW'),
(13, 'camizota', 'camila.melo@aluno.feliz.ifrs.edu.br', '$2y$10$iNXnl64nyw2etRyoFRYs0eWKMsyQtt3qlPHTiiTpxw98EvcsvfCy6'),
(14, 'claudinha', 'claudia.hahn@aluno.feliz.ifrs.edu.br', '$2y$10$vIVy2Ai7cDCfk.8f08ujG.JGLFG3bNQZXcazEePx5vQGICczD7KPK');

-- --------------------------------------------------------

--
-- Estrutura para tabela `voto`
--

CREATE TABLE `voto` (
  `idVoto` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idItem` int(11) NOT NULL,
  `isLike` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `voto`
--

INSERT INTO `voto` (`idVoto`, `idUsuario`, `idItem`, `isLike`) VALUES
(59, 12, 10, 1),
(60, 12, 14, 0),
(61, 12, 20, 0),
(62, 12, 11, 1),
(63, 12, 17, 1),
(64, 12, 7, 1),
(65, 12, 16, 1),
(66, 12, 13, 1),
(67, 12, 12, 1),
(68, 12, 21, 1),
(69, 12, 18, 1),
(70, 12, 15, 1),
(71, 12, 9, 0),
(72, 12, 8, 1),
(73, 12, 19, 1),
(74, 13, 12, 0),
(75, 13, 18, 1),
(76, 13, 19, 0),
(77, 13, 15, 1),
(78, 13, 11, 0),
(79, 13, 17, 1),
(80, 13, 16, 1),
(81, 13, 10, 0),
(82, 13, 14, 1),
(83, 13, 13, 0),
(84, 13, 9, 0),
(85, 13, 21, 1),
(86, 13, 7, 1),
(87, 13, 20, 0),
(88, 13, 8, 1),
(89, 14, 10, 1),
(90, 14, 11, 1),
(91, 14, 17, 1),
(92, 14, 20, 0),
(93, 14, 8, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`idItem`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Índices de tabela `voto`
--
ALTER TABLE `voto`
  ADD PRIMARY KEY (`idVoto`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idItem` (`idItem`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `item`
--
ALTER TABLE `item`
  MODIFY `idItem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `voto`
--
ALTER TABLE `voto`
  MODIFY `idVoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `voto`
--
ALTER TABLE `voto`
  ADD CONSTRAINT `voto_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `voto_ibfk_2` FOREIGN KEY (`idItem`) REFERENCES `item` (`idItem`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
