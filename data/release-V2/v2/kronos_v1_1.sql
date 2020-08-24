-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Ago-2020 às 05:28
-- Versão do servidor: 10.4.14-MariaDB
-- versão do PHP: 7.4.9

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
  `status` int(1) NOT NULL,
  `data_cadastro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`codigo_aluno`, `Endereco_codigo_endereco`, `Usuario_codigo_usuario`, `nome_aluno`, `data_nasc`, `sexo`, `rg`, `cpf`, `objetivo`, `email`, `status`, `data_cadastro`) VALUES
(36, 50, NULL, 'Elza Sophia Marcela Mendes', '1989-04-19', 'F', '183870049', '967.356.453-16', '', 'elzasophiamarcelamendes-70@alcoa.com.br', 1, '2020-08-12'),
(37, 52, NULL, 'Silvana Flávia da Rocha', '1955-02-07', 'F', '410105144', '162.227.259-53', '', 'ssilvanaflaviadarocha@escribacontabil.com.br', 1, '2020-08-20'),
(38, 53, NULL, 'Leandro Felipe Antonio Ferreira', '1999-11-25', 'M', '234432561', '025.233.719-01', 'Hipertrofia', 'lleandrofelipeantonioferreira@sobraer.com.br', 2, '2020-08-20');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno_exercicio`
--

