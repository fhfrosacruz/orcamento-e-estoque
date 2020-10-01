-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01-Out-2020 às 21:24
-- Versão do servidor: 10.4.13-MariaDB
-- versão do PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tapecaria`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `compra`
--

CREATE TABLE `compra` (
  `id_compra` int(11) NOT NULL,
  `material_id` int(10) UNSIGNED NOT NULL,
  `preco_total` float(10,2) UNSIGNED NOT NULL,
  `quantidade_comp` double NOT NULL,
  `data_compra` date NOT NULL,
  `observacao` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `compra`
--

INSERT INTO `compra` (`id_compra`, `material_id`, `preco_total`, `quantidade_comp`, `data_compra`, `observacao`) VALUES
(3, 7, 100.00, 400, '2019-10-30', ''),
(4, 7, 155.00, 50, '2019-09-13', ''),
(5, 5, 45.00, 100, '2019-04-03', ''),
(7, 6, 59.00, 200, '2019-02-02', ''),
(8, 8, 46.00, 200, '2019-10-12', ''),
(9, 9, 54.00, 50, '2019-11-16', ''),
(10, 2, 344.00, 600, '2019-07-02', ''),
(11, 3, 144.00, 695, '2019-06-16', ''),
(12, 5, 60.00, 20, '2019-03-02', ''),
(13, 11, 55.00, 600, '2019-12-03', ''),
(14, 12, 5.00, 1000, '2018-09-03', ''),
(15, 13, 988.00, 30, '2018-09-02', ''),
(17, 1, 400.00, 10, '2019-10-15', ''),
(18, 4, 300.00, 50, '2019-10-16', ''),
(19, 14, 2000.53, 60, '2019-10-23', ''),
(20, 1, 5000.00, 200, '2019-11-27', '');

--
-- Acionadores `compra`
--
DELIMITER $$
CREATE TRIGGER `ADICIONA_ESTOQUE` AFTER INSERT ON `compra` FOR EACH ROW UPDATE material m set m.quantidade = (new.quantidade_comp + m.quantidade) WHERE m.id_material = new.material_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `REMOVE_ESTOQUE` AFTER DELETE ON `compra` FOR EACH ROW UPDATE material set material.quantidade = material.quantidade -old.quantidade_comp WHERE material.id_material = old.material_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UPDATE_ESTOQUE` BEFORE UPDATE ON `compra` FOR EACH ROW UPDATE material set material.quantidade = (material.quantidade -old.quantidade_comp)+ new.quantidade_comp WHERE material.id_material = old.material_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` int(10) UNSIGNED NOT NULL,
  `razao_social` varchar(70) NOT NULL,
  `nome_fantasia` varchar(50) DEFAULT NULL,
  `cnpj` varchar(20) NOT NULL,
  `telefone` varchar(13) NOT NULL,
  `responsavel` varchar(45) NOT NULL,
  `website` varchar(200) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `detalhes` varchar(150) DEFAULT NULL,
  `endereco_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `razao_social`, `nome_fantasia`, `cnpj`, `telefone`, `responsavel`, `website`, `email`, `detalhes`, `endereco_id`) VALUES
