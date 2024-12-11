-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/12/2024 às 12:36
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

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
(21, 'Yoko Ono', 'Yokoono.jpg'),
(23, 'Billie Eilish', '1000056928.jpg');

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
(14, 'claudinha', 'claudia.hahn@aluno.feliz.ifrs.edu.br', '$2y$10$vIVy2Ai7cDCfk.8f08ujG.JGLFG3bNQZXcazEePx5vQGICczD7KPK'),
(15, 'Diogo', 'diogo@aluno.feliz.ifrs.edu.br', '$2y$10$I/5BJJ3AlUKpkq.E3lmIuuW7T66PXgMiKY75bU4YBaq32I/Om2teS'),
(16, 'Ana', 'ana.escobar@aluno.feliz.ifrs.edu.br', '$2y$10$A3iHP1jM4Ty4H6nYnGIL1uVHrQBszqLbIajn8b8CTDnauW0SnWIV.'),
(17, 'gab', 'gabriel@aluno.feliz.ifrs.edu.br', '$2y$10$9T1ihqiJflh5Sa4sxRC.z.Mp4nCmW6egAyIyGjRgAa3MLK4xxgva.'),
(18, 'auler', 'auler@aluno.feliz.ifrs.edu.br', '$2y$10$Kum1W7upihNtb44Js6HcSugOHVcmj7K00SggHjEeLGKORGw/cXK1S');

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
(93, 14, 8, 1),
(94, 16, 19, 1),
(95, 16, 11, 1),
(96, 16, 7, 1),
(97, 16, 16, 1),
(112, 12, 7, 1),
(127, 17, 20, 1),
(128, 17, 19, 1),
(129, 17, 9, 1),
(130, 17, 17, 1),
(132, 17, 10, 1),
(133, 17, 14, 1),
(134, 17, 15, 1),
(135, 17, 8, 1),
(136, 17, 11, 1),
(137, 17, 16, 1),
(138, 17, 12, 1),
(139, 17, 18, 1),
(140, 17, 13, 1),
(141, 17, 23, 1),
(142, 17, 21, 1),
(143, 17, 7, 1),
(144, 18, 16, 1);

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
  MODIFY `idItem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `voto`
--
ALTER TABLE `voto`
  MODIFY `idVoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

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
