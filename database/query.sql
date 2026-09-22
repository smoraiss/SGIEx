-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/09/2026 às 03:33
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
CREATE DATABASE sgiex;
USE sgiex;
--
-- Banco de dados: `sgiex`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `administrador`
--

CREATE TABLE `administrador` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `pfp` varchar(255) NOT NULL,
  `data_criacao` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `administrador`
--

INSERT INTO `administrador` (`id`, `usuario`, `senha`, `nome` `ativo`, `pfp`, `data_criacao`) VALUES
(1, 'Admin', '!@Rondon123', 'Admin', 1, '', '2026-09-15 21:35:22,');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chamados`
--

CREATE TABLE `chamados` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED DEFAULT NULL,
  `protocolo` text NOT NULL,
  `nome_guerra` varchar(255) NOT NULL,
  `posto_graduacao` varchar(255) NOT NULL,
  `secao` varchar(255) NOT NULL,
  `ip_solicitante` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '',
  `prioridade` varchar(255) NOT NULL DEFAULT 'BAIXA',
  `data_abertura` datetime NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `data_fechamento` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chamados`
--

INSERT INTO `chamados` (`id`, `usuario_id`, `protocolo`, `nome_guerra`, `posto_graduacao`, `secao`, `ip_solicitante`, `descricao`, `status`, `prioridade`, `data_abertura`, `data_atualizacao`, `data_fechamento`) VALUES
(42, 4, 'SGI-D8432831B3E1', 'Roberto', 'Cap', '3', '::1', 'Tive um problema aqui', '', 'ALTA', '2026-09-16 20:47:39', '2026-09-16 20:47:39', NULL),
(43, 12, 'SGI-CC1757D0B333', 'Matheus', 'Maj', 'E3', '::1', 'Problemas!!', '', 'CRITICA', '2026-09-16 21:03:52', '2026-09-16 21:03:52', NULL),
(44, 13, 'SGI-5E04A4E01ADB', 'Roger', 'Cap', 'E1', '::1', 'Roger', '', 'MEDIA', '2026-09-16 21:05:38', '2026-09-16 21:05:38', NULL),
(45, 14, 'SGI-FD966D63B81A', 'fd', '3º Sgt', 'E3', '::1', 'A', '', 'MEDIA', '2026-09-16 21:13:05', '2026-09-16 21:13:05', NULL),
(46, 4, 'SGI-CA0182E0C762', 'fd', 'Ten Cel', 'Adj Cmdo', '::1', 'asa', '', 'MEDIA', '2026-09-21 21:33:43', '2026-09-21 21:33:43', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `comentarios_chamados`
--

CREATE TABLE `comentarios_chamados` (
  `id` int(10) UNSIGNED NOT NULL,
  `chamado_id` int(10) UNSIGNED NOT NULL,
  `autor_tipo` enum('SOLICITANTE','ADM') NOT NULL,
  `autor_nome` varchar(100) DEFAULT NULL,
  `comentario` text NOT NULL,
  `data_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico_chamados`
--

CREATE TABLE `historico_chamados` (
  `id` int(10) UNSIGNED NOT NULL,
  `chamado_id` int(10) UNSIGNED NOT NULL,
  `acao` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `data_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(10) UNSIGNED NOT NULL,
  `posto_graduacao` varchar(20) NOT NULL,
  `secao` varchar(100) NOT NULL,
  `ip_ultimo_acesso` varchar(45) NOT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `posto_graduacao`, `secao`, `ip_ultimo_acesso`, `data_cadastro`, `data_atualizacao`) VALUES
(4, 'Cel', 'E6', '::1', '2026-09-17 00:49:23', '2026-09-17 00:49:23'),
(12, 'Maj', 'E3', '::1', '2026-09-16 21:03:52', '2026-09-16 21:03:52'),
(13, 'Cap', 'E1', '::1', '2026-09-16 21:05:38', '2026-09-16 21:05:38'),
(14, '3º Sgt', 'E3', '::1', '2026-09-16 21:13:05', '2026-09-16 21:13:05');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Índices de tabela `chamados`
--
ALTER TABLE `chamados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `protocolo` (`protocolo`) USING HASH,
  ADD KEY `idx_ip_solicitante` (`ip_solicitante`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_data_abertura` (`data_abertura`),
  ADD KEY `fk_chamados_usuario` (`usuario_id`);

--
-- Índices de tabela `comentarios_chamados`
--
ALTER TABLE `comentarios_chamados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_chamado_id` (`chamado_id`);

--
-- Índices de tabela `historico_chamados`
--
ALTER TABLE `historico_chamados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_chamado_id` (`chamado_id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ip_ultimo_acesso` (`ip_ultimo_acesso`),
  ADD KEY `idx_secao` (`secao`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `chamados`
--
ALTER TABLE `chamados`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de tabela `comentarios_chamados`
--
ALTER TABLE `comentarios_chamados`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `historico_chamados`
--
ALTER TABLE `historico_chamados`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `chamados`
--
ALTER TABLE `chamados`
  ADD CONSTRAINT `fk_chamados_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `comentarios_chamados`
--
ALTER TABLE `comentarios_chamados`
  ADD CONSTRAINT `comentarios_chamados_ibfk_1` FOREIGN KEY (`chamado_id`) REFERENCES `chamados` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `historico_chamados`
--
ALTER TABLE `historico_chamados`
  ADD CONSTRAINT `historico_chamados_ibfk_1` FOREIGN KEY (`chamado_id`) REFERENCES `chamados` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
