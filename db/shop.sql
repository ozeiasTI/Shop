

CREATE TABLE `empresa` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senhaapp` varchar(100) NOT NULL,
  `telefone` varchar(50) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `cnpj` varchar(25) NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `empresa`
--

INSERT INTO `empresa` (`id`, `nome`, `email`, `senhaapp`, `telefone`, `endereco`, `cnpj`, `logo`) VALUES
(1, 'Irmãos Souza ', 'ozeeiiaass@gmail.com', 'riex qacl krtb eqmu', '(69) 993654721', 'av das dores , 2589', '00000000000', 'ChatGPT Image 9 de jul. de 2025, 21_37_48.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `funcao` varchar(50) NOT NULL,
  `cpf` varchar(14) DEFAULT NULL,
  `data_nascimento` varchar(12) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `telefone` varchar(255) DEFAULT NULL,
  `ativo` varchar(5) DEFAULT 'SIM'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `funcao`, `cpf`, `data_nascimento`, `endereco`, `foto`, `data_cadastro`, `telefone`, `ativo`) VALUES
(1, 'Ozeias Meira Santos de Souza', 'ozeias.souza@ifro.edu.br', '123', 'Administrador', '033.662.282-10', '1998-08-12', 'Av guaporé, n° 3230', '1669471212336.jpg', '2025-07-08 17:39:39', '(69) 92726386', 'SIM'),
(4, 'Kelly ', 'kelly.cordeiro@ifro.edu.br', 'entre@rios#kelly', 'Vendedor', '033.662.282-11', '1997-07-10', 'SESI', 'sansa-e-uma-gata-que-foi-abandonada-mas-conseguiu-ser-adotada-e-hoje-bomba-no-instagram-1601056796152_v2_450x600.jpg', '2025-07-09 16:10:13', '3545456549864546', 'SIM');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de tabela `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
