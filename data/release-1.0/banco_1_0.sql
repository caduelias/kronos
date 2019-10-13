-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 06-Out-2019 às 23:46
-- Versão do servidor: 5.7.27-0ubuntu0.18.04.1
-- PHP Version: 7.2.19-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `banco_1.0`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `Admin`
--

CREATE TABLE `Admin` (
  `codigo_admin` int(11) NOT NULL,
  `nome` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `tipo` varchar(15) NOT NULL,
  `ativo` tinyint(4) NOT NULL,
  `data` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Admin`
--

INSERT INTO `Admin` (`codigo_admin`, `nome`, `email`, `senha`, `tipo`, `ativo`, `data`) VALUES
(1, 'master', 'master@email.com', '$2y$10$isZqdku0a.2TyusFhPcxVufXs8nqy3QeGnkt15.kp7YS39hIIqFl2', 'master', 1, '2019-10-06'),
(57, 'admin', '', '$2y$10$YP0uxsBe1J9sEo4TBoLS.e/VSqs8jSU6ZVcWOhBk5F1cJxllW7bYC', 'admin', 1, '2019-10-06'),
(64, 'bryan', '', '$2y$10$JSEZfSklJBE5bIZVPOG8n.XZAO4sYWtoNaowq/5T1jaQmKrLGdm0K', 'instrutor', 1, '2019-10-06'),
(65, 'joao', '', '$2y$10$JQu8vlfAmZAxrANS8WMnIuM15LccrFaW3.Vu1V9PxBJNYERt8XQv.', 'admin', 1, '2019-10-06'),
(68, 'felipe', '', '$2y$10$1H6Iybb.hwCx7AYbJoFSpOb7rZDX0z1kiXCsPv84AKaMxbyqX3tG.', 'admin', 1, '2019-10-06'),
(69, 'karyne', '', '$2y$10$HmIsdupI5tq7XNMDd5SEUOBbuS50h6.ofTqHN73NNhLMZFTCJy66O', 'instrutor', 1, '2019-10-06'),
(70, 'fernanda', '', '$2y$10$rl3M5MCxJyrIUNYfyXVfM.XjrkQ3hca04RNVZ6boEPuM2QxrZLme.', 'instrutor', 1, '2019-10-06'),
(71, 'erika', '', '$2y$10$DSJmZLGzKG.VnzWVpMkk3OOCNle1G6UzZH1PCfsV05ltlBKmW1sby', 'admin', 1, '2019-10-06'),
(72, 'cadu', 'cadu85718@gmail.f', '$2y$10$MqRa/TJd9.zaVcg8LO3eWOhHFfXthhESX28LOURxyJvwUsF8QGM1W', 'admin', 1, '2019-10-06'),
(73, 'Cintia', '', '$2y$10$/HDHE245lj0GKLW9YD1BxeAPzDKO7Rp9e/UWHZtfWQ6G9uvPC85Aq', 'admin', 0, '2019-10-06');

-- --------------------------------------------------------

--
-- Estrutura da tabela `Aluno`
--

CREATE TABLE `Aluno` (
  `codigo_aluno` int(11) NOT NULL,
  `nome_aluno` varchar(100) NOT NULL,
  `data_nasc` date NOT NULL,
  `sexo` char(1) NOT NULL,
  `rg` varchar(15) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `objetivo` varchar(50) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `ativo` tinyint(4) NOT NULL,
  `tipo` tinyint(4) NOT NULL,
  `codigo_tipo` int(11) DEFAULT NULL,
  `Horario_codigo_horario` int(11) NOT NULL,
  `Modalidade_codigo_modalidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Aluno_Plano`
--

CREATE TABLE `Aluno_Plano` (
  `codigo_AlunoPlano` int(11) NOT NULL,
  `valor_total` float NOT NULL,
  `data_vencimento` date NOT NULL,
  `valor_recebido` float DEFAULT NULL,
  `data_pagamento` date DEFAULT NULL,
  `parcelas` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `Plano_codigo_plano` int(11) NOT NULL,
  `Aluno_codigo_aluno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Antropometria`
--

CREATE TABLE `Antropometria` (
  `codigo_antropometria` int(11) NOT NULL,
  `Avaliacao_codigo_avaliacao` int(11) NOT NULL,
  `peitoral` float DEFAULT NULL,
  `b_esquerdo` float DEFAULT NULL,
  `b_direito` float DEFAULT NULL,
  `antebraco_d` float DEFAULT NULL,
  `antebraco_e` float DEFAULT NULL,
  `cintura` float DEFAULT NULL,
  `quadril` float DEFAULT NULL,
  `culote` float DEFAULT NULL,
  `c_direita` float DEFAULT NULL,
  `c_esquerda` float DEFAULT NULL,
  `p_direita` float DEFAULT NULL,
  `p_esquerda` float DEFAULT NULL,
  `panturrilha_e` float DEFAULT NULL,
  `panturrilha_d` float DEFAULT NULL,
  `restricao` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Avaliacao`
--

CREATE TABLE `Avaliacao` (
  `codigo_avaliacao` int(11) NOT NULL,
  `Aluno_codigo_aluno` int(11) NOT NULL,
  `data_avaliacao` date NOT NULL,
  `idade` int(11) NOT NULL,
  `peso` float NOT NULL,
  `altura` float NOT NULL,
  `gordura` float DEFAULT NULL,
  `musculo` float DEFAULT NULL,
  `agua` float DEFAULT NULL,
  `imc` float DEFAULT NULL,
  `ossea` float DEFAULT NULL,
  `caloria` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Dobra`
--

CREATE TABLE `Dobra` (
  `codigo_dobra` int(11) NOT NULL,
  `Antropometria_codigo_antropometria` int(11) NOT NULL,
  `axilar_media` float DEFAULT NULL,
  `suprailiaca` float DEFAULT NULL,
  `coxa` float DEFAULT NULL,
  `panturrilha_medial` float DEFAULT NULL,
  `subescapular` float DEFAULT NULL,
  `triceps` float DEFAULT NULL,
  `abdominal` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Endereco`
--

CREATE TABLE `Endereco` (
  `codigo_endereco` int(11) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `bairro` varchar(45) NOT NULL,
  `rua` varchar(45) NOT NULL,
  `numero` varchar(15) NOT NULL,
  `Aluno_codigo_aluno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Exercicio`
--

CREATE TABLE `Exercicio` (
  `codigo_exercicio` int(11) NOT NULL,
  `Treino_codigo_treino` int(11) NOT NULL,
  `tipo` varchar(30) NOT NULL,
  `nome_exercicio` varchar(100) NOT NULL,
  `serie_repeticao` varchar(15) DEFAULT NULL,
  `imagem` varchar(100) DEFAULT NULL,
  `descricao` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Horario`
--

CREATE TABLE `Horario` (
  `codigo_horario` int(11) NOT NULL,
  `periodo` varchar(30) NOT NULL,
  `horario_treino` time NOT NULL,
  `limite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Login`
--

CREATE TABLE `Login` (
  `codigo_usuario` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `ativo` tinyint(4) NOT NULL,
  `Admin_codigo_admin` int(11) NOT NULL,
  `Aluno_codigo_aluno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Modalidade`
--

CREATE TABLE `Modalidade` (
  `codigo_modalidade` int(11) NOT NULL,
  `nome_modalidade` varchar(50) NOT NULL,
  `ativo` tinyint(4) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL,
  `horario` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Plano`
--

CREATE TABLE `Plano` (
  `codigo_plano` int(11) NOT NULL,
  `ativo` tinyint(4) NOT NULL,
  `nome_plano` varchar(50) NOT NULL,
  `taxa_adesao` float NOT NULL,
  `mensalidade` float NOT NULL,
  `descricao` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Telefone`
--

CREATE TABLE `Telefone` (
  `codigo_telefone` int(11) NOT NULL,
  `num_telefone` varchar(15) NOT NULL,
  `num_celular` varchar(15) DEFAULT NULL,
  `Aluno_codigo_aluno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Treino`
--

CREATE TABLE `Treino` (
  `codigo_treino` int(11) NOT NULL,
  `nome_treino` varchar(100) NOT NULL,
  `duracao` varchar(20) NOT NULL,
  `descricao` text,
  `ordem_treino` int(11) DEFAULT NULL,
  `peso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Treino_Modalidade`
--

CREATE TABLE `Treino_Modalidade` (
  `Modalidade_codigo_modalidade` int(11) NOT NULL,
  `Treino_codigo_treino` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`codigo_admin`);

--
-- Indexes for table `Aluno`
--
ALTER TABLE `Aluno`
  ADD PRIMARY KEY (`codigo_aluno`),
  ADD KEY `fk_Aluno_Horario1_idx` (`Horario_codigo_horario`),
  ADD KEY `fk_Aluno_Modalidade1_idx` (`Modalidade_codigo_modalidade`);

--
-- Indexes for table `Aluno_Plano`
--
ALTER TABLE `Aluno_Plano`
  ADD PRIMARY KEY (`codigo_AlunoPlano`),
  ADD KEY `fk_Aluno_Plano_Plano1_idx` (`Plano_codigo_plano`),
  ADD KEY `fk_Aluno_Plano_Aluno1_idx` (`Aluno_codigo_aluno`);

--
-- Indexes for table `Antropometria`
--
ALTER TABLE `Antropometria`
  ADD PRIMARY KEY (`codigo_antropometria`),
  ADD UNIQUE KEY `Avaliacao_codigo_avaliacao_UNIQUE` (`Avaliacao_codigo_avaliacao`),
  ADD KEY `fk_Antropometria_Avaliacao1_idx` (`Avaliacao_codigo_avaliacao`);

--
-- Indexes for table `Avaliacao`
--
ALTER TABLE `Avaliacao`
  ADD PRIMARY KEY (`codigo_avaliacao`),
  ADD KEY `fk_Avaliacao_Aluno1_idx` (`Aluno_codigo_aluno`);

--
-- Indexes for table `Dobra`
--
ALTER TABLE `Dobra`
  ADD PRIMARY KEY (`codigo_dobra`),
  ADD KEY `fk_Dobra_Antropometria1_idx` (`Antropometria_codigo_antropometria`);

--
-- Indexes for table `Endereco`
--
ALTER TABLE `Endereco`
  ADD PRIMARY KEY (`codigo_endereco`),
  ADD KEY `fk_Endereco_Aluno1_idx` (`Aluno_codigo_aluno`);

--
-- Indexes for table `Exercicio`
--
ALTER TABLE `Exercicio`
  ADD PRIMARY KEY (`codigo_exercicio`),
  ADD KEY `fk_Exercicio_Treino1_idx` (`Treino_codigo_treino`);

--
-- Indexes for table `Horario`
--
ALTER TABLE `Horario`
  ADD PRIMARY KEY (`codigo_horario`);

--
-- Indexes for table `Login`
--
ALTER TABLE `Login`
  ADD PRIMARY KEY (`codigo_usuario`),
  ADD KEY `fk_Usuario_Admin1_idx` (`Admin_codigo_admin`),
  ADD KEY `fk_Login_Aluno1_idx` (`Aluno_codigo_aluno`);

--
-- Indexes for table `Modalidade`
--
ALTER TABLE `Modalidade`
  ADD PRIMARY KEY (`codigo_modalidade`);

--
-- Indexes for table `Plano`
--
ALTER TABLE `Plano`
  ADD PRIMARY KEY (`codigo_plano`);

--
-- Indexes for table `Telefone`
--
ALTER TABLE `Telefone`
  ADD PRIMARY KEY (`codigo_telefone`),
  ADD KEY `fk_Telefone_Aluno1_idx` (`Aluno_codigo_aluno`);

--
-- Indexes for table `Treino`
--
ALTER TABLE `Treino`
  ADD PRIMARY KEY (`codigo_treino`);

--
-- Indexes for table `Treino_Modalidade`
--
ALTER TABLE `Treino_Modalidade`
  ADD PRIMARY KEY (`Modalidade_codigo_modalidade`,`Treino_codigo_treino`),
  ADD KEY `fk_Treino_has_Modalidade_Modalidade1_idx` (`Modalidade_codigo_modalidade`),
  ADD KEY `fk_Treino_has_Modalidade_Treino1_idx` (`Treino_codigo_treino`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admin`
--
ALTER TABLE `Admin`
  MODIFY `codigo_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT for table `Aluno`
--
ALTER TABLE `Aluno`
  MODIFY `codigo_aluno` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Aluno_Plano`
--
ALTER TABLE `Aluno_Plano`
  MODIFY `codigo_AlunoPlano` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Antropometria`
--
ALTER TABLE `Antropometria`
  MODIFY `codigo_antropometria` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Avaliacao`
--
ALTER TABLE `Avaliacao`
  MODIFY `codigo_avaliacao` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Dobra`
--
ALTER TABLE `Dobra`
  MODIFY `codigo_dobra` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Endereco`
--
ALTER TABLE `Endereco`
  MODIFY `codigo_endereco` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Exercicio`
--
ALTER TABLE `Exercicio`
  MODIFY `codigo_exercicio` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Horario`
--
ALTER TABLE `Horario`
  MODIFY `codigo_horario` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Login`
--
ALTER TABLE `Login`
  MODIFY `codigo_usuario` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Modalidade`
--
ALTER TABLE `Modalidade`
  MODIFY `codigo_modalidade` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Plano`
--
ALTER TABLE `Plano`
  MODIFY `codigo_plano` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Telefone`
--
ALTER TABLE `Telefone`
  MODIFY `codigo_telefone` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Treino`
--
ALTER TABLE `Treino`
  MODIFY `codigo_treino` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `Aluno`
--
ALTER TABLE `Aluno`
  ADD CONSTRAINT `fk_Aluno_Horario1` FOREIGN KEY (`Horario_codigo_horario`) REFERENCES `Horario` (`codigo_horario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Aluno_Modalidade1` FOREIGN KEY (`Modalidade_codigo_modalidade`) REFERENCES `Modalidade` (`codigo_modalidade`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Aluno_Plano`
--
ALTER TABLE `Aluno_Plano`
  ADD CONSTRAINT `fk_Aluno_Plano_Aluno1` FOREIGN KEY (`Aluno_codigo_aluno`) REFERENCES `Aluno` (`codigo_aluno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Aluno_Plano_Plano1` FOREIGN KEY (`Plano_codigo_plano`) REFERENCES `Plano` (`codigo_plano`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Antropometria`
--
ALTER TABLE `Antropometria`
  ADD CONSTRAINT `fk_Antropometria_Avaliacao1` FOREIGN KEY (`Avaliacao_codigo_avaliacao`) REFERENCES `Avaliacao` (`codigo_avaliacao`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Avaliacao`
--
ALTER TABLE `Avaliacao`
  ADD CONSTRAINT `fk_Avaliacao_Aluno1` FOREIGN KEY (`Aluno_codigo_aluno`) REFERENCES `Aluno` (`codigo_aluno`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Dobra`
--
ALTER TABLE `Dobra`
  ADD CONSTRAINT `fk_Dobra_Antropometria1` FOREIGN KEY (`Antropometria_codigo_antropometria`) REFERENCES `Antropometria` (`codigo_antropometria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Endereco`
--
ALTER TABLE `Endereco`
  ADD CONSTRAINT `fk_Endereco_Aluno1` FOREIGN KEY (`Aluno_codigo_aluno`) REFERENCES `Aluno` (`codigo_aluno`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Exercicio`
--
ALTER TABLE `Exercicio`
  ADD CONSTRAINT `fk_Exercicio_Treino1` FOREIGN KEY (`Treino_codigo_treino`) REFERENCES `Treino` (`codigo_treino`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Login`
--
ALTER TABLE `Login`
  ADD CONSTRAINT `fk_Login_Aluno1` FOREIGN KEY (`Aluno_codigo_aluno`) REFERENCES `Aluno` (`codigo_aluno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Usuario_Admin1` FOREIGN KEY (`Admin_codigo_admin`) REFERENCES `Admin` (`codigo_admin`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Telefone`
--
ALTER TABLE `Telefone`
  ADD CONSTRAINT `fk_Telefone_Aluno1` FOREIGN KEY (`Aluno_codigo_aluno`) REFERENCES `Aluno` (`codigo_aluno`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Treino_Modalidade`
--
ALTER TABLE `Treino_Modalidade`
  ADD CONSTRAINT `fk_Treino_has_Modalidade_Modalidade1` FOREIGN KEY (`Modalidade_codigo_modalidade`) REFERENCES `Modalidade` (`codigo_modalidade`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Treino_has_Modalidade_Treino1` FOREIGN KEY (`Treino_codigo_treino`) REFERENCES `Treino` (`codigo_treino`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
