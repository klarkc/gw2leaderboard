-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 26-Nov-2013 às 14:25
-- Versão do servidor: 5.5.33-31.1
-- versão do PHP: 5.3.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `gw2br_leaderboard`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `soloarena`
--

CREATE TABLE IF NOT EXISTS `soloarena` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `rank` int(1) NOT NULL,
  `rank_status` varchar(6) DEFAULT NULL,
  `rank_since` varchar(40) DEFAULT NULL,
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
  `world` varchar(40) DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `last_page` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=150 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `teamarena`
--

CREATE TABLE IF NOT EXISTS `teamarena` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `rank` int(1) NOT NULL,
  `rank_status` varchar(6) DEFAULT NULL,
  `rank_since` varchar(40) DEFAULT NULL,
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
  `world` varchar(40) DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `last_page` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=197 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