CREATE TABLE `aluno_exercicio` (
  `codigo_aluno_exercicio` int(11) NOT NULL,
  `codigo_aluno` int(11) NOT NULL,
  `codigo_exercicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `aluno_exercicio`
--

INSERT INTO `aluno_exercicio` (`codigo_aluno_exercicio`, `codigo_aluno`, `codigo_exercicio`) VALUES
(274, 37, 15),
(286, 36, 13),
(287, 36, 8),
(288, 38, 15),
(289, 38, 8),
(290, 38, 13),
(291, 38, 8),
(292, 38, 12),
(293, 38, 10),
(294, 38, 11),
(295, 38, 12),
(296, 38, 6),
(297, 38, 7),
(298, 38, 6),
(299, 38, 14),
(300, 38, 14);

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno_modalidade`
--

CREATE TABLE `aluno_modalidade` (
  `codigo_aluno_modalidade` int(11) NOT NULL,
  `codigo_aluno` int(11) NOT NULL,
  `codigo_modalidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `aluno_modalidade`
--

INSERT INTO `aluno_modalidade` (`codigo_aluno_modalidade`, `codigo_aluno`, `codigo_modalidade`) VALUES
(77, 38, 8),
(78, 38, 11),
(82, 37, 11),
(85, 38, 10),
(86, 36, 8),
(87, 36, 11),
(88, 38, 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno_plano`
--

CREATE TABLE `aluno_plano` (
  `codigo_aluno_plano` int(11) NOT NULL,
  `codigo_aluno` int(11) NOT NULL,
  `codigo_plano` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `aluno_plano`
--

INSERT INTO `aluno_plano` (`codigo_aluno_plano`, `codigo_aluno`, `codigo_plano`) VALUES
(2, 36, 4),
(3, 37, 3),
(4, 38, 3);

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
  `abdominal` float DEFAULT NULL,
  `densidade_corporal` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `antropometria`
--

INSERT INTO `antropometria` (`codigo_antropometria`, `axilar_media`, `suprailiaca`, `coxa`, `panturrilha_medial`, `subescapular`, `triceps`, `abdominal`, `densidade_corporal`) VALUES
(15, 18.4, 18.3, 18, 48.4, 22.2, 11.1, 14.2, 1.03),
(16, 18.4, 11.1, 11.1, 22.2, 11.1, 18.6, 14.2, 1.05),
(17, 18.4, 18.3, 44.5, 48.4, 11.1, 18.6, 14.2, 1.01);

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao`
--

CREATE TABLE `avaliacao` (
  `codigo_avaliacao` int(11) NOT NULL,
  `codigo_aluno` int(11) NOT NULL,
  `codigo_antropometria` int(11) NOT NULL,
  `data_avaliacao` date NOT NULL,
  `idade` int(11) NOT NULL,
  `peso` float NOT NULL,
  `altura` float NOT NULL,
  `imc` float NOT NULL,
  `classificacao_imc` text DEFAULT NULL,
  `gordura` float NOT NULL,
  `massa_magra` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `avaliacao`
--

INSERT INTO `avaliacao` (`codigo_avaliacao`, `codigo_aluno`, `codigo_antropometria`, `data_avaliacao`, `idade`, `peso`, `altura`, `imc`, `classificacao_imc`, `gordura`, `massa_magra`) VALUES
(6, 36, 15, '2020-07-20', 31, 74, 1.82, 22.34, 'Peso Ideal', 29.9, 51.88),
(7, 36, 16, '2020-07-20', 31, 81.5, 1.65, 29.94, 'Indefinida', 22.49, 63.17),
(8, 37, 17, '2020-07-29', 65, 111.11, 1.79, 34.68, 'Obesidade I', 40.08, 66.58);

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
(1, 'PR', 'Douradina', 'Jardim Molivera', 'Catanduva', '210'),
(50, 'RJ', 'Rio de Janeiro', 'Botafogo', 'Rua da Serenidade', '612'),
(51, 'SC', 'Florianópolis', 'Xanxerê', 'Rua Demerval', '1647'),
(52, 'AP', 'Santana', 'Fortaleza', 'Travessa RAIMUNDO PEREIRA DE SOUZA', '242'),
(53, 'PI', 'Teresina', 'Vermelha', 'Rua João Virgílio', '270');

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
  `peso_inicial` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `exercicio`
--

INSERT INTO `exercicio` (`codigo_exercicio`, `Treino_codigo_treino`, `tipo_exercicio`, `nome_exercicio`, `serie_repeticao`, `arquivo`, `descricao`, `duracao`, `peso_inicial`) VALUES
(6, 4, 1, 'Pronação', '03/10', '1597973269', '', '00:10:00', '5'),
(7, 4, 3, 'Corda', '03/10', '1597811889', '', '00:10:00', '05'),
(8, 8, 1, 'Supino Reto', '03/10', '1597972332', '', '00:10:00', '10'),
(10, 7, 3, 'Agachamento', '05/08', '1597970994', '', '00:10:00', '10'),
(11, 7, 1, 'Extensora', '03/08', '1597971814', '', '00:10:00', '10'),
(12, 7, 3, 'Panturrilha', '04/08', '1597972283', 'Intervalo 45” a 1’', '00:10:00', '10'),
(13, 8, 1, 'Supino inclinado', '04/08', '1597972418', '', '00:10:00', '05'),
(14, 9, 3, 'Elevação lateral', '03/08', '1597972509', '', '00:10:00', '04'),
(15, 5, 3, 'Murph', '03/10', '1597972816', '30 flexões', '00:30:00', ''),
(16, 5, 1, 'Corrida - Esteira', '', '1597973092', '5 minutos de corrida na esteira', '00:05:00', '');

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

--
-- Extraindo dados da tabela `horario`
--

INSERT INTO `horario` (`codigo_horario`, `periodo`, `horario_treino`, `limite`) VALUES
(12, '1', '06:00:00', 20),
(17, '1', '08:00:00', 10),
(18, '3', '17:00:00', 20),
(19, '4', '19:00:00', 40);

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
  `status` int(11) NOT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `modalidade`
--

INSERT INTO `modalidade` (`codigo_modalidade`, `Horario_codigo_horario`, `nome_modalidade`, `status`, `descricao`) VALUES
(8, 12, 'Musculação', 1, 'O treinamento de força, conhecido popularmente como musculação é uma forma de exercício contra resistência, praticado normalmente em ginásios, para o treinamento e desenvolvimento dos músculos esqueléticos.'),
(9, 19, 'Pilates', 2, 'Todo mundo já sabe o quanto é importante para a saúde a prática de exercícios físicos, porém não são todas as pessoas que apreciam realizar caminhada ou corrida e as atividades realizadas em academia.'),
(10, 17, 'Spinning', 1, 'Spinning é uma marca registrada, criada pelo Sul-Africano Johnathan Goldberg (Johnny G). Em função da sua necessidade de treinar para o Race Across American que cruza os Estados Unidos, Johnny desenvolveu a bicicleta estacionaria para treinar em casa'),
(11, 18, 'Crossfit', 1, 'O Crossfit é uma modalidade essencialmente benéfica para quem deseja ter definição muscular, pois ele trabalha todas as capacidades do corpo, fazendo com que ele desenvolva vários membros do corpo, através de um único exercício.'),
(12, 19, 'Zumba', 1, 'O Zumba é uma atividade física aeróbica que mistura ritmos e coreografias. Essa modalidade incorpora diversos estilos de músicas latinas como: merengue, salsa, samba, cumbia, entre outras.'),
(13, 12, 'teste', 2, 'ffff');

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

--
-- Extraindo dados da tabela `plano`
--

INSERT INTO `plano` (`codigo_plano`, `status`, `nome_plano`, `taxa_adesao`, `mensalidade`, `descricao`, `dependentes`, `qtd_dependentes`) VALUES
(3, 1, 'Individual - Livre', 20, 70, 'Plano individual', 0, NULL),
(4, 1, 'Individual - Personal', 20, 100, 'Plano Individual Gold', 0, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `telefone`
--

CREATE TABLE `telefone` (
  `codigo_telefone` int(11) NOT NULL,
  `Aluno_codigo_aluno` int(11) NOT NULL,
  `num_telefone` varchar(15) DEFAULT NULL,
  `num_celular` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `telefone`
--

INSERT INTO `telefone` (`codigo_telefone`, `Aluno_codigo_aluno`, `num_telefone`, `num_celular`) VALUES
(35, 36, '(21) 29974-640', '(21) 99223-8224'),
(36, 37, '(96) 26955-637', '(96) 98163-6959'),
(37, 38, '(86) 36627-870', '(86) 99116-4702');

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

--
-- Extraindo dados da tabela `treino`
--

INSERT INTO `treino` (`codigo_treino`, `tipo_treino`, `nome_treino`, `descricao`, `status`) VALUES
(4, 2, 'Tricéps', 'O músculo tríceps braquial ou tricípete braquial é um largo músculo esquelético de três cabeças encontrado em humanos.', 1),
(5, 3, 'Cross', '', 1),
(6, 1, 'Costas', '', 1),
(7, 2, 'Pernas', 'Treinar pernas da forma correta e com os exercícios certos é a melhor forma de gerar demanda energética para o corpo, o que vai aumentar a produção hormonal anabólica e a consequente hipertrofia do seu corpo.', 1),
(8, 2, 'Peitoral', '', 1),
(9, 2, 'Ombro', '', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `treino_modalidade`
--

CREATE TABLE `treino_modalidade` (
  `codigo_treino_modalidade` int(11) NOT NULL,
  `Modalidade_codigo_modalidade` int(11) NOT NULL,
  `Treino_codigo_treino` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `treino_modalidade`
--

INSERT INTO `treino_modalidade` (`codigo_treino_modalidade`, `Modalidade_codigo_modalidade`, `Treino_codigo_treino`) VALUES
(4, 8, 4),
(5, 11, 5),
(6, 8, 6),
(7, 8, 7),
(8, 8, 8),
(9, 8, 9);

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
(1, 1, 1, 'Usuário Master', 'master', '$2y$10$qyorOxdPnPcoy/m2RMUsa.RpeUlavAr4WZ9gztBbr2YP/G8DRBzOC', 1, 'master@master.com', '2020-08-12'),
(5, 51, 2, 'Usuário Administrador', 'admin', '$2y$10$e/qVzRP6uDTLRIecNcAFHOKBUQ.nFNDXOPI1cGURx2V0Otg4WPIei', 1, 'admin@admin.com', '2020-08-13');

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
-- Índices para tabela `aluno_exercicio`
--
ALTER TABLE `aluno_exercicio`
  ADD PRIMARY KEY (`codigo_aluno_exercicio`),
  ADD KEY `codigo_aluno` (`codigo_aluno`),
  ADD KEY `codigo_exercicio` (`codigo_exercicio`);

--
-- Índices para tabela `aluno_modalidade`
--
ALTER TABLE `aluno_modalidade`
  ADD PRIMARY KEY (`codigo_aluno_modalidade`),
  ADD KEY `fk_Aluno_has_Modalidade_Modalidade1_idx` (`codigo_modalidade`),
  ADD KEY `fk_Aluno_has_Modalidade_Aluno1_idx` (`codigo_aluno`);

--
-- Índices para tabela `aluno_plano`
--
ALTER TABLE `aluno_plano`
  ADD PRIMARY KEY (`codigo_aluno_plano`),
  ADD KEY `codigo_aluno` (`codigo_aluno`),
  ADD KEY `codigo_plano` (`codigo_plano`);

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
  ADD KEY `fk_Avaliacao_Aluno1_idx` (`codigo_aluno`),
  ADD KEY `fk_Avaliacao_Antropometria1_idx` (`codigo_antropometria`);

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
  MODIFY `codigo_aluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `aluno_exercicio`
--
ALTER TABLE `aluno_exercicio`
  MODIFY `codigo_aluno_exercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT de tabela `aluno_modalidade`
--
ALTER TABLE `aluno_modalidade`
  MODIFY `codigo_aluno_modalidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de tabela `aluno_plano`
--
ALTER TABLE `aluno_plano`
  MODIFY `codigo_aluno_plano` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `antropometria`
--
ALTER TABLE `antropometria`
  MODIFY `codigo_antropometria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  MODIFY `codigo_avaliacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `codigo_endereco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de tabela `exercicio`
--
ALTER TABLE `exercicio`
  MODIFY `codigo_exercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `horario`
--
ALTER TABLE `horario`
  MODIFY `codigo_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  MODIFY `codigo_modalidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `perfil`
--
ALTER TABLE `perfil`
  MODIFY `codigo_perfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `plano`
--
ALTER TABLE `plano`
  MODIFY `codigo_plano` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `telefone`
--
ALTER TABLE `telefone`
  MODIFY `codigo_telefone` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

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
  MODIFY `codigo_treino` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `treino_modalidade`
--
ALTER TABLE `treino_modalidade`
  MODIFY `codigo_treino_modalidade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `codigo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Limitadores para a tabela `aluno_exercicio`
--
ALTER TABLE `aluno_exercicio`
  ADD CONSTRAINT `aluno_exercicio_ibfk_1` FOREIGN KEY (`codigo_aluno`) REFERENCES `aluno` (`codigo_aluno`),
  ADD CONSTRAINT `aluno_exercicio_ibfk_2` FOREIGN KEY (`codigo_exercicio`) REFERENCES `exercicio` (`codigo_exercicio`);

--
-- Limitadores para a tabela `aluno_modalidade`
--
ALTER TABLE `aluno_modalidade`
  ADD CONSTRAINT `fk_Aluno_has_Modalidade_Aluno1` FOREIGN KEY (`codigo_aluno`) REFERENCES `aluno` (`codigo_aluno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Aluno_has_Modalidade_Modalidade1` FOREIGN KEY (`codigo_modalidade`) REFERENCES `modalidade` (`codigo_modalidade`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `aluno_plano`
--
ALTER TABLE `aluno_plano`
  ADD CONSTRAINT `aluno_plano_ibfk_1` FOREIGN KEY (`codigo_aluno`) REFERENCES `aluno` (`codigo_aluno`),
  ADD CONSTRAINT `aluno_plano_ibfk_2` FOREIGN KEY (`codigo_plano`) REFERENCES `plano` (`codigo_plano`);

--
-- Limitadores para a tabela `avaliacao`
--
ALTER TABLE `avaliacao`
  ADD CONSTRAINT `fk_Avaliacao_Aluno1` FOREIGN KEY (`codigo_aluno`) REFERENCES `aluno` (`codigo_aluno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Avaliacao_Antropometria1` FOREIGN KEY (`codigo_antropometria`) REFERENCES `antropometria` (`codigo_antropometria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
