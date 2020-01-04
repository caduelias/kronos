-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 03-Jan-2020 às 22:01
-- Versão do servidor: 5.7.28-0ubuntu0.18.04.4
-- PHP Version: 7.2.24-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `banco_4.0`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `Admin`
--

CREATE TABLE `Admin` (
  `codigo_admin` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `login` varchar(20) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `tipo` varchar(15) NOT NULL,
  `ativo` tinyint(4) NOT NULL,
  `email` varchar(100) NOT NULL,
  `data` date DEFAULT NULL,
  `Endereco_codigo_endereco` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Admin`
--

INSERT INTO `Admin` (`codigo_admin`, `nome`, `login`, `senha`, `tipo`, `ativo`, `email`, `data`, `Endereco_codigo_endereco`) VALUES
(1, 'Pessoa Admin Master', 'master', '$2y$10$e45AThVSARQ.rIBe8q9Bl.8PLK9tNuZga823rPYwoeJRcX.6rst3S', 'master', 1, 'master@master.com', '2019-11-04', 1),
(2, 'Admin', 'admin', '$2y$10$OFQNNUsVkQbeUe5qKN9va.gqcbObgD9rjLWVMqxphNI1iXoAwP/5G', 'admin', 1, 'admin@admin.com.br', '2019-10-04', 2),
(3, 'Pessoa Instrutor', 'instrutor', '$2y$10$9JRLzoMntSiGoLmOx9tFe.tlHtLNcMN399qoO0NM8EMBdO1mf7A7q', 'instrutor', 1, 'instrutor@gmail.com', '2019-11-12', 3),
(4, 'Tidinha', 'tidinha', '$2y$10$T5J6dmg62T1oo39jLBz29uIePIAbCCrKTlgH7Fb5B.j2eu0zu0Uyq', 'admin', 1, 'tidinha@admin.com', '2019-12-03', 82),
(5, 'errr', 'aghgttvfvfnngf', '$2y$10$zEkU/8p.UE/x4RtrhpctmOgjrRAX0yvLMInyBkoKwxxPWiz3sxDSi', 'admin', 0, 'admin@admin.com', '2019-12-03', 83);

-- --------------------------------------------------------

--
-- Estrutura da tabela `Aluno`
--

CREATE TABLE `Aluno` (
  `codigo_aluno` int(11) NOT NULL,
  `data_cadastro` date DEFAULT NULL,
  `nome_aluno` varchar(100) NOT NULL,
  `data_nasc` date NOT NULL,
  `sexo` char(1) NOT NULL,
  `rg` varchar(15) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `objetivo` text,
  `email` varchar(100) NOT NULL,
  `ativo` tinyint(4) NOT NULL,
  `Horario_codigo_horario` int(11) NOT NULL,
  `Endereco_codigo_endereco` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Aluno`
--

INSERT INTO `Aluno` (`codigo_aluno`, `data_cadastro`, `nome_aluno`, `data_nasc`, `sexo`, `rg`, `cpf`, `objetivo`, `email`, `ativo`, `Horario_codigo_horario`, `Endereco_codigo_endereco`) VALUES
(62, '2019-12-03', 'Tidinha', '1990-11-25', 'F', '87.662.383-3', '852.390.060-83', 'Manter o peso', 'tidinha@gmail.com', 0, 11, 81);

-- --------------------------------------------------------

--
-- Estrutura da tabela `Aluno_Modalidade`
--

CREATE TABLE `Aluno_Modalidade` (
  `codigo_aluno_modalidade` int(11) NOT NULL,
  `Aluno_codigo_aluno` int(11) NOT NULL,
  `Modalidade_codigo_modalidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Antropometria`
--

CREATE TABLE `Antropometria` (
  `codigo_antropometria` int(11) NOT NULL,
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
  `caloria` float DEFAULT NULL,
  `Antropometria_codigo_antropometria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Endereco`
--

CREATE TABLE `Endereco` (
  `codigo_endereco` int(11) NOT NULL,
  `estado` char(2) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `bairro` varchar(45) NOT NULL,
  `rua` varchar(45) NOT NULL,
  `numero` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Endereco`
--

INSERT INTO `Endereco` (`codigo_endereco`, `estado`, `cidade`, `bairro`, `rua`, `numero`) VALUES
(1, 'PR', 'Douradina', 'Jardim Molivera', 'Catanduva', '210'),
(2, 'SP', 'Itapecerica da Serra', 'Centro Comercial', 'Rua Anchieta', '456'),
(3, 'PR', 'Assis Chateaubriand', 'Centro', 'Avenida Maringa', '2222'),
(81, 'SP', 'Artur Nogueira', 'Jardim da Xuxa', 'Rua Xuxa', '123'),
(82, 'SP', 'Alfredo Marcondes', 'tidinha', 'rua tidinha da silva', '366'),
(83, 'MS', 'Aral Moreira', 'FEFEF', 'FFEFE', 'FFEFE');

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
  `arquivo` varchar(100) DEFAULT NULL,
  `descricao` text,
  `duracao` time DEFAULT NULL,
  `peso_inicial` varchar(45) DEFAULT NULL,
  `ordem_exercicio` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Exercicio`
--

INSERT INTO `Exercicio` (`codigo_exercicio`, `Treino_codigo_treino`, `tipo`, `nome_exercicio`, `serie_repeticao`, `arquivo`, `descricao`, `duracao`, `peso_inicial`, `ordem_exercicio`) VALUES
(2, 4, '1', 'Supino Inclinado', '20', '1575389686', 'O supino é um exercício físico que é uma forma de levantamento de peso voltado principalmente para o treinamento dos músculos peitorais maiores, mas que também envolve, como sinergistas, os músculos deltóide, serrátil anterior, coracobraquial, etc.', '00:20:00', '', NULL);

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

--
-- Extraindo dados da tabela `Horario`
--

INSERT INTO `Horario` (`codigo_horario`, `periodo`, `horario_treino`, `limite`) VALUES
(10, '1', '07:30:00', 20),
(11, '1', '06:00:00', 15);

-- --------------------------------------------------------

--
-- Estrutura da tabela `Login`
--

CREATE TABLE `Login` (
  `codigo_usuario` int(11) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `ativo` tinyint(4) NOT NULL,
  `Admin_codigo_admin` int(11) NOT NULL,
  `Aluno_codigo_aluno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `Mensalidade`
--

CREATE TABLE `Mensalidade` (
  `codigo_mesalidade` int(11) NOT NULL,
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
-- Estrutura da tabela `Modalidade`
--

CREATE TABLE `Modalidade` (
  `codigo_modalidade` int(11) NOT NULL,
  `nome_modalidade` varchar(50) NOT NULL,
  `ativo` tinyint(4) NOT NULL,
  `descricao` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Modalidade`
--

INSERT INTO `Modalidade` (`codigo_modalidade`, `nome_modalidade`, `ativo`, `descricao`) VALUES
(2, 'modalidade Teste', 1, 'modalidade teste'),
(3, 'CrossFit', 1, 'A sua principal função é a definição muscular. Além de desenvolvimento muscular, o crossfit acelera o metabolismo e ajuda no funcionamento do organismo.'),
(4, 'Teste do teste', 1, 'descrição teste'),
(5, 'Teste', 0, 'teste');

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
  `descricao` text,
  `dependentes` tinyint(4) NOT NULL,
  `qtd_dependentes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Plano`
--

INSERT INTO `Plano` (`codigo_plano`, `ativo`, `nome_plano`, `taxa_adesao`, `mensalidade`, `descricao`, `dependentes`, `qtd_dependentes`) VALUES
(3, 1, 'Anual', 35, 870, 'Plano Anual', 0, 0),
(4, 1, 'Mensal', 20, 100, 'Plano mensal', 0, 0),
(5, 0, 'Semestral', 20, 540, 'Plano Semestral', 0, 0);

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

--
-- Extraindo dados da tabela `Telefone`
--

INSERT INTO `Telefone` (`codigo_telefone`, `num_telefone`, `num_celular`, `Aluno_codigo_aluno`) VALUES
(55, '(42) 99784-7745', '(46) 97484-8444', 62);

-- --------------------------------------------------------

--
-- Estrutura da tabela `Treino`
--

CREATE TABLE `Treino` (
  `codigo_treino` int(11) NOT NULL,
  `nome_treino` varchar(100) NOT NULL,
  `descricao` text,
  `tipo_treino` int(11) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Treino`
--

INSERT INTO `Treino` (`codigo_treino`, `nome_treino`, `descricao`, `tipo_treino`, `ativo`) VALUES
(2, 'treino teste', 'descrição treino', 4, 0),
(4, 'Circuito', 'Fazer de maneira “circuitada”:\r\nLevantamento Terra – 3 repetições\r\nAgachamento Livre com Barra – 3 repetições\r\nSupino Reto com Barra – 3 repetições\r\nCorrida de 200 m', 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `Treino_Modalidade`
--

CREATE TABLE `Treino_Modalidade` (
  `codigo_treino_modalidade` int(11) NOT NULL,
  `Modalidade_codigo_modalidade` int(11) NOT NULL,
  `Treino_codigo_treino` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `Treino_Modalidade`
--

INSERT INTO `Treino_Modalidade` (`codigo_treino_modalidade`, `Modalidade_codigo_modalidade`, `Treino_codigo_treino`) VALUES
(2, 2, 2),
(4, 3, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`codigo_admin`),
  ADD KEY `fk_Admin_Endereco1_idx` (`Endereco_codigo_endereco`);

--
-- Indexes for table `Aluno`
--
ALTER TABLE `Aluno`
  ADD PRIMARY KEY (`codigo_aluno`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `fk_Aluno_Horario1_idx` (`Horario_codigo_horario`),
  ADD KEY `fk_Aluno_Endereco1_idx` (`Endereco_codigo_endereco`);

--
-- Indexes for table `Aluno_Modalidade`
--
ALTER TABLE `Aluno_Modalidade`
  ADD PRIMARY KEY (`codigo_aluno_modalidade`),
  ADD KEY `fk_Aluno_has_Modalidade_Modalidade1_idx` (`Modalidade_codigo_modalidade`),
  ADD KEY `fk_Aluno_has_Modalidade_Aluno1_idx` (`Aluno_codigo_aluno`);

--
-- Indexes for table `Antropometria`
--
ALTER TABLE `Antropometria`
  ADD PRIMARY KEY (`codigo_antropometria`);

--
-- Indexes for table `Avaliacao`
--
ALTER TABLE `Avaliacao`
  ADD PRIMARY KEY (`codigo_avaliacao`),
  ADD KEY `fk_Avaliacao_Aluno1_idx` (`Aluno_codigo_aluno`),
  ADD KEY `fk_Avaliacao_Antropometria1_idx` (`Antropometria_codigo_antropometria`);

--
-- Indexes for table `Endereco`
--
ALTER TABLE `Endereco`
  ADD PRIMARY KEY (`codigo_endereco`);

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
-- Indexes for table `Mensalidade`
--
ALTER TABLE `Mensalidade`
  ADD PRIMARY KEY (`codigo_mesalidade`),
  ADD KEY `fk_Aluno_Plano_Plano1_idx` (`Plano_codigo_plano`),
  ADD KEY `fk_Mensalidade_Aluno1_idx` (`Aluno_codigo_aluno`);

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
  ADD PRIMARY KEY (`codigo_treino_modalidade`),
  ADD KEY `fk_Treino_has_Modalidade_Modalidade1_idx` (`Modalidade_codigo_modalidade`),
  ADD KEY `fk_Treino_has_Modalidade_Treino1_idx` (`Treino_codigo_treino`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admin`
--
ALTER TABLE `Admin`
  MODIFY `codigo_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Aluno`
--
ALTER TABLE `Aluno`
  MODIFY `codigo_aluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `Aluno_Modalidade`
--
ALTER TABLE `Aluno_Modalidade`
  MODIFY `codigo_aluno_modalidade` int(11) NOT NULL AUTO_INCREMENT;
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
-- AUTO_INCREMENT for table `Endereco`
--
ALTER TABLE `Endereco`
  MODIFY `codigo_endereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
--
-- AUTO_INCREMENT for table `Exercicio`
--
ALTER TABLE `Exercicio`
  MODIFY `codigo_exercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Horario`
--
ALTER TABLE `Horario`
  MODIFY `codigo_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `Login`
--
ALTER TABLE `Login`
  MODIFY `codigo_usuario` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Mensalidade`
--
ALTER TABLE `Mensalidade`
  MODIFY `codigo_mesalidade` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Modalidade`
--
ALTER TABLE `Modalidade`
  MODIFY `codigo_modalidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Plano`
--
ALTER TABLE `Plano`
  MODIFY `codigo_plano` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Telefone`
--
ALTER TABLE `Telefone`
  MODIFY `codigo_telefone` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `Treino`
--
ALTER TABLE `Treino`
  MODIFY `codigo_treino` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `Treino_Modalidade`
--
ALTER TABLE `Treino_Modalidade`
  MODIFY `codigo_treino_modalidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `Admin`
--
ALTER TABLE `Admin`
  ADD CONSTRAINT `fk_Admin_Endereco1` FOREIGN KEY (`Endereco_codigo_endereco`) REFERENCES `Endereco` (`codigo_endereco`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Aluno`
--
ALTER TABLE `Aluno`
  ADD CONSTRAINT `fk_Aluno_Endereco1` FOREIGN KEY (`Endereco_codigo_endereco`) REFERENCES `Endereco` (`codigo_endereco`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Aluno_Horario1` FOREIGN KEY (`Horario_codigo_horario`) REFERENCES `Horario` (`codigo_horario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Aluno_Modalidade`
--
ALTER TABLE `Aluno_Modalidade`
  ADD CONSTRAINT `fk_Aluno_has_Modalidade_Aluno1` FOREIGN KEY (`Aluno_codigo_aluno`) REFERENCES `Aluno` (`codigo_aluno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Aluno_has_Modalidade_Modalidade1` FOREIGN KEY (`Modalidade_codigo_modalidade`) REFERENCES `Modalidade` (`codigo_modalidade`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `Avaliacao`
--
ALTER TABLE `Avaliacao`
  ADD CONSTRAINT `fk_Avaliacao_Aluno1` FOREIGN KEY (`Aluno_codigo_aluno`) REFERENCES `Aluno` (`codigo_aluno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Avaliacao_Antropometria1` FOREIGN KEY (`Antropometria_codigo_antropometria`) REFERENCES `Antropometria` (`codigo_antropometria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
-- Limitadores para a tabela `Mensalidade`
--
ALTER TABLE `Mensalidade`
  ADD CONSTRAINT `fk_Aluno_Plano_Plano1` FOREIGN KEY (`Plano_codigo_plano`) REFERENCES `Plano` (`codigo_plano`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Mensalidade_Aluno1` FOREIGN KEY (`Aluno_codigo_aluno`) REFERENCES `Aluno` (`codigo_aluno`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
