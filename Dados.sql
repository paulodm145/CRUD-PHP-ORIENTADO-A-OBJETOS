-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Fev-2021 às 18:53
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `testeentrevista`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(250) NOT NULL,
  `cpfcnpj` varchar(15) NOT NULL,
  `data_nascimento` date NOT NULL,
  `email` varchar(250) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `endereco` varchar(250) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `cidade` varchar(250) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `cpfcnpj`, `data_nascimento`, `email`, `telefone`, `endereco`, `numero`, `bairro`, `cep`, `cidade`, `estado`, `created`, `updated`, `deleted`) VALUES
(25, 'JOSEnildo', '10163364702', '1983-10-14', 'paulo.bolsanello@gmail.com', '27998159917', 'RUA X', '23', 'NS APARECIDA', '123456', '125', 'ES', '2021-02-11 17:38:07', '2021-02-12 10:09:32', '2021-02-12 10:31:23'),
(27, 'PAULO ROBERTO BOLSANELLO', '10163364702', '1983-10-14', 'paulo.bolsanello@gmail.com', '27999868414', 'Rua Jacinto Basseti', '988', 'Nossa Senhora Aparecida', '29703576', 'Colatina', 'ES', '2021-02-12 07:37:15', '2021-02-12 10:34:18', NULL),
(28, 'Fábio dos Santos Souza', '78103030074222', '1983-10-14', 'fabioamerica2@gmail.com', '27998159917', 'Rua Borges de Figueiredo', '988', 'Mooca', '03110010', 'São Paulo', 'SP', '2021-02-12 07:43:53', NULL, '2021-02-12 10:32:46'),
(29, 'PAULO ROBERTO BOLSANELLO', '10163364702', '1983-10-14', 'paulo.bolsanello@gmail.com', '55279981599', 'Rua Jacinto Basseti', '988', 'Nossa Senhora Aparecida', '29703576', 'Colatina', 'ES', '2021-02-12 07:44:57', NULL, '2021-02-12 10:33:06'),
(30, '3Hortisuco Industria e Comercio LTDA', '11111111111111', '1983-10-14', 'paulo.bolsanello@gmail.com', '27998159917', 'Rua Jacinto Basseti', '1466', 'Nossa Senhora Aparecida', '29703576', 'Colatina', 'ES', '2021-02-12 07:45:28', '2021-02-12 09:55:21', '2021-02-12 10:31:57'),
(31, 'PAULO ROBERTO BOLSANELLO22', '10163364702', '1983-10-14', 'paulo.bolsanello@gmail.com', '55279981599', 'Rua Jacinto Basseti', '988', 'Nossa Senhora Aparecida', '29703576', 'Colatina', 'ES', '2021-02-12 08:09:05', NULL, '2021-02-12 10:33:01'),
(32, 'PAULO ROBERTO BOLSANELLO', '10163364702', '0000-00-00', 'paulo.bolsanello@gmail.com', '55279981599', 'Rua Jacinto Basseti', '988', 'Nossa Senhora Aparecida', '29703576', 'Colatina', 'ES', '2021-02-12 08:25:30', NULL, '2021-02-12 10:32:57'),
(33, 'Paulinho123456', '10163364702', '1983-10-14', 'paulo.bolsanello@gmail.com', '27998159917', 'Rua Jacinto Basseti', '988', 'Nossa Senhora Aparecida', '29703576', 'Colatina', 'ES', '2021-02-12 09:25:46', '2021-02-12 10:31:12', '2021-02-12 10:32:26'),
(34, 'Heitor Faller Bolsanello', '10163364702', '2015-08-08', 'ceodcolatina2@gmail.com', '27998159917', 'Rua Jacinto Basseti', '988', 'Nossa Senhora Aparecida', '29703576', 'Colatina', 'ES', '2021-02-12 10:33:37', '2021-02-12 10:33:51', NULL),
(35, 'Cecília Bolsanello Parpaiola', '12345678912', '1983-10-14', 'ceodcolatina@gmail.com', '27998159917', 'Rua Jacinto Basseti', '988', 'Nossa Senhora Aparecida', '29703576', 'Colatina', 'ES', '2021-02-12 10:35:46', '2021-02-12 10:36:02', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `dividas`
--

CREATE TABLE `dividas` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `valor` float(10,2) NOT NULL,
  `vencimento` date NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `dividas`
--

INSERT INTO `dividas` (`id`, `id_cliente`, `descricao`, `valor`, `vencimento`, `created`, `updated`, `deleted`) VALUES
(2, 27, 'Unus quisque mavult credere, quam judicare2', 1234.56, '2021-02-12', '2021-02-12 14:28:07', '2021-02-12 14:41:31', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `dividas`
--
ALTER TABLE `dividas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `dividas`
--
ALTER TABLE `dividas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
