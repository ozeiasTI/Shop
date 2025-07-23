-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23/07/2025 às 18:55
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
-- Banco de dados: `shop`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `anotacoes`
--

CREATE TABLE `anotacoes` (
  `id_anotacoes` int(11) NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(200) DEFAULT NULL,
  `mensagem` text DEFAULT NULL,
  `categoria_anotacoes` varchar(50) DEFAULT NULL,
  `data_execucao` date DEFAULT NULL,
  `status_anotacoes` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `caixa`
--

CREATE TABLE `caixa` (
  `id_caixa` int(10) UNSIGNED NOT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `tipo` varchar(30) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `data_movimentacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `referencia` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(10) UNSIGNED NOT NULL,
  `descricao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `contas`
--

CREATE TABLE `contas` (
  `id_conta` int(11) NOT NULL,
  `descricao_conta` varchar(50) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `status_conta` varchar(20) DEFAULT NULL,
  `data_lancamento` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_acerto` date DEFAULT NULL,
  `forma_acerto` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresa`
--

CREATE TABLE `empresa` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senhaapp` varchar(100) NOT NULL,
  `telefone` varchar(50) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `cnpj` varchar(25) NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `empresa`
--

INSERT INTO `empresa` (`id`, `nome`, `email`, `senhaapp`, `telefone`, `cidade`, `endereco`, `cnpj`, `logo`) VALUES
(1, 'Hardware Store', 'ozeeiiaass@gmail.com', 'riex qacl krtb eqmu', '(69) 993654721', 'Vilhena', 'av das dores , 2589', '00000000000', 'logo.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id_fornecedor` int(10) UNSIGNED NOT NULL,
  `nome` varchar(150) DEFAULT NULL,
  `cnpj` varchar(30) DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `ramo` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimentacao_estoque`
--

CREATE TABLE `movimentacao_estoque` (
  `id_movimentacao` int(10) UNSIGNED NOT NULL,
  `tipo` varchar(10) NOT NULL,
  `produto_id` int(10) UNSIGNED DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `data_movimentacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `valor` decimal(10,2) DEFAULT NULL,
  `observacao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacoes`
--

CREATE TABLE `notificacoes` (
  `id` int(11) NOT NULL,
  `titulo` varchar(50) NOT NULL,
  `usuario_id` int(10) UNSIGNED DEFAULT NULL,
  `mensagem` text DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_conclusao` date DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Aberta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id_produto` int(10) UNSIGNED NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `categoria_id` int(10) UNSIGNED DEFAULT NULL,
  `preco_custo` decimal(10,2) DEFAULT NULL,
  `preco_venda` decimal(10,2) DEFAULT NULL,
  `estoque_total` int(11) DEFAULT NULL,
  `fornecedor_id` int(10) UNSIGNED DEFAULT NULL,
  `estoque_minimo` int(11) DEFAULT NULL,
  `ativo` varchar(10) DEFAULT 'Sim',
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `setor` varchar(100) NOT NULL,
  `funcao` varchar(50) NOT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `data_nascimento` varchar(12) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `telefone` varchar(255) DEFAULT NULL,
  `ativo` varchar(5) DEFAULT 'SIM',
  `codigo_recuperacao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `setor`, `funcao`, `cpf`, `data_nascimento`, `endereco`, `foto`, `data_cadastro`, `telefone`, `ativo`, `codigo_recuperacao`) VALUES
(1, 'Ozeias Meira Santos de Souza', 'ozeias.souza@ifro.edu.br', '123', 'Gerência', 'Administrador', '033.662.282-10', '1998-08-12', 'Av guaporé, n° 3230', '1669471212336.jpg', '2025-07-08 21:39:39', '6992726386', 'SIM', 'i957q333');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `anotacoes`
--
ALTER TABLE `anotacoes`
  ADD PRIMARY KEY (`id_anotacoes`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `caixa`
--
ALTER TABLE `caixa`
  ADD PRIMARY KEY (`id_caixa`);

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices de tabela `contas`
--
ALTER TABLE `contas`
  ADD PRIMARY KEY (`id_conta`);

--
-- Índices de tabela `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id_fornecedor`);

--
-- Índices de tabela `movimentacao_estoque`
--
ALTER TABLE `movimentacao_estoque`
  ADD PRIMARY KEY (`id_movimentacao`),
  ADD KEY `produto_id` (`produto_id`);

--
-- Índices de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `fornecedor_id` (`fornecedor_id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `anotacoes`
--
ALTER TABLE `anotacoes`
  MODIFY `id_anotacoes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `caixa`
--
ALTER TABLE `caixa`
  MODIFY `id_caixa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `contas`
--
ALTER TABLE `contas`
  MODIFY `id_conta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de tabela `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id_fornecedor` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `movimentacao_estoque`
--
ALTER TABLE `movimentacao_estoque`
  MODIFY `id_movimentacao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `anotacoes`
--
ALTER TABLE `anotacoes`
  ADD CONSTRAINT `anotacoes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `movimentacao_estoque`
--
ALTER TABLE `movimentacao_estoque`
  ADD CONSTRAINT `movimentacao_estoque_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id_produto`);

--
-- Restrições para tabelas `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD CONSTRAINT `notificacoes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_ibfk_1` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedor` (`id_fornecedor`),
  ADD CONSTRAINT `produto_ibfk_2` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id_categoria`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
