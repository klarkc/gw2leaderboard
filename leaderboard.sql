-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 04/03/2015 às 12:21
-- Versão do servidor: 5.5.37-MariaDB
-- Versão do PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `gw2br_leaderboard`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `pvp`
--

CREATE TABLE IF NOT EXISTS `pvp` (
`id` int(1) NOT NULL,
  `rank` int(1) NOT NULL,
  `rank_status` varchar(6) DEFAULT NULL,
  `rank_since` varchar(40) DEFAULT NULL,
  `points` int(1) NOT NULL,
  `points_status` varchar(6) DEFAULT NULL,
  `points_since` varchar(40) DEFAULT NULL,
  `name` varchar(40) NOT NULL,
  `character` varchar(25) DEFAULT NULL,
  `wins` int(1) DEFAULT NULL,
  `wins_status` varchar(6) DEFAULT NULL,
  `wins_since` varchar(40) DEFAULT NULL,
  `losses` int(1) DEFAULT NULL,
  `losses_status` varchar(6) DEFAULT NULL,
  `losses_since` varchar(40) DEFAULT NULL,
  `winpct` varchar(6) DEFAULT NULL,
  `guild` varchar(40) DEFAULT NULL,
  `team` varchar(40) DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `last_page` int(1) DEFAULT NULL,
  `rank_br` int(1) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=408 ;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `pvp`
--
ALTER TABLE `pvp`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `pvp`
--
ALTER TABLE `pvp`
MODIFY `id` int(1) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;