(1, 'COCA-COLA', 'COCA', '', '(65) 45643-86', 'ARTUR NOGUERA', '', 'COCA@GMAIL.COM', '', 7),
(2, 'COMERCIAL MARLBORO LTDA', 'COMERCIAL MARLBORO', '06.540.241/0001-00', '', 'LEILA CARDOSO DOS SANTOS MAGALHAES', '', '', '', 16);

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE `endereco` (
  `id_endereco` int(10) UNSIGNED NOT NULL,
  `rua` varchar(100) NOT NULL,
  `numero` int(10) UNSIGNED NOT NULL,
  `complemento` varchar(30) DEFAULT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `bairro` varchar(30) NOT NULL,
  `cidade` varchar(45) NOT NULL,
  `estado` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `endereco`
--

INSERT INTO `endereco` (`id_endereco`, `rua`, `numero`, `complemento`, `cep`, `bairro`, `cidade`, `estado`) VALUES
(1, 'JOSEFINA ARNONI', 154, 'BL 9 AP 102', '02374050', 'TREMEMBÉ', 'SÃO PAULO', 'SP'),
(2, 'BERNARDINO', 275, '', '13051103', 'JD. BANDEIRAS', 'CAMPINAS', 'SP'),
(3, 'BERNARDINO MAERTINS FILHO', 275, 'BL J AP 32', '13051103', 'JD. BANDEIRAS', 'CAMPINAS', 'SP'),
(4, 'RUA TAL XYZ', 654, '', '56565', '', '', 'SP'),
(5, 'RUA TAL XYZ', 654, '', '13051103', 'X', 'CAMPINAS', 'SP'),
(6, 'RUA TAL XYZ', 654, '', '13051103', 'X', 'CAMPINAS', 'SP'),
(7, 'RUA TAL XYZ', 654, '', '13051103', 'X', 'CAMPINAS', 'SP'),
(8, 'BERNARDINO MARTINS FILHO', 275, 'BL 9 AP 32', '13051103', 'JD. BANDEIRAS', 'CAMPINAS', 'SP'),
(9, 'JOSEFINA ARNONI', 154, 'BL 9 AP 102', '02374050', 'TREMEMBé', 'SãO PAULO', 'SP'),
(10, 'JOSEFINA ARNONI ', 154, 'BL 9 AP 102', '02374050', 'TREMEMBé', 'SãO PAULO', 'SP'),
(11, 'JOSEFINA ARNONI', 154, 'BL 9 AP 102', '02374050', 'TREMAMBé', 'SãOPAULO', 'SP'),
(12, 'RUA TAL XXDGT', 64, '', '45677769', 'SEILA', 'CAMPINAS', 'SP'),
(13, 'RUA UM', 12, '12', '13100100', 'PQ UM', 'CAMPINAS', 'SP'),
(14, '', 0, '', '', '', '', 'SP'),
(15, 'RUA GERCINO RODRIGUES', 203, '', '73900-00', 'POSSE', 'GOIAS', 'GO'),
(16, 'RUA GERCINO RODRIGUES', 206, '', '73900-00', 'POSSE', 'GOIAS', 'GO'),
(17, '', 0, '', '', '', '', 'SP'),
(18, '', 0, '', '', '', '', 'SP'),
(19, '', 0, '', '', '', '', 'SP'),
(20, '', 0, '', '', '', '', 'SP'),
(21, '', 0, '', '', '', '', 'SP'),
(22, '', 0, '', '', '', '', 'SP'),
(23, '', 0, '', '', '', '', 'SP'),
(24, '', 0, '', '', '', '', 'SP');

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `id_funcionario` int(10) UNSIGNED NOT NULL,
  `pessoa_id` int(10) UNSIGNED NOT NULL,
  `cargo` varchar(11) NOT NULL,
  `data_adm` date NOT NULL,
  `data_saida` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `funcionario`
--

INSERT INTO `funcionario` (`id_funcionario`, `pessoa_id`, `cargo`, `data_adm`, `data_saida`) VALUES
(1, 1, 'GERENTE', '2000-05-08', '0000-00-00'),
(2, 3, 'FUNCIONARIO', '2019-09-13', NULL),
(3, 8, 'FUNCIONARIO', '2019-10-09', '0000-00-00'),
(4, 9, 'FUNCIONARIO', '2020-10-28', '0000-00-00'),
(5, 16, 'GERENTE', '2020-10-01', '0000-00-00'),
(6, 17, 'GERENTE', '2020-10-01', '0000-00-00'),
(7, 18, 'FUNCIONARIO', '2020-10-01', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `nivel` int(1) NOT NULL,
  `funcionario_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`id_login`, `usuario`, `senha`, `nivel`, `funcionario_id`) VALUES
(1, 'FERNANDO', '80b748ee9ea34a7c75e3b6099a851223', 0, 1),
(2, 'BECCA', '22550861cec7f8db0f007d989dcca128', 1, 2),
(4, 'TJ', '456c2e75fe0faa57fd1cfd87117e0963', 1, 4),
(5, 'VISITANTE_ADMIN', '4f032cbe86da790b0134f1b234c56f3b', 0, 5),
(7, 'LORENZO', '80b748ee9ea34a7c75e3b6099a851223', 1, 3),
(8, 'TESTE', 'cfcd208495d565ef66e7dff9f98764da', 0, 6),
(9, 'VISITANTE_VISITANTE', '83b90e3c6bbf76217ec5cf77af3f54c0', 1, 7);

-- --------------------------------------------------------

--
-- Estrutura da tabela `material`
--

CREATE TABLE `material` (
  `id_material` int(10) UNSIGNED NOT NULL,
  `nome_mat` varchar(45) NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `uni_medida` varchar(45) NOT NULL,
  `quantidade` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `material`
--

INSERT INTO `material` (`id_material`, `nome_mat`, `tipo`, `uni_medida`, `quantidade`) VALUES
(1, 'COURO', 'TECIDO', 'METROS²', 1162),
(2, 'SUEDE', 'TECIDO', 'METROS²', 588),
(3, 'CORINO', 'TECIDO', 'METROS²', 663),
(4, 'ESPUMA', 'ESPUMA', 'QUILOS', 32.4),
(5, 'ZIPER', 'ZIPER', 'METROS', 240.4),
(6, 'BOTãO 3/4', 'BOTãO', 'UNIDADE', 8),
(7, 'BOTãO 1/14', 'BOTãO', 'UNIDADE', 418),
(8, 'ZIPER LG', 'ZIPER', 'METROS', 188.4),
(9, 'VELCRO', 'VELCRO', 'METROS', 42),
(11, 'ESPUMA MEIA VIDA', 'ESPUMA', 'KILO', 596.03),
(12, 'RETALHO', 'RETALHO', 'KILO', 995.16),
(13, 'SARRAFO', 'MADEIRA', 'METRO', 56),
(14, 'VELUDO', 'TECIDO', 'METRO²', 974.26);

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamento`
--

CREATE TABLE `orcamento` (
  `id_orcamento` int(10) UNSIGNED NOT NULL,
  `data_orca` date NOT NULL,
  `funcionario_id` int(10) UNSIGNED NOT NULL,
  `cliente_nome` varchar(45) NOT NULL,
  `mao_obra` double NOT NULL,
  `tipo_orca` varchar(10) NOT NULL,
  `observacao` varchar(255) DEFAULT NULL,
  `valor_total` double(10,2) NOT NULL,
  `estoque` text DEFAULT NULL,
  `status` varchar(30) NOT NULL,
  `count` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `orcamento`
--

INSERT INTO `orcamento` (`id_orcamento`, `data_orca`, `funcionario_id`, `cliente_nome`, `mao_obra`, `tipo_orca`, `observacao`, `valor_total`, `estoque`, `status`, `count`) VALUES
(633, '2019-10-17', 1, 'PEDRO BECCA', 21, '', 'ASSENTO:  LARGURA: 190 CM - ALTURA: 15 CM - PROFUNDIDADE: 190 CM <br>        ', 6421.00, NULL, 'CONCLUIDO 27/11/2019 15:27', 1),
(634, '2019-09-17', 1, 'MARIA APARECIDA FRANCIOLLI', 56, '', 'ASSENTO:  LARGURA: 190 CM - ALTURA: 15 CM - PROFUNDIDADE: 190 CM <br>        ', 3256.00, NULL, 'APROVADO', 1),
(635, '2019-10-17', 1, 'GERSON FRANCIOLLI', 21, '', 'ESTOQUE INSUFICIENTE, VOCE POSSUI:  50  METRO² DE COURO NO ESTOQUE, E O ORÇAMENTO É DE  200  METRO² DE COURO', 1621.00, NULL, 'CONCLUIDO 27/11/2019 14:50', 0),
(636, '2019-10-17', 1, 'ANTONIO LORENZO', 21, '', 'ASSENTO:  LARGURA: 190 CM - ALTURA: 15 CM - PROFUNDIDADE: 190 CM <br>        ', 64021.00, NULL, 'CONCLUIDO 31/10/2019 00:04', 0),
(637, '2019-10-17', 1, 'ANTONIO LORENZO', 21, '', 'ASSENTO:  LARGURA: 190 CM - ALTURA: 15 CM - PROFUNDIDADE: 190 CM <br>        ', 64021.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI: 50  METRO² DE COURO NO ESTOQUE, E O ORÇAMENTO É DE  8000  METRO² DE COURO            ', 'CANCELADO', 0),
(638, '2019-10-17', 1, 'ANTONIO LORENZO', 21, '', 'ASSENTO:  LARGURA: 190 CM - ALTURA: 15 CM - PROFUNDIDADE: 190 CM <br>        ', 64021.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI: 50  METRO² DE COURO NO ESTOQUE, E O ORÇAMENTO É DE  8000  METRO² DE COURO            ', 'APROVADO', 1),
(639, '2019-10-17', 1, 'ANTONIO LORENZO', 21, '', 'ASSENTO:  LARGURA: 190 CM - ALTURA: 15 CM - PROFUNDIDADE: 190 CM <br>        ', 64021.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI: {@50  METRO² DE COURO NO ESTOQUE, E O ORÇAMENTO É DE  8000  METRO² DE COURO} {@} {@}          ', 'CONCLUIDO 27/11/2019 14:52', 0),
(640, '2019-10-17', 1, 'ANTONIO LORENZO', 21, '', 'ASSENTO:  LARGURA: 190 CM - ALTURA: 15 CM - PROFUNDIDADE: 190 CM <br>        ', 64021.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI: 50  METRO² DE COURO NO ESTOQUE, E O ORÇAMENTO É DE  8000  METRO² DE COURO            ', 'APROVADO', 1),
(641, '2019-10-17', 1, 'ANTONIO LORENZO', 21, '', 'ASSENTO:  LARGURA: 190 CM - ALTURA: 15 CM - PROFUNDIDADE: 190 CM <br>        ', 64021.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI: 50  METRO² DE COURO NO ESTOQUE, E O ORÇAMENTO É DE  8000  METRO² DE COURO            ', 'CONCLUIDO 27/11/2019 14:53', 0),
(642, '2019-10-17', 1, 'ANTONIO LORENZO', 21, '', 'ASSENTO:  LARGURA: 190 CM - ALTURA: 15 CM - PROFUNDIDADE: 190 CM <br>        ', 4613.53, 'ESTOQUE INSUFICIENTE VOCE POSSUI: 600  METRO² DE SUEDE NO ESTOQUE, E O ORÇAMENTO É DE  8000  METRO² DE SUEDE            ', 'CONCLUIDO 27/11/2019 14:54', 0),
(643, '2018-10-17', 1, 'ANTONIO LORENZO', 21, '', 'ASSENTO:  LARGURA: 190 CM - ALTURA: 15 CM - PROFUNDIDADE: 190 CM <br>  ENCOSTO:  LARGURA: 190 CM - ALTURA: 15 CM - PROFUNDIDADE: 190 CM      ', 5444.84, 'ESTOQUE INSUFICIENTE VOCE POSSUI: 600  METRO² DE SUEDE NO ESTOQUE, E O ORÇAMENTO É DE  8000  METRO² DE SUEDE    695  METRO² DE CORINO NO ESTOQUE, E O ORÇAMENTO É DE  4000  METRO² DE CORINO        ', 'CANCELADO', 0),
(644, '2019-10-29', 1, 'GERSON FRANCIOLLI', 20, '', 'ASSENTO:  LARGURA: 130 CM - ALTURA: 155 CM - PROFUNDIDADE: 130 CM <br>  ENCOSTO:  LARGURA: 130 CM - ALTURA: 155 CM - PROFUNDIDADE: 120 CM   ALMOFADA:  LARGURA: 100 CM - ALTURA: 30 CM - PROFUNDIDADE: 100 CM   ESTRUTURA  COMPRIMENTO: 2 METROS', 499.51, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'APROVADO', 1),
(645, '2019-10-29', 1, 'GERSON FRANCIOLLI', 20, '', 'ASSENTO:  LARGURA: 130 CM - ALTURA: 155 CM - PROFUNDIDADE: 130 CM <br>  ENCOSTO:  LARGURA: 130 CM - ALTURA: 155 CM - PROFUNDIDADE: 120 CM   ALMOFADA:  LARGURA: 100 CM - ALTURA: 30 CM - PROFUNDIDADE: 100 CM   ESTRUTURA  COMPRIMENTO: 2 METROS', 499.51, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'APROVADO', 1),
(646, '2019-09-23', 1, 'ANTONIO LORENZO', 21, 'sofa', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM <br>        ', 37.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CONCLUIDO 27/11/2019 14:55', 0),
(647, '2019-11-23', 1, 'ANTONIO LORENZO', 55, 'cadeira', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM <br>        ', 71.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CANCELADO', 0),
(648, '2019-11-23', 1, 'GERSON FRANCIOLLI', 8, 'cadeira', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM <br>        ', 24.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CANCELADO', 0),
(649, '2019-11-23', 1, 'MARIA APARECIDA FRANCIOLLI', 10, 'colchao', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM <br>        ', 26.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CONCLUIDO 27/11/2019 14:59', 0),
(650, '2019-11-23', 1, 'MARIA APARECIDA FRANCIOLLI', 50, 'COLCHAO', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM <br>        ', 66.03, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'APROVADO', 1),
(656, '2019-11-23', 1, 'MARIA APARECIDA FRANCIOLLI', 90, 'SOFA', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM <br>        ', 106.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'APROVADO', 1),
(657, '2019-08-18', 1, 'PEDRO BECCA', 115, 'SOFA', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 155 CM <br>        ', 124.27, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CANCELADO', 0),
(658, '2019-07-28', 1, 'ANTONIO LORENZO', 30, 'CADEIRA', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 140 CM <br>  ENCOSTO:  LARGURA: 140 CM - ALTURA: 10 CM - PROFUNDIDADE: 140 CM      ', 183.40, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'APROVADO', 1),
(659, '2019-07-28', 1, 'ANTONIO LORENZO', 40, 'BANCO', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 140 CM <br>  ENCOSTO:  LARGURA: 140 CM - ALTURA: 10 CM - PROFUNDIDADE: 140 CM      ', 193.40, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CONCLUIDO 27/11/2019 15:00', 0),
(660, '2019-07-28', 1, 'PEDRO BECCA', 10, 'BANCO', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 140 CM <br>  ENCOSTO:  LARGURA: 140 CM - ALTURA: 10 CM - PROFUNDIDADE: 140 CM      ', 234.62, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'APROVADO', 1),
(661, '2019-06-08', 1, 'PEDRO BECCA', 50, 'BANCO', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 140 CM <br>  ENCOSTO:  LARGURA: 140 CM - ALTURA: 10 CM - PROFUNDIDADE: 140 CM      ', 274.62, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CONCLUIDO 27/11/2019 14:50', 0),
(662, '2019-06-08', 1, 'VICTOR FRANCIOLLI', 50, 'BANCO', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 140 CM <br>  ENCOSTO:  LARGURA: 140 CM - ALTURA: 10 CM - PROFUNDIDADE: 140 CM      ', 274.62, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CONCLUIDO 27/11/2019 15:22', 0),
(663, '2019-06-08', 1, 'VICTOR FRANCIOLLI', 50, 'BANCO', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 140 CM <br>  ENCOSTO:  LARGURA: 140 CM - ALTURA: 10 CM - PROFUNDIDADE: 140 CM      ', 274.62, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'APROVADO', 1),
(664, '2019-06-08', 1, 'GERSON FRANCIOLLI', 50, 'BANCO', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 140 CM <br>  ENCOSTO:  LARGURA: 140 CM - ALTURA: 10 CM - PROFUNDIDADE: 140 CM      ', 274.62, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CANCELADO', 0),
(665, '2019-06-08', 1, 'GERSON FRANCIOLLI', 100, 'BANCO', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 140 CM <br>  ENCOSTO:  LARGURA: 140 CM - ALTURA: 10 CM - PROFUNDIDADE: 140 CM      ', 324.62, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CANCELADO', 0),
(666, '2019-06-08', 1, 'COCA-COLA', 50, 'COLCHÃO', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 140 CM <br>        ', 53.97, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CANCELADO', 0),
(667, '2019-06-08', 1, 'COCA-COLA', 50, 'COLCHÃO', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 140 CM <br>     ALMOFADA:  LARGURA: 100 CM - ALTURA: 20 CM - PROFUNDIDADE: 100 CM   ', 0.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:               DE  NO ESTOQUE, E O ORÇAMENTO É DE 8   DE  ', 'CANCELADO', 0),
(668, '2019-06-08', 1, 'COCA-COLA', 50, 'OUTRO', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 140 CM <br>     ALMOFADA:  LARGURA: 100 CM - ALTURA: 20 CM - PROFUNDIDADE: 100 CM   ', 0.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:         60  METRO² DE VELUDO NO ESTOQUE, E O ORÇAMENTO É DE  200  METRO² DE VELUDO      DE  NO ESTOQUE, E O ORÇAMENTO É DE 200   DE  ', 'CANCELADO', 0),
(669, '2019-11-27', 1, 'COCA-COLA', 50, 'BANCO', 'ASSENTO:  LARGURA: 160 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM <br>        ', 52.47, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CONCLUIDO 27/11/2019 15:27', 0),
(670, '2019-08-10', 1, 'COCA-COLA', 10, 'SOFA', 'ASSENTO:  LARGURA: 170 CM - ALTURA: 30 CM - PROFUNDIDADE: 160 CM <br>  ENCOSTO:  LARGURA: 100 CM - ALTURA: 30 CM - PROFUNDIDADE: 120 CM      ', 609.32, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CONCLUIDO 27/11/2019 15:28', 0),
(671, '2019-08-10', 1, 'COCA-COLA', 20, 'OUTRO', ' <br>     ALMOFADA:  LARGURA: 100 CM - ALTURA: 20 CM - PROFUNDIDADE: 100 CM   ', 29.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CONCLUIDO 27/11/2019 15:34', 0),
(672, '2019-08-10', 1, 'COCA-COLA', 20, 'OUTRO', ' <br>     ALMOFADA:  LARGURA: 100 CM - ALTURA: 20 CM - PROFUNDIDADE: 100 CM   ', 29.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CANCELADO', 0),
(673, '2019-08-10', 1, 'COCA-COLA', 20, 'OUTRO', ' <br>     ALMOFADA:  LARGURA: 150 CM - ALTURA: 20 CM - PROFUNDIDADE: 150 CM   ', 40.25, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CONCLUIDO 27/11/2019 15:35', 0),
(674, '2019-08-10', 1, 'COCA-COLA', 20, 'OUTRO', ' <br>     ALMOFADA:  LARGURA: 150 CM - ALTURA: 20 CM - PROFUNDIDADE: 150 CM   ', 40.25, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'APROVADO', 1),
(675, '2019-08-10', 1, 'COCA-COLA', 26, 'OUTRO', ' <br>        ESTRUTURA  COMPRIMENTO: 3 METROS', 140.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'APROVADO', 1),
(676, '2019-08-10', 1, 'COCA-COLA', 50, 'OUTRO', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 10 CM - PROFUNDIDADE: 150 CM <br>        ', 167.01, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'AGUARDANDO', 0),
(677, '2019-08-10', 1, 'COCA-COLA', 30, 'OUTRO', ' <br>     ALMOFADA:  LARGURA: 150 CM - ALTURA: 20 CM - PROFUNDIDADE: 150 CM   ', 30.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'APROVADO', 1),
(678, '2019-08-10', 1, 'COCA-COLA', 30, 'OUTRO', ' <br>     ALMOFADA:  LARGURA: 150 CM - ALTURA: 20 CM - PROFUNDIDADE: 150 CM   ', 30.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'APROVADO', 1),
(679, '2019-08-10', 1, 'COCA-COLA', 30, 'OUTRO', ' <br>     ALMOFADA:  LARGURA: 150 CM - ALTURA: 20 CM - PROFUNDIDADE: 150 CM   ', 230.05, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CONCLUIDO 27/11/2019 15:49', 0),
(680, '2019-08-10', 1, 'COCA-COLA', 30, 'OUTRO', ' <br>     ALMOFADA:  LARGURA: 150 CM - ALTURA: 20 CM - PROFUNDIDADE: 150 CM   ', 255.06, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CONCLUIDO 27/11/2019 15:50', 0),
(681, '2019-08-10', 1, 'COCA-COLA', 30, 'OUTRO', ' <br>     ALMOFADA:  LARGURA: 150 CM - ALTURA: 20 CM - PROFUNDIDADE: 150 CM   ', 230.05, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'APROVADO', 1),
(682, '2019-08-10', 1, 'COCA-COLA', 30, 'OUTRO', ' <br>     ALMOFADA:  LARGURA: 150 CM - ALTURA: 20 CM - PROFUNDIDADE: 150 CM   ', 31.24, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'CANCELADO', 0),
(683, '2019-08-10', 1, 'PEDRO BECCA', 50, 'SOFA', ' <br>        ESTRUTURA  COMPRIMENTO: 2 METROS', 126.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'AGUARDANDO', 0),
(684, '2019-08-10', 1, 'GERSON FRANCIOLLI', 50, 'AUTOMOVEL', ' <br>      ', 122.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:      ', 'CANCELADO', 0),
(685, '2019-08-10', 1, 'GERSON FRANCIOLLI', 50, 'AUTOMOVEL', ' <br>      ', 646.13, 'ESTOQUE INSUFICIENTE VOCE POSSUI:      ', 'CONCLUIDO 27/11/2019 15:51', 0),
(686, '2019-08-10', 1, 'GERSON FRANCIOLLI', 50, 'AUTOMOVEL', ' <br>      ', 646.13, 'ESTOQUE INSUFICIENTE VOCE POSSUI:      ', 'CONCLUIDO 27/11/2019 15:51', 0),
(687, '2019-01-10', 1, 'GERSON FRANCIOLLI', 90, 'AUTOMOVEL', ' <br>    TETO  COMPRIMENTO: 3 METROS LARGURA 3 METROS  TETO  COMPRIMENTO: 5 METROS LARGURA 3 METROS', 686.13, 'ESTOQUE INSUFICIENTE VOCE POSSUI:      ', 'APROVADO', 1),
(688, '2019-01-10', 1, 'GERSON FRANCIOLLI', 100, 'AUTOMOVEL', ' <br>    TETO  COMPRIMENTO: 3 METROS LARGURA 3 METROS <br>  PISO  COMPRIMENTO: 5 METROS LARGURA 3 METROS', 696.13, 'ESTOQUE INSUFICIENTE VOCE POSSUI:      ', 'APROVADO', 1),
(689, '2019-01-10', 1, 'GERSON FRANCIOLLI', 200, 'SOFA', 'ASSENTO:  LARGURA: 160 CM - ALTURA: 15 CM - PROFUNDIDADE: 140 CM <br>  ENCOSTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM      ', 543.02, '', 'AGUARDANDO', 0),
(690, '2019-01-10', 1, 'GERSON FRANCIOLLI', 200, 'SOFA', 'ASSENTO:  LARGURA: 160 CM - ALTURA: 15 CM - PROFUNDIDADE: 140 CM <br>  ENCOSTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM      ', 543.02, '', 'APROVADO', 1),
(691, '2019-01-10', 1, 'ANTONIO LORENZO', 200, 'SOFA', ' <br>        ESTRUTURA  COMPRIMENTO: 6 METROS', 457.74, '', 'APROVADO', 1),
(692, '2019-01-10', 1, 'VICTOR FRANCIOLLI', 200, 'SOFA', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM <br>  ENCOSTO:  LARGURA: 160 CM - ALTURA: 15 CM - PROFUNDIDADE: 160 CM      ', 0.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:       DE  NO ESTOQUE, E O ORÇAMENTO É DE  15   DE  -974.26  METRO² DE VELUDO NO ESTOQUE, E O ORÇAMENTO É DE  6  METRO² DE VELUDO        ', 'CANCELADO', 0),
(693, '2019-06-26', 1, 'VICTOR FRANCIOLLI', 100, 'SOFA', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM <br>  ENCOSTO:  LARGURA: 160 CM - ALTURA: 15 CM - PROFUNDIDADE: 160 CM      ', 0.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:       DE  NO ESTOQUE, E O ORÇAMENTO É DE  15   DE  -974.26  METRO² DE VELUDO NO ESTOQUE, E O ORÇAMENTO É DE  6  METRO² DE VELUDO        ', 'CANCELADO', 0),
(694, '2019-06-26', 1, 'ANTONIO LORENZO', 20, 'SOFA', ' <br>        ESTRUTURA  COMPRIMENTO: 2 METROS', 54.07, 'ESTOQUE INSUFICIENTE VOCE POSSUI:             ', 'APROVADO', 1),
(695, '2019-06-26', 1, 'ANTONIO LORENZO', 60, 'COLCHÃO', ' <br>     ALMOFADA:  LARGURA: 160 CM - ALTURA: 20 CM - PROFUNDIDADE: 160 CM   ', 131.34, '', 'APROVADO', 1),
(696, '2019-07-26', 1, 'MARIA APARECIDA FRANCIOLLI', 50, 'COLCHÃO', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM <br>  ENCOSTO:  LARGURA: 160 CM - ALTURA: 15 CM - PROFUNDIDADE: 160 CM      ', 0.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:       DE  NO ESTOQUE, E O ORÇAMENTO É DE  15   DE  -974.26  METRO² DE VELUDO NO ESTOQUE, E O ORÇAMENTO É DE  6  METRO² DE VELUDO        ', 'CANCELADO', 0),
(697, '2019-07-26', 1, 'MARIA APARECIDA FRANCIOLLI', 20, 'CADEIRA', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM <br>        ', 21.17, '', 'CONCLUIDO 27/11/2019 19:33', 0),
(698, '2019-07-26', 1, 'MARIA APARECIDA FRANCIOLLI', 20, 'CADEIRA', ' <br>        ESTRUTURA  COMPRIMENTO: 6 METROS', 125.86, '', 'AGUARDANDO', 0),
(699, '2019-07-26', 1, 'MARIA APARECIDA FRANCIOLLI', 30, 'OUTRO', ' <br>     ALMOFADA:  LARGURA: 100 CM - ALTURA: 30 CM - PROFUNDIDADE: 100 CM   ', 74.44, '', 'AGUARDANDO', 0),
(700, '2019-10-26', 1, 'MARIA APARECIDA FRANCIOLLI', 300, 'SOFA', ' <br>     ALMOFADA:  LARGURA: 150 CM - ALTURA: 40 CM - PROFUNDIDADE: 150 CM   ', 425.06, 'ESTOQUE INSUFICIENTE VOCE POSSUI:         -9362  METROS² DE COURO NO ESTOQUE, E O ORÇAMENTO É DE  8  METROS² DE COURO    ', 'AGUARDANDO', 0),
(701, '2019-10-26', 1, 'MARIA APARECIDA FRANCIOLLI', 300, 'SOFA', ' <br>     ALMOFADA:  LARGURA: 150 CM - ALTURA: 40 CM - PROFUNDIDADE: 150 CM   ', 420.68, 'ESTOQUE INSUFICIENTE VOCE POSSUI:         -9162  METROS² DE COURO NO ESTOQUE, E O ORÇAMENTO É DE  8  METROS² DE COURO    ', 'AGUARDANDO', 0),
(702, '2019-10-26', 1, 'MARIA APARECIDA FRANCIOLLI', 300, 'SOFA', ' <br>     ALMOFADA:  LARGURA: 150 CM - ALTURA: 40 CM - PROFUNDIDADE: 150 CM   ', 420.68, 'ESTOQUE INSUFICIENTE VOCE POSSUI:         -9162  METROS² DE COURO NO ESTOQUE, E O ORÇAMENTO É DE  8  METROS² DE COURO    ', 'AGUARDANDO', 0),
(703, '2019-10-26', 1, 'MARIA APARECIDA FRANCIOLLI', 300, 'SOFA', ' <br>     ALMOFADA:  LARGURA: 150 CM - ALTURA: 40 CM - PROFUNDIDADE: 150 CM   ', 420.68, 'ESTOQUE INSUFICIENTE VOCE POSSUI:         -9162  METROS² DE COURO NO ESTOQUE, E O ORÇAMENTO É DE  8  METROS² DE COURO    ', 'AGUARDANDO', 0),
(704, '2019-10-26', 1, 'MARIA APARECIDA FRANCIOLLI', 300, 'SOFA', ' <br>     ALMOFADA:  LARGURA: 150 CM - ALTURA: 40 CM - PROFUNDIDADE: 150 CM   ', 420.68, 'ESTOQUE INSUFICIENTE VOCE POSSUI:         -9162  METROS² DE COURO NO ESTOQUE, E O ORÇAMENTO É DE  8  METROS² DE COURO    ', 'AGUARDANDO', 0),
(705, '2019-10-26', 1, 'MARIA APARECIDA FRANCIOLLI', 300, 'SOFA', ' <br>     ALMOFADA:  LARGURA: 150 CM - ALTURA: 40 CM - PROFUNDIDADE: 150 CM   ', 420.68, 'ESTOQUE INSUFICIENTE VOCE POSSUI:         -9162  METROS² DE COURO NO ESTOQUE, E O ORÇAMENTO É DE  8  METROS² DE COURO    ', 'AGUARDANDO', 0),
(706, '2019-10-26', 1, 'MARIA APARECIDA FRANCIOLLI', 300, 'SOFA', ' <br>     ALMOFADA:  LARGURA: 150 CM - ALTURA: 40 CM - PROFUNDIDADE: 150 CM   ', 420.68, 'ESTOQUE INSUFICIENTE VOCE POSSUI:         -9162  METROS² DE COURO NO ESTOQUE, E O ORÇAMENTO É DE  8  METROS² DE COURO    ', 'AGUARDANDO', 0),
(707, '2019-10-26', 1, 'MARIA APARECIDA FRANCIOLLI', 300, 'SOFA', ' <br>     ALMOFADA:  LARGURA: 150 CM - ALTURA: 40 CM - PROFUNDIDADE: 150 CM   ', 430.12, '', 'AGUARDANDO', 0),
(708, '2019-11-27', 1, 'ANTONIO LORENZO', 20, 'OUTRO', ' <br>        ESTRUTURA  COMPRIMENTO: 3 METROS', 72.93, '', 'AGUARDANDO', 0),
(709, '2019-11-28', 1, 'PEDRO BECCA', 50, 'SOFA', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM <br>        ', 0.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:       DE  NO ESTOQUE, E O ORÇAMENTO É DE  15   DE          ', 'AGUARDANDO', 0),
(710, '2019-11-28', 1, 'PEDRO BECCA', 50, 'SOFA', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM <br>        ', 0.00, 'ESTOQUE INSUFICIENTE VOCE POSSUI:       DE  NO ESTOQUE, E O ORÇAMENTO É DE  10   DE          ', 'AGUARDANDO', 0),
(711, '2019-11-28', 1, 'PEDRO BECCA', 50, 'SOFA', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM <br>        ', 126.09, 'ESTOQUE INSUFICIENTE VOCE POSSUI:    8  UNIDADE DE BOTãO 3/4 NO ESTOQUE, E O ORÇAMENTO É DE  10  UNIDADE DE BOTãO 3/4         ', 'AGUARDANDO', 0),
(712, '2019-11-28', 1, 'PEDRO BECCA', 50, 'SOFA', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM <br>        ', 126.09, 'ESTOQUE INSUFICIENTE VOCE POSSUI:    8  UNIDADE DE BOTãO 3/4 NO ESTOQUE, E O ORÇAMENTO É DE  10  UNIDADE DE BOTãO 3/4         ', 'AGUARDANDO', 0),
(713, '2019-11-28', 1, 'PEDRO BECCA', 50, 'SOFA', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM <br>        ', 98.09, '', 'AGUARDANDO', 0),
(714, '2019-11-28', 1, 'PEDRO BECCA', 50, 'CADEIRA', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM <br>        ', 98.09, '', 'AGUARDANDO', 0),
(715, '2019-11-28', 1, 'PEDRO BECCA', 50, 'CADEIRA', 'ASSENTO:  LARGURA: 150 CM - ALTURA: 15 CM - PROFUNDIDADE: 150 CM <br>        ', 74.49, 'ESTOQUE INSUFICIENTE VOCE POSSUI:    200  UNIDADE DE BOTãO 3/4 NO ESTOQUE, E O ORÇAMENTO É DE  20  UNIDADE DE BOTãO 3/4         ', 'AGUARDANDO', 0);

--
-- Acionadores `orcamento`
--
DELIMITER $$
CREATE TRIGGER `REMOVE MATERIAL` AFTER DELETE ON `orcamento` FOR EACH ROW DELETE FROM orcamento_material WHERE old.id_orcamento = orcamento_material.orcamento_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamento_material`
--

CREATE TABLE `orcamento_material` (
  `orcamento_id` int(10) UNSIGNED NOT NULL,
  `material_id` int(10) UNSIGNED NOT NULL,
  `quantidade_mat` decimal(10,2) NOT NULL,
  `total_mat` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `orcamento_material`
--

INSERT INTO `orcamento_material` (`orcamento_id`, `material_id`, `quantidade_mat`, `total_mat`) VALUES
(633, 1, '800.00', '6400.00'),
(634, 1, '400.00', '3200.00'),
(635, 1, '200.00', '1600.00'),
(636, 1, '8000.00', '64000.00'),
(637, 1, '8000.00', '64000.00'),
(638, 1, '8000.00', '64000.00'),
(639, 1, '8000.00', '64000.00'),
(640, 1, '8000.00', '64000.00'),
(641, 1, '8000.00', '64000.00'),
(642, 2, '8000.00', '4592.53'),
(643, 2, '8000.00', '4592.53'),
(643, 3, '4000.00', '831.31'),
(644, 1, '8.00', '64.00'),
(644, 4, '10.48', '209.56'),
(644, 5, '5.20', '2.08'),
(644, 6, '20.00', '4.50'),
(644, 14, '3.00', '100.03'),
(644, 12, '2.42', '0.01'),
(644, 8, '1.30', '0.30'),
(644, 6, '5.00', '1.48'),
(644, 3, '16.00', '3.32'),
(644, 11, '1.20', '0.44'),
(644, 9, '4.00', '4.32'),
(644, 6, '20.00', '23.60'),
(644, 13, '2.00', '65.87'),
(645, 1, '8.00', '64.00'),
(645, 4, '10.48', '209.56'),
(645, 5, '5.20', '2.08'),
(645, 6, '20.00', '4.50'),
(645, 14, '3.00', '100.03'),
(645, 12, '2.42', '0.01'),
(645, 8, '1.30', '0.30'),
(645, 6, '5.00', '1.48'),
(645, 3, '16.00', '3.32'),
(645, 11, '1.20', '0.44'),
(645, 9, '4.00', '4.32'),
(645, 6, '20.00', '23.60'),
(645, 13, '2.00', '65.87'),
(646, 1, '2.00', '16.00'),
(647, 1, '2.00', '16.00'),
(648, 1, '2.00', '16.00'),
(649, 1, '2.00', '16.00'),
(650, 1, '2.00', '16.00'),
(656, 1, '2.00', '16.00'),
(657, 2, '4.00', '2.29'),
(657, 4, '0.70', '6.98'),
(658, 2, '4.00', '2.29'),
(658, 4, '0.63', '6.30'),
(658, 8, '3.00', '0.69'),
(658, 6, '6.00', '1.77'),
(658, 14, '4.00', '133.37'),
(658, 11, '0.39', '0.07'),
(658, 5, '2.80', '1.12'),
(658, 7, '8.00', '7.79'),
(659, 2, '4.00', '2.29'),
(659, 4, '0.63', '6.30'),
(659, 8, '3.00', '0.69'),
(659, 6, '6.00', '1.77'),
(659, 14, '4.00', '133.37'),
(659, 11, '0.39', '0.07'),
(659, 5, '2.80', '1.12'),
(659, 7, '8.00', '7.79'),
(660, 2, '4.00', '2.29'),
(660, 4, '0.63', '6.30'),
(660, 8, '3.00', '0.69'),
(660, 6, '6.00', '1.77'),
(660, 14, '6.00', '200.05'),
(660, 11, '0.59', '0.16'),
(660, 5, '4.20', '1.68'),
(660, 7, '12.00', '11.68'),
(661, 2, '4.00', '2.29'),
(661, 4, '0.63', '6.30'),
(661, 8, '3.00', '0.69'),
(661, 6, '6.00', '1.77'),
(661, 14, '6.00', '200.05'),
(661, 11, '0.59', '0.16'),
(661, 5, '4.20', '1.68'),
(661, 7, '12.00', '11.68'),
(662, 2, '4.00', '2.29'),
(662, 4, '0.63', '6.30'),
(662, 8, '3.00', '0.69'),
(662, 6, '6.00', '1.77'),
(662, 14, '6.00', '200.05'),
(662, 11, '0.59', '0.16'),
(662, 5, '4.20', '1.68'),
(662, 7, '12.00', '11.68'),
(663, 2, '4.00', '2.29'),
(663, 4, '0.63', '6.30'),
(663, 8, '3.00', '0.69'),
(663, 6, '6.00', '1.77'),
(663, 14, '6.00', '200.05'),
(663, 11, '0.59', '0.16'),
(663, 5, '4.20', '1.68'),
(663, 7, '12.00', '11.68'),
(664, 2, '4.00', '2.29'),
(664, 4, '0.63', '6.30'),
(664, 8, '3.00', '0.69'),
(664, 6, '6.00', '1.77'),
(664, 14, '6.00', '200.05'),
(664, 11, '0.59', '0.16'),
(664, 5, '4.20', '1.68'),
(664, 7, '12.00', '11.68'),
(665, 2, '4.00', '2.29'),
(665, 4, '0.63', '6.30'),
(665, 8, '3.00', '0.69'),
(665, 6, '6.00', '1.77'),
(665, 14, '6.00', '200.05'),
(665, 11, '0.59', '0.16'),
(665, 5, '4.20', '1.68'),
(665, 7, '12.00', '11.68'),
(666, 2, '2.00', '1.15'),
(666, 4, '0.32', '1.58'),
(666, 8, '1.50', '0.35'),
(666, 6, '3.00', '0.89'),
(666, 14, '0.00', '0.00'),
(666, 11, '0.00', '0.00'),
(666, 5, '0.00', '0.00'),
(666, 7, '0.00', '0.00'),
(667, 2, '2.00', '1.15'),
(667, 4, '0.32', '1.58'),
(667, 8, '1.50', '0.35'),
(667, 6, '3.00', '0.89'),
(667, 14, '0.00', '0.00'),
(667, 14, '8.00', '266.74'),
(667, 6, '8.00', '0.00'),
(668, 2, '2.00', '1.15'),
(668, 4, '0.32', '1.58'),
(668, 8, '1.50', '0.35'),
(668, 6, '3.00', '0.89'),
(668, 14, '0.00', '0.00'),
(668, 14, '200.00', '6668.43'),
(668, 6, '200.00', '0.00'),
(671, 14, '0.00', '0.00'),
(671, 4, '0.60', '9.00'),
(672, 3, '0.00', '0.00'),
(672, 4, '0.60', '9.00'),
(673, 3, '0.00', '0.00'),
(673, 4, '1.35', '20.25'),
(674, 3, '0.00', '0.00'),
(674, 4, '1.35', '20.25'),
(677, 14, '0.00', '0.00'),
(678, 14, '0.00', '0.00'),
(679, 14, '6.00', '200.05'),
(680, 14, '6.75', '225.06'),
(681, 14, '6.00', '200.05'),
(682, 3, '6.00', '1.24'),
(684, 1, '72.00', '72.00'),
(684, 14, '0.00', '0.00'),
(685, 1, '96.00', '96.00'),
(685, 14, '500.13', '500.13'),
(686, 1, '96.00', '96.00'),
(686, 14, '500.13', '500.13'),
(687, 1, '96.00', '96.00'),
(687, 14, '500.13', '500.13'),
(688, 1, '96.00', '96.00'),
(688, 14, '500.13', '500.13'),
(669, 2, '4.00', '2.34'),
(669, 11, '0.72', '0.13'),
(670, 14, '6.00', '315.87'),
(670, 4, '1.63', '26.36'),
(670, 14, '4.00', '210.58'),
(670, 4, '1.44', '46.51'),
(689, 14, '6.00', '315.87'),
(689, 4, '1.01', '24.42'),
(689, 4, '0.34', '2.73'),
(690, 14, '6.00', '315.87'),
(690, 4, '1.01', '24.42'),
(690, 4, '0.34', '2.73'),
(676, 2, '200.00', '117.01'),
(683, 13, '2.00', '76.00'),
(675, 13, '3.00', '114.00'),
(691, 13, '6.00', '257.74'),
(692, 3, '6.00', '1.30'),
(692, 4, '1.01', '26.45'),
(692, 6, '15.00', '0.00'),
(692, 14, '6.00', '-12.32'),
(692, 4, '0.77', '13.38'),
(693, 3, '6.00', '1.30'),
(693, 4, '1.01', '26.45'),
(693, 6, '15.00', '0.00'),
(693, 14, '6.00', '-12.32'),
(693, 4, '0.77', '13.38'),
(696, 3, '6.00', '1.30'),
(696, 4, '1.01', '26.45'),
(696, 6, '15.00', '0.00'),
(696, 14, '6.00', '-12.32'),
(696, 4, '0.77', '13.38'),
(700, 1, '8.00', '-0.34'),
(700, 4, '3.60', '125.40'),
(701, 1, '8.00', '-4.72'),
(701, 4, '3.60', '125.40'),
(702, 1, '8.00', '-4.72'),
(702, 4, '3.60', '125.40'),
(703, 1, '8.00', '-4.72'),
(703, 4, '3.60', '125.40'),
(704, 1, '8.00', '-4.72'),
(704, 4, '3.60', '125.40'),
(705, 1, '8.00', '-4.72'),
(705, 4, '3.60', '125.40'),
(706, 1, '8.00', '-4.72'),
(706, 4, '3.60', '125.40'),
(707, 1, '8.00', '4.72'),
(707, 4, '3.60', '125.40'),
(694, 13, '2.00', '34.07'),
(695, 14, '0.00', '0.00'),
(695, 4, '2.05', '71.34'),
(697, 2, '2.00', '1.17'),
(698, 13, '6.00', '105.86'),
(699, 3, '0.00', '0.00'),
(699, 4, '1.20', '44.44'),
(708, 13, '3.00', '52.93'),
(709, 2, '6.00', '3.51'),
(709, 4, '1.01', '28.13'),
(709, 6, '15.00', '0.00'),
(710, 2, '4.00', '2.34'),
(710, 6, '10.00', '0.00'),
(711, 2, '4.00', '2.34'),
(711, 6, '10.00', '73.75'),
(712, 2, '4.00', '2.34'),
(712, 6, '10.00', '73.75'),
(713, 1, '4.00', '18.59'),
(713, 6, '4.00', '29.50'),
(714, 1, '4.00', '18.59'),
(714, 6, '4.00', '29.50'),
(715, 1, '4.00', '18.59'),
(715, 6, '20.00', '5.90');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa`
--

CREATE TABLE `pessoa` (
  `id_pessoa` int(10) UNSIGNED NOT NULL,
  `nome` varchar(45) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `data_nasc` date NOT NULL,
  `email` varchar(45) NOT NULL,
  `telefone` varchar(16) DEFAULT NULL,
  `endereco_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pessoa`
--

INSERT INTO `pessoa` (`id_pessoa`, `nome`, `cpf`, `data_nasc`, `email`, `telefone`, `endereco_id`) VALUES
(1, 'FERNANDO FRANCIOLLI', '30397536810', '1982-08-04', 'FHFROSACRUZ@HOTMAIL.COM', '(11)986766251', 1),
(2, 'ANTONIO LORENZO', '54545646546', '2015-01-31', 'LORENZO@GMAIL.COM', '(54) 48464-65', 2),
(3, 'ALESSANDRA BECCA', '14590382822', '1973-01-26', 'BECCAALE@GMAIL.COM', '(19) 3304-052', 3),
(4, 'PEDRO BECCA', '65465456465', '2003-06-12', 'PEDRO@HOTMAIL.COM', '(19) 56488-5555', 8),
(5, 'GERSON FRANCIOLLI', '34564784676', '1960-12-11', 'GERSON@HOTMAIL.COM', '(11) 2952-2626', 9),
(6, 'MARIA APARECIDA FRANCIOLLI', '47875487464', '1953-11-04', 'CIDA@HOTMAIL.COM', '(11) 98676-8547', 10),
(8, 'LORENZO FRANCIOLLI', '99794646464', '1951-06-06', 'LORENZO@HOTMAIL.COM', '(11) 65655-6567', 12),
(9, 'TIAGO', '12345678978', '2020-12-20', 'RAPHAEL.CSP@GMAIL.COM', '(19) 11999-9999', 13),
(10, 'VICTOR FRANCIOLLI', '43465468468', '2017-08-04', '', '', 14),
(16, 'VISITANTE_ADMIN', '88888888888', '1982-09-05', 'ADMIN@ADMIN.COM.BR', '', 22),
(17, 'TESTE', '99999999999', '1960-09-08', 'TESTE@TESTE.COM', '', 23),
(18, 'VISITANTE_VISITANTE', '66666666666', '1980-10-12', 'VISITANTE_VISITANTE@VISITANTE.COM', '', 24);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `fk_compra_material1` (`material_id`);

--
-- Índices para tabela `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`),
  ADD UNIQUE KEY `cnpj_UNIQUE` (`cnpj`),
  ADD UNIQUE KEY `razao_social_UNIQUE` (`razao_social`),
  ADD KEY `fk_empresa_endereco1` (`endereco_id`);

--
-- Índices para tabela `endereco`
--
ALTER TABLE `endereco`
  ADD PRIMARY KEY (`id_endereco`);

--
-- Índices para tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id_funcionario`),
  ADD KEY `fk_funcionario_pessoa1` (`pessoa_id`);

--
-- Índices para tabela `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`),
  ADD UNIQUE KEY `ususario_UNIQUE` (`usuario`),
  ADD KEY `fk_login_funcionario1` (`funcionario_id`);

--
-- Índices para tabela `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id_material`),
  ADD UNIQUE KEY `nome_UNIQUE` (`nome_mat`);

--
-- Índices para tabela `orcamento`
--
ALTER TABLE `orcamento`
  ADD PRIMARY KEY (`id_orcamento`);

--
-- Índices para tabela `pessoa`
--
ALTER TABLE `pessoa`
  ADD PRIMARY KEY (`id_pessoa`),
  ADD UNIQUE KEY `cpf_UNIQUE` (`cpf`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `fk_pessoa_endereco1` (`endereco_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `compra`
--
ALTER TABLE `compra`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `endereco`
--
ALTER TABLE `endereco`
  MODIFY `id_endereco` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id_funcionario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `material`
--
ALTER TABLE `material`
  MODIFY `id_material` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `orcamento`
--
ALTER TABLE `orcamento`
  MODIFY `id_orcamento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=716;

--
-- AUTO_INCREMENT de tabela `pessoa`
--
ALTER TABLE `pessoa`
  MODIFY `id_pessoa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_compra_material1` FOREIGN KEY (`material_id`) REFERENCES `material` (`id_material`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `fk_empresa_endereco1` FOREIGN KEY (`endereco_id`) REFERENCES `endereco` (`id_endereco`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD CONSTRAINT `fk_funcionario_pessoa1` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id_pessoa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `fk_login_funcionario1` FOREIGN KEY (`funcionario_id`) REFERENCES `funcionario` (`id_funcionario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `pessoa`
--
ALTER TABLE `pessoa`
  ADD CONSTRAINT `fk_pessoa_endereco1` FOREIGN KEY (`endereco_id`) REFERENCES `endereco` (`id_endereco`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
