-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/09/2026 às 03:08
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

INSERT INTO `administrador` (`id`, `usuario`, `senha`, `nome`, `ativo`, `pfp`, `data_criacao`) VALUES
(1, 'Admin', '!@Rondon123', 'Admin', 1, '', '2026-09-15 21:35:22');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chamados`
--

CREATE TABLE `chamados` (
  `id` int(10) UNSIGNED NOT NULL,
  `protocolo` varchar(20) NOT NULL,
  `nome_guerra` varchar(100) NOT NULL,
  `posto_graduacao` varchar(20) NOT NULL,
  `secao` varchar(100) NOT NULL,
  `ip_solicitante` varchar(45) NOT NULL,
  `identificador_cookie` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `status` enum('ABERTO','EM_ATENDIMENTO','AGUARDANDO_SOLICITANTE','RESOLVIDO','FECHADO','CANCELADO') NOT NULL DEFAULT 'ABERTO',
  `prioridade` enum('BAIXA','MEDIA','ALTA','CRITICA') NOT NULL DEFAULT 'BAIXA',
  `data_abertura` datetime NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `data_fechamento` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chamados`
--

INSERT INTO `chamados` (`id`, `protocolo`, `nome_guerra`, `posto_graduacao`, `secao`, `ip_solicitante`, `identificador_cookie`, `descricao`, `status`, `prioridade`, `data_abertura`, `data_atualizacao`, `data_fechamento`) VALUES
(1, '20260916023307256', 'Roberto', 'SDEV', 'SGI', '127.0.0.1', '02d0f36ebd772a16af82dfe0c1e8d0eac8fb5c3650bee199a18d6957365ad7f9', 'a', 'ABERTO', 'BAIXA', '2026-09-15 21:33:07', '2026-09-15 21:33:07', NULL);

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
  `identificador_cookie` varchar(255) NOT NULL,
  `nome_guerra` varchar(100) NOT NULL,
  `posto_graduacao` varchar(20) NOT NULL,
  `secao` varchar(100) NOT NULL,
  `ip_ultimo_acesso` varchar(45) NOT NULL,
  `data_cadastro` datetime NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD UNIQUE KEY `protocolo` (`protocolo`),
  ADD KEY `idx_ip_solicitante` (`ip_solicitante`),
  ADD KEY `idx_cookie` (`identificador_cookie`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_data_abertura` (`data_abertura`);

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
  ADD UNIQUE KEY `identificador_cookie` (`identificador_cookie`),
  ADD KEY `idx_nome_guerra` (`nome_guerra`),
  ADD KEY `idx_ip_ultimo_acesso` (`ip_ultimo_acesso`),
  ADD KEY `idx_secao` (`secao`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `chamados`
--
ALTER TABLE `chamados`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

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
ALTER TABLE chamados ADD COLUMN usuario_id INT UNSIGNED NULL AFTER id;
ALTER TABLE chamados ADD CONSTRAINT fk_chamados_usuario FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE;