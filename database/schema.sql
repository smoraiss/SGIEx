-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/09/2026 às 00:18
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
-- Banco de dados: `sgiex`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(10) UNSIGNED NOT NULL,
  `identificador_cookie` varchar(255) NOT NULL,
  `nome_guerra` varchar(100) NOT NULL,
  `posto_graduacao` varchar(20) NOT NULL,
  `secao` varchar(100) NOT NULL,
  `ip_ultimo_acesso` varchar(45) NOT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `identificador_cookie`, `nome_guerra`, `posto_graduacao`, `secao`, `ip_ultimo_acesso`, `data_cadastro`, `data_atualizacao`) VALUES
(1, 'c10KRgNBQgAQJ1hZRARDQgQUe10KEABCF1QXewteEwQRTAMQdgxdQFBCFgAXclZXF1RKEFNLdlhdQFATEFIUekNvbnZlcnRlcg==', 'Bw5OJQweAgRDb252ZXJ0ZXI=', 'Dg4EQ29udmVydGVy', 'BlxDb252ZXJ0ZXI=', 'cl1ZWFVcREtDQ29udmVydGVy', '2026-09-15 22:34:37', '2026-09-15 23:16:59'),
(3, '', '', '', '', '', '2026-09-16 19:00:57', '2026-09-16 19:00:57');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identificador_cookie` (`identificador_cookie`),
  ADD KEY `idx_nome_guerra` (`nome_guerra`),
  ADD KEY `idx_ip_ultimo_acesso` (`ip_ultimo_acesso`),
  ADD KEY `idx_secao` (`secao`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
