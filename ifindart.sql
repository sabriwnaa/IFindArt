-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/12/2024 às 20:19
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
(1, 'Starry Night', 'images/starry_night.jpg'),
(2, 'Mona Lisa', 'images/mona_lisa.jpeg'),
(3, 'The Persistence of Memory', 'images/persistence_of_memory.jpeg'),
(4, 'The Scream', 'images/the_scream.jpeg'),
(5, 'Girl with a Pearl Earring', 'images/girl_with_pearl.jpeg');

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
(1, 'Alice', 'alice@example.com', '$2y$10$bkBQJe00PnATxZjVwLBgFeyK1Fy2jRbep3MSpZPBlzpDhoyhRFNOO'),
(2, 'Bob', 'bob@example.com', '$2y$10$bkBQJe00PnATxZjVwLBgFeyK1Fy2jRbep3MSpZPBlzpDhoyhRFNOO'),
(3, 'Clara', 'clara@example.com', '$2y$10$bkBQJe00PnATxZjVwLBgFeyK1Fy2jRbep3MSpZPBlzpDhoyhRFNOO'),
(4, 'David', 'david@example.com', '$2y$10$bkBQJe00PnATxZjVwLBgFeyK1Fy2jRbep3MSpZPBlzpDhoyhRFNOO'),
(5, 'Emma', 'emma@example.com', '$2y$10$bkBQJe00PnATxZjVwLBgFeyK1Fy2jRbep3MSpZPBlzpDhoyhRFNOO'),
(6, 'gab', 'gabriel@gmail.com', '$2y$10$bkBQJe00PnATxZjVwLBgFeyK1Fy2jRbep3MSpZPBlzpDhoyhRFNOO'),
(7, 'sab', 'sabrina@gmail.com', '$2y$10$cJ8P9eOWlqjXTMQcxAYZM.0sU3XGdrX3vWH0k5UKRYEst1Bpkhv2e'),
(8, 'a', 'coisasserias.com@gmail.com', '$2y$10$hlpIZkU2vO7zYWsBEQAN9OFsFqhz6.yDh8KI242nf.x6qMM1V1DNa'),
(9, 'gab', 'ana.escolar@aluno.feliz.ifrs.edu.br', '$2y$10$/FA5ymLS5AJtazKk0wlpg.QRyvlxR2D73FO9IsNulXthCW8e8Jx8C'),
(10, 'cam', 'camila.melo@aluno.feliz.ifrs.edu.br', '$2y$10$gS.NwUvgCR0Q7IndDuE/5ejcW.YIbdwB9U.Xof8MybE1.d2myyg9i'),
(11, 'bina', 'sa@aluno.feliz.ifrs.edu.br', '$2y$10$.TfiFqGFBNtFu61BkYFpJOhtbALran0.JgcZQClrgTc.xF/hedQNe');

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
(1, 1, 1, 1),
(2, 2, 1, 1),
(3, 3, 2, 1),
(4, 4, 1, 1),
(5, 5, 2, 1),
(6, 1, 3, 1),
(7, 2, 2, 1),
(8, 3, 5, 1),
(9, 4, 5, 1),
(10, 5, 2, 1),
(12, 5, 4, 0),
(13, 5, 5, 0),
(14, 5, 3, 0),
(15, 5, 1, 0),
(16, 5, 2, 0),
(20, 10, 2, 1),
(21, 10, 1, 1),
(22, 10, 1, 1),
(23, 10, 1, 1),
(24, 10, 4, 1),
(25, 10, 4, 0),
(26, 10, 1, 0),
(27, 10, 3, 0),
(28, 10, 3, 0),
(29, 10, 4, 0),
(30, 10, 4, 0),
(31, 10, 4, 0),
(32, 10, 4, 0),
(33, 10, 1, 0),
(34, 10, 4, 0),
(35, 10, 1, 0),
(36, 10, 2, 1),
(37, 10, 4, 1),
(38, 10, 4, 1),
(39, 10, 5, 1),
(40, 10, 3, 1),
(41, 10, 1, 1),
(42, 10, 4, 1),
(43, 10, 5, 1),
(44, 10, 4, 1),
(45, 10, 5, 1),
(46, 10, 2, 1),
(47, 10, 2, 1),
(48, 10, 4, 1),
(49, 10, 3, 0),
(50, 10, 2, 0),
(51, 10, 1, 0),
(52, 10, 4, 0),
(53, 10, 5, 0),
(54, 7, 4, 0),
(55, 7, 5, 0),
(56, 7, 2, 1),
(57, 7, 3, 1),
(58, 7, 1, 0);

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
  MODIFY `idItem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `voto`
--
ALTER TABLE `voto`
  MODIFY `idVoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

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
