-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09-Ago-2020 às 03:15
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `kronos_v1.1`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE `aluno` (
  `codigo_aluno` int(11) NOT NULL,
  `Endereco_codigo_endereco` int(11) NOT NULL,
  `Usuario_codigo_usuario` int(11) DEFAULT NULL,
  `nome_aluno` varchar(100) NOT NULL,
  `data_nasc` date NOT NULL,
  `sexo` char(1) NOT NULL,
  `rg` varchar(15) NOT NULL,
  `cpf` varchar(15) NOT NULL,
  `objetivo` varchar(50) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `dependente` tinyint(4) NOT NULL,
  `codigo_aluno_dependente` int(11) DEFAULT NULL,
  `data_cadastro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno_modalidade`
--

CREATE TABLE `aluno_modalidade` (
  `codigo_aluno_modalidade` int(11) NOT NULL,
  `Aluno_codigo_aluno` int(11) NOT NULL,
  `Modalidade_codigo_modalidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `antropometria`
--

CREATE TABLE `antropometria` (
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
-- Estrutura da tabela `avaliacao`
--

CREATE TABLE `avaliacao` (
  `codigo_avaliacao` int(11) NOT NULL,
  `Aluno_codigo_aluno` int(11) NOT NULL,
  `Antropometria_codigo_antropometria` int(11) NOT NULL,
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
-- Estrutura da tabela `endereco`
--

CREATE TABLE `endereco` (
  `codigo_endereco` int(11) NOT NULL,
  `estado` char(2) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `bairro` varchar(45) NOT NULL,
  `rua` varchar(45) NOT NULL,
  `numero` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `endereco`
--

INSERT INTO `endereco` (`codigo_endereco`, `estado`, `cidade`, `bairro`, `rua`, `numero`) VALUES
(1, 'PR', 'Douradina', 'Jardim Molivera', 'Catanduva', '210');

-- --------------------------------------------------------

--
-- Estrutura da tabela `exercicio`
--

CREATE TABLE `exercicio` (
  `codigo_exercicio` int(11) NOT NULL,
  `Treino_codigo_treino` int(11) NOT NULL,
  `tipo_exercicio` int(11) NOT NULL,
  `nome_exercicio` varchar(100) NOT NULL,
  `serie_repeticao` varchar(15) DEFAULT NULL,
  `arquivo` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `duracao` time DEFAULT NULL,
  `peso_inicial` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `horario`
--

CREATE TABLE `horario` (
  `codigo_horario` int(11) NOT NULL,
  `periodo` varchar(30) NOT NULL,
  `horario_treino` time NOT NULL,
  `limite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE `login` (
  `codigo_usuario` int(11) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `ativo` tinyint(4) NOT NULL,
  `Admin_codigo_admin` int(11) NOT NULL,
  `Aluno_codigo_aluno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensalidade`
--

CREATE TABLE `mensalidade` (
  `codigo_mensalidade` int(11) NOT NULL,
  `Aluno_codigo_aluno` int(11) NOT NULL,
  `Plano_codigo_plano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `modalidade`
--

CREATE TABLE `modalidade` (
  `codigo_modalidade` int(11) NOT NULL,
  `Horario_codigo_horario` int(11) NOT NULL,
  `nome_modalidade` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `descricao` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil`
--

CREATE TABLE `perfil` (
  `codigo_perfil` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `perfil`
--

INSERT INTO `perfil` (`codigo_perfil`, `descricao`) VALUES
(1, 'Master'),
(2, 'Admin'),
(3, 'Instrutor'),
(4, 'Aluno');

-- --------------------------------------------------------

--
-- Estrutura da tabela `plano`
--

CREATE TABLE `plano` (
  `codigo_plano` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `nome_plano` varchar(50) NOT NULL,
  `taxa_adesao` float NOT NULL,
  `mensalidade` float NOT NULL,
  `descricao` text DEFAULT NULL,
  `dependentes` tinyint(4) NOT NULL,
  `qtd_dependentes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefone`
--

CREATE TABLE `telefone` (
  `codigo_telefone` int(11) NOT NULL,
  `Aluno_codigo_aluno` int(11) NOT NULL,
  `num_telefone` varchar(15) NOT NULL,
  `num_celular` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_exercicio`
--

CREATE TABLE `tipo_exercicio` (
  `codigo_tipo_exercicio` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tipo_exercicio`
--

INSERT INTO `tipo_exercicio` (`codigo_tipo_exercicio`, `descricao`) VALUES
(1, 'Aparelho'),
(2, 'Aeróbico'),
(3, 'Anaeróbico');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_treino`
--

CREATE TABLE `tipo_treino` (
  `codigo_tipo_treino` int(11) NOT NULL,
  `descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tipo_treino`
--

INSERT INTO `tipo_treino` (`codigo_tipo_treino`, `descricao`) VALUES
(1, 'Metabólico'),
(2, 'Hipertrofia'),
(3, 'Intervalado'),
(4, 'Funcional');

-- --------------------------------------------------------

--
-- Estrutura da tabela `treino`
--

CREATE TABLE `treino` (
  `codigo_treino` int(11) NOT NULL,
  `tipo_treino` int(11) NOT NULL,
  `nome_treino` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `treino_modalidade`
--

CREATE TABLE `treino_modalidade` (
  `codigo_treino_modalidade` int(11) NOT NULL,
  `Modalidade_codigo_modalidade` int(11) NOT NULL,
  `Treino_codigo_treino` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `codigo_usuario` int(11) NOT NULL,
  `Endereco_codigo_endereco` int(11) NOT NULL,
  `Perfil_codigo_perfil` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `login` varchar(20) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `email` varchar(100) NOT NULL,
  `data` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`codigo_usuario`, `Endereco_codigo_endereco`, `Perfil_codigo_perfil`, `nome`, `login`, `senha`, `status`, `email`, `data`) VALUES
(1, 1, 1, 'Master', 'master', '$2y$10$il3cPp0FHZ65w7WWbMF9PuyufpJawMXp6dbE7JVHzmF6Ogbwn/VvC', 1, 'master@master.com', '2020-01-04');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`codigo_aluno`),
  ADD KEY `fk_Aluno_Endereco1_idx` (`Endereco_codigo_endereco`),
  ADD KEY `fk_Aluno_Usuario1_idx` (`Usuario_codigo_usuario`);

--
-- Índices para tabela `aluno_modalidade`
--
ALTER TABLE `aluno_modalidade`
  ADD PRIMARY KEY (`codigo_aluno_modalidade`),
  ADD KEY `fk_Aluno_has_Modalidade_Modalidade1_idx` (`Modalidade_codigo_modalidade`),
  ADD KEY `fk_Aluno_has_Modalidade_Aluno1_idx` (`Aluno_codigo_aluno`);

--
-- Índices para tabela `antropometria`
--
ALTER TABLE `antropometria`
  ADD PRIMARY KEY (`codigo_antropometria`);

--
-- Índices para tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD PRIMARY KEY (`codigo_avaliacao`),
  ADD KEY `fk_Avaliacao_Aluno1_idx` (`Aluno_codigo_aluno`),
  ADD KEY `fk_Avaliacao_Antropometria1_idx` (`Antropometria_codigo_antropometria`);

--
-- Índices para tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`codigo_endereco`);

--
-- Índices para tabela `exercicio`
--
ALTER TABLE `exercicio`
  ADD PRIMARY KEY (`codigo_exercicio`),
  ADD KEY `fk_Exercicio_Treino1_idx` (`Treino_codigo_treino`),
  ADD KEY `fk_Exercicio_Tipo_Exercicio1_idx` (`tipo_exercicio`);

--
-- Índices para tabela `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`codigo_horario`);

--
-- Índices para tabela `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`codigo_usuario`),
  ADD KEY `fk_Usuario_Admin1_idx` (`Admin_codigo_admin`),
  ADD KEY `fk_Login_Aluno1_idx` (`Aluno_codigo_aluno`);

--
-- Índices para tabela `mensalidade`
--
ALTER TABLE `mensalidade`
  ADD PRIMARY KEY (`codigo_mensalidade`),
  ADD KEY `fk_Aluno_Plano_Plano1_idx` (`Plano_codigo_plano`),
  ADD KEY `fk_Mensalidade_Aluno1_idx` (`Aluno_codigo_aluno`);

--
-- Índices para tabela `modalidade`
--
ALTER TABLE `modalidade`
  ADD PRIMARY KEY (`codigo_modalidade`),
  ADD KEY `fk_Modalidade_Horario1_idx` (`Horario_codigo_horario`);

--
-- Índices para tabela `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`codigo_perfil`);

--
-- Índices para tabela `plano`
--
ALTER TABLE `plano`
  ADD PRIMARY KEY (`codigo_plano`);

--
-- Índices para tabela `telefone`
--
ALTER TABLE `telefone`
  ADD PRIMARY KEY (`codigo_telefone`),
  ADD KEY `fk_Telefone_Aluno1_idx` (`Aluno_codigo_aluno`);

--
-- Índices para tabela `tipo_exercicio`
--
ALTER TABLE `tipo_exercicio`
  ADD PRIMARY KEY (`codigo_tipo_exercicio`);

--
-- Índices para tabela `tipo_treino`
--
ALTER TABLE `tipo_treino`
  ADD PRIMARY KEY (`codigo_tipo_treino`);

--
-- Índices para tabela `treino`
--
ALTER TABLE `treino`
  ADD PRIMARY KEY (`codigo_treino`),
  ADD KEY `fk_Treino_Tipo_Treino1_idx` (`tipo_treino`);

--
-- Índices para tabela `treino_modalidade`
--
ALTER TABLE `treino_modalidade`
  ADD PRIMARY KEY (`codigo_treino_modalidade`),
  ADD KEY `fk_Treino_has_Modalidade_Modalidade1_idx` (`Modalidade_codigo_modalidade`),
  ADD KEY `fk_Treino_has_Modalidade_Treino1_idx` (`Treino_codigo_treino`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`codigo_usuario`),
  ADD KEY `fk_Admin_Endereco1_idx` (`Endereco_codigo_endereco`),
  ADD KEY `fk_Admin_perfil1_idx` (`Perfil_codigo_perfil`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `codigo_aluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `aluno_modalidade`
--
ALTER TABLE `aluno_modalidade`
  MODIFY `codigo_aluno_modalidade` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `antropometria`
--
ALTER TABLE `antropometria`
  MODIFY `codigo_antropometria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  MODIFY `codigo_avaliacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `codigo_endereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de tabela `exercicio`
--
ALTER TABLE `exercicio`
  MODIFY `codigo_exercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `horario`
--
ALTER TABLE `horario`
  MODIFY `codigo_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `codigo_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mensalidade`
--
ALTER TABLE `mensalidade`
  MODIFY `codigo_mensalidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `modalidade`
--
ALTER TABLE `modalidade`
  MODIFY `codigo_modalidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `perfil`
--
ALTER TABLE `perfil`
  MODIFY `codigo_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `plano`
--
ALTER TABLE `plano`
  MODIFY `codigo_plano` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `telefone`
--
ALTER TABLE `telefone`
  MODIFY `codigo_telefone` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de tabela `tipo_exercicio`
--
ALTER TABLE `tipo_exercicio`
  MODIFY `codigo_tipo_exercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tipo_treino`
--
ALTER TABLE `tipo_treino`
  MODIFY `codigo_tipo_treino` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `treino`
--
ALTER TABLE `treino`
  MODIFY `codigo_treino` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `treino_modalidade`
--
ALTER TABLE `treino_modalidade`
  MODIFY `codigo_treino_modalidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `codigo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `fk_Aluno_Endereco1` FOREIGN KEY (`Endereco_codigo_endereco`) REFERENCES `endereco` (`codigo_endereco`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Aluno_Usuario1` FOREIGN KEY (`Usuario_codigo_usuario`) REFERENCES `usuario` (`codigo_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `aluno_modalidade`
--
ALTER TABLE `aluno_modalidade`
  ADD CONSTRAINT `fk_Aluno_has_Modalidade_Aluno1` FOREIGN KEY (`Aluno_codigo_aluno`) REFERENCES `aluno` (`codigo_aluno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Aluno_has_Modalidade_Modalidade1` FOREIGN KEY (`Modalidade_codigo_modalidade`) REFERENCES `modalidade` (`codigo_modalidade`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD CONSTRAINT `fk_Avaliacao_Aluno1` FOREIGN KEY (`Aluno_codigo_aluno`) REFERENCES `aluno` (`codigo_aluno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Avaliacao_Antropometria1` FOREIGN KEY (`Antropometria_codigo_antropometria`) REFERENCES `antropometria` (`codigo_antropometria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `exercicio`
--
ALTER TABLE `exercicio`
  ADD CONSTRAINT `fk_Exercicio_Tipo_Exercicio1` FOREIGN KEY (`tipo_exercicio`) REFERENCES `tipo_exercicio` (`codigo_tipo_exercicio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Exercicio_Treino1` FOREIGN KEY (`Treino_codigo_treino`) REFERENCES `treino` (`codigo_treino`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `fk_Login_Aluno1` FOREIGN KEY (`Aluno_codigo_aluno`) REFERENCES `aluno` (`codigo_aluno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Usuario_Admin1` FOREIGN KEY (`Admin_codigo_admin`) REFERENCES `usuario` (`codigo_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `mensalidade`
--
ALTER TABLE `mensalidade`
  ADD CONSTRAINT `fk_Aluno_Plano_Plano1` FOREIGN KEY (`Plano_codigo_plano`) REFERENCES `plano` (`codigo_plano`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Mensalidade_Aluno1` FOREIGN KEY (`Aluno_codigo_aluno`) REFERENCES `aluno` (`codigo_aluno`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `modalidade`
--
ALTER TABLE `modalidade`
  ADD CONSTRAINT `fk_Modalidade_Horario1` FOREIGN KEY (`Horario_codigo_horario`) REFERENCES `horario` (`codigo_horario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `telefone`
--
ALTER TABLE `telefone`
  ADD CONSTRAINT `fk_Telefone_Aluno1` FOREIGN KEY (`Aluno_codigo_aluno`) REFERENCES `aluno` (`codigo_aluno`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `treino`
--
ALTER TABLE `treino`
  ADD CONSTRAINT `fk_Treino_Tipo_Treino1` FOREIGN KEY (`tipo_treino`) REFERENCES `tipo_treino` (`codigo_tipo_treino`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `treino_modalidade`
--
ALTER TABLE `treino_modalidade`
  ADD CONSTRAINT `fk_Treino_has_Modalidade_Modalidade1` FOREIGN KEY (`Modalidade_codigo_modalidade`) REFERENCES `modalidade` (`codigo_modalidade`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Treino_has_Modalidade_Treino1` FOREIGN KEY (`Treino_codigo_treino`) REFERENCES `treino` (`codigo_treino`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_Admin_Endereco1` FOREIGN KEY (`Endereco_codigo_endereco`) REFERENCES `endereco` (`codigo_endereco`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Admin_perfil1` FOREIGN KEY (`Perfil_codigo_perfil`) REFERENCES `perfil` (`codigo_perfil`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
