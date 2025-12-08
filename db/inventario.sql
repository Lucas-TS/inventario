-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 08/12/2025 às 12:12
-- Versão do servidor: 8.4.5
-- Versão do PHP: 8.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `inventario`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `assoc_hd`
--

CREATE TABLE `assoc_hd` (
  `id` int NOT NULL,
  `id_pc` int NOT NULL,
  `id_hd` int NOT NULL,
  `tipo` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `saude` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `assoc_monitor`
--

CREATE TABLE `assoc_monitor` (
  `id` int NOT NULL,
  `id_pc` int NOT NULL,
  `id_monitor` int NOT NULL,
  `conexao` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `assoc_office`
--

CREATE TABLE `assoc_office` (
  `id` int NOT NULL,
  `id_pc` int NOT NULL,
  `id_office` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `assoc_placa_video`
--

CREATE TABLE `assoc_placa_video` (
  `id` int NOT NULL,
  `id_pc` int NOT NULL,
  `id_placa_video` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `assoc_processador`
--

CREATE TABLE `assoc_processador` (
  `id` int NOT NULL,
  `id_pc` int NOT NULL,
  `id_processador` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `assoc_so`
--

CREATE TABLE `assoc_so` (
  `id` int NOT NULL,
  `id_pc` int NOT NULL,
  `id_so` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `assoc_ssd`
--

CREATE TABLE `assoc_ssd` (
  `id` int NOT NULL,
  `id_pc` int NOT NULL,
  `id_ssd` int NOT NULL,
  `tipo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `saude` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `computadores`
--

CREATE TABLE `computadores` (
  `ativo` tinyint(1) NOT NULL,
  `tipo` int NOT NULL,
  `id` int NOT NULL,
  `id_operador` int DEFAULT NULL,
  `lacre` int DEFAULT NULL,
  `marca` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `modelo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `garantia` int DEFAULT NULL,
  `tam_mem` int NOT NULL,
  `tipo_mem` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tela` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `antivirus` tinyint(1) NOT NULL,
  `rede` tinyint(1) NOT NULL,
  `mac` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `wifi` tinyint(1) NOT NULL,
  `mac_wifi` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ip` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hostname` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `licenca_so` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `licenca_office` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usuario` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data_inclusao` datetime NOT NULL,
  `id_inclusao` int NOT NULL,
  `data_atualizacao` datetime DEFAULT NULL,
  `id_atualizacao` int DEFAULT NULL,
  `situacao` int DEFAULT NULL,
  `observacao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `lista_hd`
--

CREATE TABLE `lista_hd` (
  `ativo` tinyint(1) NOT NULL,
  `id` int NOT NULL,
  `tamanho` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `lista_hd`
--

INSERT INTO `lista_hd` (`ativo`, `id`, `tamanho`) VALUES
(1, 1, '1,0 TB'),
(1, 2, '500 GB'),
(1, 3, '250 GB'),
(1, 4, '320 GB');

-- --------------------------------------------------------

--
-- Estrutura para tabela `lista_monitor`
--

CREATE TABLE `lista_monitor` (
  `ativo` tinyint(1) NOT NULL,
  `id` int NOT NULL,
  `marca` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `modelo` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tamanho_tela` float(4,1) NOT NULL,
  `resolucao` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hdmi` int DEFAULT NULL,
  `dp` int DEFAULT NULL,
  `dvi` int DEFAULT NULL,
  `vga` int DEFAULT NULL,
  `usb` int DEFAULT NULL,
  `p2` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `lista_monitor`
--

INSERT INTO `lista_monitor` (`ativo`, `id`, `marca`, `modelo`, `tamanho_tela`, `resolucao`, `hdmi`, `dp`, `dvi`, `vga`, `usb`, `p2`) VALUES
(1, 1, 'Lenovo', 'T24i-30', 23.8, '1920x1080', 1, 1, NULL, 1, 4, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `lista_office`
--

CREATE TABLE `lista_office` (
  `ativo` tinyint(1) NOT NULL,
  `id` int NOT NULL,
  `dev` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nome` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `versao` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `edicao` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `lista_office`
--

INSERT INTO `lista_office` (`ativo`, `id`, `dev`, `nome`, `versao`, `edicao`) VALUES
(1, 1, 'Ascensio System SIA', 'OnlyOffice', '9.1.0', ''),
(1, 2, 'Microsoft', 'Office', '365', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `lista_placa_video`
--

CREATE TABLE `lista_placa_video` (
  `ativo` tinyint(1) NOT NULL,
  `id` int NOT NULL,
  `seguimento` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gpu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `marca` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `modelo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `memoria` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `lista_placa_video`
--

INSERT INTO `lista_placa_video` (`ativo`, `id`, `seguimento`, `gpu`, `marca`, `modelo`, `memoria`) VALUES
(1, 1, 'Desktop', 'AMD Radeon R5 230', 'VTX', '3D', '2,0 GB DDR3'),
(1, 2, 'Desktop', 'NVIDIA GeForce 210', 'Knup', 'KP-GT210', '1,0 GB DDR2'),
(1, 3, 'Desktop', 'AMD Radeon HD 7470', 'Dell', 'Low Profile', '1,0 GB GDDR3'),
(1, 5, 'Desktop', 'AMD Radeon HD 6450', 'PowerColor', 'Low Profile', '2,0 GB DDR3'),
(0, 6, 'Desktop', 'NVIDIA GeForce 6200 TurboCache', 'NVIDIA', 'NVIDIA GeForce 6200 TurboCache', '4,0 GB undefined'),
(1, 7, 'Desktop', 'NVIDIA GeForce 6200', 'NVIDIA', 'TurboCache', '4,0 GB DDR2'),
(1, 8, 'Desktop', 'NVIDIA GeForce 210', 'MSI', '2X', '2,0 GB DDR3'),
(1, 9, 'Desktop', 'NVIDIA GeForce 210', 'NVIDIA', 'Speedster SWFT210', '2,0 GB DDR3');

-- --------------------------------------------------------

--
-- Estrutura para tabela `lista_processador`
--

CREATE TABLE `lista_processador` (
  `ativo` tinyint(1) NOT NULL,
  `id` int NOT NULL,
  `marca` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `modelo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `geracao` int DEFAULT NULL,
  `socket` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `seguimento` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `clock` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `turbo` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pcores` int NOT NULL,
  `ecores` int DEFAULT NULL,
  `threads` int NOT NULL,
  `memoria` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `igpu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `lista_processador`
--

INSERT INTO `lista_processador` (`ativo`, `id`, `marca`, `modelo`, `geracao`, `socket`, `seguimento`, `clock`, `turbo`, `pcores`, `ecores`, `threads`, `memoria`, `igpu`) VALUES
(1, 1, 'Intel', 'Core i5-9400', 9, 'LGA 1151', 'Desktop', '2.90', '4.10', 6, NULL, 6, 'DDR4', 'Intel UHD Graphics 630'),
(1, 2, 'Intel', 'Core i7-4790', 4, 'LGA 1150', 'Desktop', '3.60', '4.00', 4, NULL, 8, 'DDR3', 'Intel HD Graphics 4600'),
(1, 3, 'AMD', 'Ryzen 3 2200G', 1, 'AM4', 'Desktop', '3.50', '3.70', 4, NULL, 4, 'DDR4', 'Radeon Vega 8 Graphics'),
(1, 4, 'Intel', 'Core i5-4460', 4, 'LGA 1150', 'Desktop', '3.20', '3.40', 4, NULL, 4, 'DDR3', 'Intel HD Graphics 4600'),
(1, 5, 'Intel', 'Core i7-3770', 3, 'LGA 1155', 'Desktop', '3.40', '3.90', 4, NULL, 8, 'DDR3', 'Intel HD Graphics 4000'),
(1, 6, 'Intel', 'Core i5-2310', 2, 'LGA 1155', 'Desktop', '2.90', '3.20', 4, NULL, 4, 'DDR3', 'Intel HD Graphics 2000'),
(1, 7, 'AMD', 'Ryzen 5 3400G', 3, 'AM4', 'Desktop', '3.07', '4.20', 4, NULL, 8, 'DDR4', 'Radeon Vega 11 Graphics'),
(1, 8, 'Intel', 'Core i5-7400', 7, 'LGA 1151', 'Desktop', '3.00', '3.50', 4, NULL, 4, 'DDR3, DDR4', 'Intel HD Graphics 630'),
(1, 9, 'Intel', 'Core i7-6700', 6, 'LGA 1151', 'Desktop', '3.40', '4.00', 4, NULL, 8, 'DDR3, DDR4', 'Intel HD Graphics 530'),
(1, 10, 'Intel', 'Core 2 Duo E7500', 2, 'LGA775', 'Desktop', '2.93', '3.20', 2, NULL, 2, 'DDR2, DDR3', NULL),
(1, 11, 'Intel', 'Core i5-3470', 3, 'LGA 1155', 'Desktop', '3.20', '3.60', 4, NULL, 4, 'DDR3', 'Intel HD Graphics 2500'),
(1, 12, 'AMD', 'FX-4300', 2, 'AM3', 'Desktop', '3.80', '4.00', 4, NULL, 4, 'DDR3', NULL),
(1, 14, 'Intel', 'Core i3-4160', 4, 'LGA 1150', 'Desktop', '3.60', '3.60', 2, NULL, 4, 'DDR3', 'Intel HD Graphics 4400'),
(1, 15, 'Intel', 'Core i3-13100', 13, 'LGA 1700', 'Desktop', '3.40', '4.50', 4, NULL, 8, 'DDR4, DDR5', 'Intel UHD Graphics 730'),
(1, 16, 'Intel', 'Core 2 Duo T6600', 1, 'PGA478', 'Notebook', '2.20', '2.20', 2, NULL, 2, 'DDR2, DDR3', NULL),
(1, 17, 'Intel', 'Core i3-3240', 3, 'LGA 1155', 'Desktop', '3.40', '3.40', 2, NULL, 2, 'DDR3', 'Intel HD Graphics 4000'),
(1, 18, 'Intel', 'Core i5-3330', 3, 'LGA 1155', 'Desktop', '3.00', '3.20', 4, NULL, 4, 'DDR3', 'Intel HD Graphics 2500'),
(1, 19, 'Intel', 'Core i5-12400', 12, 'FCLGA1700', 'Desktop', '2.50', '4.40', 6, 6, 12, 'DDR4, DDR5', 'Intel® UHD Graphics 730'),
(1, 20, 'Intel', 'Core i3-6100', 6, 'LGA 1151', 'Desktop', '3.70', '3.70', 2, 2, 4, 'DDR3, DDR4', 'Intel HD Graphics 530'),
(1, 21, 'Intel', 'Core i3-2100', 2, 'LGA 1155', 'Desktop', '3.10', '3.10', 2, NULL, 4, 'DDR3', 'Intel HD Graphics 2000'),
(1, 22, 'Intel', 'Pentium  E5500', 2, 'LGA775', 'Desktop', '2.80', '3.16', 2, NULL, 2, 'DDR2, DDR3', NULL),
(1, 23, 'Intel', 'Core i3-4005U', 4, 'FCBGA1168', 'Notebook', '1.70', '1.70', 2, 2, 4, 'DDR3', 'Intel® HD Graphics 4400'),
(1, 24, 'Intel', 'Core i5-7200U', 7, 'FCBGA1356', 'Notebook', '2.50', '3.10', 2, 2, 4, 'DDR3, DDR4', 'Intel HD Graphics 620'),
(1, 25, 'Intel', 'Core i3‑350M', 1, 'PGA988', 'Notebook', '2.26', '2.26', 2, 2, 4, 'DDR3', 'Intel HD Graphics'),
(1, 26, 'Intel', 'Core i3-2328M', 2, 'PGA988', 'Notebook', '2.20', '2.20', 2, 2, 4, 'DDR3', 'Intel HD Graphics 3000'),
(1, 27, 'Intel', 'Core i7-2600', 2, 'LGA 1155', 'Desktop', '3.40', '3.80', 4, NULL, 8, 'DDR3', 'Intel HD Graphics 2000'),
(1, 28, 'AMD', 'Phenom(tm) II X4', 2, 'AM3', 'Desktop', '3.03', '3.03', 4, NULL, 4, 'DDR3', NULL),
(1, 29, 'Intel', 'Core 2 Duo E4500', 2, 'LGA775', 'Desktop', '2.02', '2.02', 2, NULL, 2, 'DDR2, DDR3', NULL),
(1, 30, 'Intel', 'Core i3-7100', 7, 'LGA 1151', 'Desktop', '3.90', '3.90', 2, NULL, 4, 'DDR3, DDR4', 'Intel® HD Graphics 630'),
(1, 31, 'Intel', 'Core i5-560M', 1, 'PGA988', 'Notebook', '2.67', '3.20', 2, NULL, 4, 'DDR3', 'Intel HD Graphics'),
(1, 33, 'Intel', 'Core i3-3220', 3, 'LGA 1155', 'Desktop', '3.30', '3.30', 2, NULL, 4, 'DDR3', 'Intel HD Graphics 2500'),
(1, 34, 'Intel', 'Core i3-550', 1, '1156', 'Desktop', '3.20', '3.20', 2, NULL, 4, 'DDR3', 'Intel HD Graphics'),
(1, 35, 'Intel', 'Core 2 Duo E4400', 4, 'LGA775', 'Desktop', '2', '2', 2, NULL, 2, 'DDR2, DDR3', NULL),
(1, 36, 'Intel', 'i5-13420H', 13, 'BGA-1744', 'Notebook', '4.60', '4.60', 8, 8, 4, 'DDR4', 'UHD Graphics for 13th Gen Intel® Processors'),
(1, 37, 'Intel', 'Core i5-13500T', 13, 'LGA 1700', 'Desktop', '4.60', '4.60', 14, NULL, 20, 'DDR4, DDR5', 'Intel UHD Graphics 770'),
(1, 38, 'AMD', 'Ryzen 5 Pro 5655GE', 5, 'AM4', 'Desktop', '3.40', '4.40', 6, NULL, 12, 'DDR4', 'Radeon Vega 7');

-- --------------------------------------------------------

--
-- Estrutura para tabela `lista_so`
--

CREATE TABLE `lista_so` (
  `ativo` tinyint NOT NULL,
  `id` int NOT NULL,
  `dev` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nome` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `distribuicao` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `versao` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `edicao` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `arquitetura` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `lista_so`
--

INSERT INTO `lista_so` (`ativo`, `id`, `dev`, `nome`, `distribuicao`, `versao`, `edicao`, `arquitetura`) VALUES
(1, 4, 'Linux Mint Team', 'Linux', 'Mint', '22.1', 'Cinnamon', 'x64'),
(1, 7, 'Microsoft', 'Windows', NULL, '10', 'Pro', 'x64'),
(1, 10, 'Microsoft', 'Windows', NULL, '11', 'Pro', 'x64'),
(1, 11, 'Microsoft', 'Windows', NULL, '10', 'Home', 'x64'),
(1, 12, 'Microsoft', 'Windows', NULL, '11', 'Home', 'x64'),
(1, 22, 'Linux Mint Team', 'Linux', 'Mint', '22.2', 'Cinnamon', 'x64'),
(1, 24, 'Linux Mint Team', 'Linux', 'Mint', '22.2', 'Mate', 'x64'),
(1, 25, 'Canonical Ltd', 'Linux', 'Ubuntu', '25.04', 'Gnome 48', 'x64'),
(1, 26, 'antiX e MEPIS', 'Linux', 'MX', '25 Infinity', 'XFCE', 'x64');

-- --------------------------------------------------------

--
-- Estrutura para tabela `lista_ssd`
--

CREATE TABLE `lista_ssd` (
  `ativo` tinyint(1) NOT NULL,
  `id` int NOT NULL,
  `tamanho` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `lista_ssd`
--

INSERT INTO `lista_ssd` (`ativo`, `id`, `tamanho`) VALUES
(1, 1, '256 GB'),
(1, 2, '500 GB'),
(1, 3, '240 GB'),
(1, 4, '120 GB'),
(1, 5, '960 GB'),
(1, 6, '480 GB'),
(1, 7, '1,0 TB'),
(1, 8, '512 GB');

-- --------------------------------------------------------

--
-- Estrutura para tabela `militares`
--

CREATE TABLE `militares` (
  `id` int NOT NULL,
  `nome_completo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nome_guerra` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_pg` int DEFAULT NULL,
  `id_secao` int DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pg`
--

CREATE TABLE `pg` (
  `id` int NOT NULL,
  `pg` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `abreviatura` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pg`
--

INSERT INTO `pg` (`id`, `pg`, `abreviatura`) VALUES
(1, 'Soldado EV', 'Sd EV'),
(2, 'Soldado EP', 'Sd EP'),
(3, 'Cabo', 'Cb'),
(4, '3º Sargento', '3º Sgt'),
(5, '2º Sargento', '2º Sgt'),
(6, '1º Sargento', '1º Sgt'),
(7, 'Subtenente', 'ST'),
(8, 'Aspirante a Oficial', 'Asp'),
(9, '2º Tenente', '2º Ten'),
(10, '1º Tenente', '1º Ten'),
(11, 'Capitão', 'Cap'),
(12, 'Major', 'Maj'),
(13, 'Tenente Coronel', 'TC'),
(14, 'Coronel', 'Cel'),
(15, 'General de Brigada', 'Gen Bda'),
(16, 'General de Divisão', 'Gen Div'),
(17, 'General de Exército', 'Gen Ex');

-- --------------------------------------------------------

--
-- Estrutura para tabela `secao`
--

CREATE TABLE `secao` (
  `ativo` tinyint(1) NOT NULL,
  `id` int NOT NULL,
  `nome` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sigla` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fullname` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cpf` char(11) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `grupo` tinyint(1) NOT NULL,
  `avatar` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `cpf`, `password`, `email`, `grupo`, `avatar`, `ativo`) VALUES
(1, 'admin', 'Administrador', '12345678900', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'email@email.com', 1, 'avatar.admin.png', 1),


--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `assoc_hd`
--
ALTER TABLE `assoc_hd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pc` (`id_pc`),
  ADD KEY `id_processador` (`id_hd`);

--
-- Índices de tabela `assoc_monitor`
--
ALTER TABLE `assoc_monitor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pc` (`id_pc`),
  ADD KEY `id_processador` (`id_monitor`);

--
-- Índices de tabela `assoc_office`
--
ALTER TABLE `assoc_office`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pc` (`id_pc`),
  ADD KEY `id_office` (`id_office`);

--
-- Índices de tabela `assoc_placa_video`
--
ALTER TABLE `assoc_placa_video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pc` (`id_pc`),
  ADD KEY `id_processador` (`id_placa_video`);

--
-- Índices de tabela `assoc_processador`
--
ALTER TABLE `assoc_processador`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pc` (`id_pc`),
  ADD KEY `id_processador` (`id_processador`);

--
-- Índices de tabela `assoc_so`
--
ALTER TABLE `assoc_so`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pc` (`id_pc`),
  ADD KEY `id_processador` (`id_so`);

--
-- Índices de tabela `assoc_ssd`
--
ALTER TABLE `assoc_ssd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pc` (`id_pc`),
  ADD KEY `id_processador` (`id_ssd`);

--
-- Índices de tabela `computadores`
--
ALTER TABLE `computadores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_operador` (`id_operador`),
  ADD KEY `usuario` (`id_atualizacao`),
  ADD KEY `id_inclusao` (`id_inclusao`);

--
-- Índices de tabela `lista_hd`
--
ALTER TABLE `lista_hd`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `lista_monitor`
--
ALTER TABLE `lista_monitor`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `lista_office`
--
ALTER TABLE `lista_office`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `lista_placa_video`
--
ALTER TABLE `lista_placa_video`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `lista_processador`
--
ALTER TABLE `lista_processador`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `lista_so`
--
ALTER TABLE `lista_so`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `lista_ssd`
--
ALTER TABLE `lista_ssd`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `militares`
--
ALTER TABLE `militares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pg` (`id_pg`),
  ADD KEY `id_secao` (`id_secao`);

--
-- Índices de tabela `pg`
--
ALTER TABLE `pg`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `secao`
--
ALTER TABLE `secao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `assoc_hd`
--
ALTER TABLE `assoc_hd`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `assoc_monitor`
--
ALTER TABLE `assoc_monitor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `assoc_office`
--
ALTER TABLE `assoc_office`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `assoc_placa_video`
--
ALTER TABLE `assoc_placa_video`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `assoc_processador`
--
ALTER TABLE `assoc_processador`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `assoc_so`
--
ALTER TABLE `assoc_so`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `assoc_ssd`
--
ALTER TABLE `assoc_ssd`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `computadores`
--
ALTER TABLE `computadores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `lista_hd`
--
ALTER TABLE `lista_hd`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `lista_monitor`
--
ALTER TABLE `lista_monitor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `lista_office`
--
ALTER TABLE `lista_office`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `lista_placa_video`
--
ALTER TABLE `lista_placa_video`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `lista_processador`
--
ALTER TABLE `lista_processador`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `lista_so`
--
ALTER TABLE `lista_so`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `lista_ssd`
--
ALTER TABLE `lista_ssd`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `militares`
--
ALTER TABLE `militares`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pg`
--
ALTER TABLE `pg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `secao`
--
ALTER TABLE `secao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `assoc_hd`
--
ALTER TABLE `assoc_hd`
  ADD CONSTRAINT `assoc_hd_ibfk_1` FOREIGN KEY (`id_hd`) REFERENCES `lista_hd` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `assoc_hd_ibfk_2` FOREIGN KEY (`id_pc`) REFERENCES `computadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `assoc_monitor`
--
ALTER TABLE `assoc_monitor`
  ADD CONSTRAINT `assoc_monitor_ibfk_1` FOREIGN KEY (`id_monitor`) REFERENCES `lista_monitor` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `assoc_monitor_ibfk_2` FOREIGN KEY (`id_pc`) REFERENCES `computadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `assoc_office`
--
ALTER TABLE `assoc_office`
  ADD CONSTRAINT `assoc_office_ibfk_1` FOREIGN KEY (`id_office`) REFERENCES `lista_office` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `assoc_office_ibfk_2` FOREIGN KEY (`id_pc`) REFERENCES `computadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `assoc_placa_video`
--
ALTER TABLE `assoc_placa_video`
  ADD CONSTRAINT `assoc_placa_video_ibfk_1` FOREIGN KEY (`id_placa_video`) REFERENCES `lista_placa_video` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `assoc_placa_video_ibfk_2` FOREIGN KEY (`id_pc`) REFERENCES `computadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `assoc_processador`
--
ALTER TABLE `assoc_processador`
  ADD CONSTRAINT `assoc_processador_ibfk_1` FOREIGN KEY (`id_processador`) REFERENCES `lista_processador` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `assoc_processador_ibfk_2` FOREIGN KEY (`id_pc`) REFERENCES `computadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `assoc_so`
--
ALTER TABLE `assoc_so`
  ADD CONSTRAINT `assoc_so_ibfk_1` FOREIGN KEY (`id_so`) REFERENCES `lista_so` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `assoc_so_ibfk_2` FOREIGN KEY (`id_pc`) REFERENCES `computadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `assoc_ssd`
--
ALTER TABLE `assoc_ssd`
  ADD CONSTRAINT `assoc_ssd_ibfk_1` FOREIGN KEY (`id_ssd`) REFERENCES `lista_ssd` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `assoc_ssd_ibfk_2` FOREIGN KEY (`id_pc`) REFERENCES `computadores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `computadores`
--
ALTER TABLE `computadores`
  ADD CONSTRAINT `computadores_ibfk_1` FOREIGN KEY (`id_operador`) REFERENCES `secao` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `computadores_ibfk_2` FOREIGN KEY (`id_atualizacao`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `computadores_ibfk_3` FOREIGN KEY (`id_inclusao`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `militares`
--
ALTER TABLE `militares`
  ADD CONSTRAINT `militares_ibfk_1` FOREIGN KEY (`id_pg`) REFERENCES `pg` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `militares_ibfk_2` FOREIGN KEY (`id_secao`) REFERENCES `secao` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
