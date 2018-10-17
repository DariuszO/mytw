-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 18 Sty 2015, 13:15
-- Wersja serwera: 5.5.27
-- Wersja PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `mytw_index`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `admin_accounts`
--

CREATE TABLE IF NOT EXISTS `admin_accounts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `login_history` varchar(20000) NOT NULL DEFAULT '[]',
  `permissions` varchar(20000) NOT NULL DEFAULT '[]',
  `console_log` varchar(20000) NOT NULL DEFAULT '[]',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `admin_logs`
--

CREATE TABLE IF NOT EXISTS `admin_logs` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `log` varchar(5000) NOT NULL,
  `acc_id` int(100) NOT NULL,
  `type` varchar(200) NOT NULL,
  `time` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `admin_tokens`
--

CREATE TABLE IF NOT EXISTS `admin_tokens` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `token` varchar(200) NOT NULL,
  `account` int(100) NOT NULL,
  `last` int(100) NOT NULL DEFAULT '0',
  `time_limit` int(100) NOT NULL DEFAULT '900',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `announcements`
--

CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `time` int(100) NOT NULL,
  `lock` enum('N','Y') NOT NULL DEFAULT 'N',
  `admin_id` int(100) NOT NULL,
  `url` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `map_elements`
--

CREATE TABLE IF NOT EXISTS `map_elements` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `x` int(100) NOT NULL,
  `y` int(100) NOT NULL,
  `type` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rules`
--

CREATE TABLE IF NOT EXISTS `rules` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `type` enum('0','1') NOT NULL DEFAULT '1',
  `c` int(100) NOT NULL,
  `text` text NOT NULL,
  `sub` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `session` varchar(100) NOT NULL,
  `key` varchar(20) NOT NULL,
  `worlds` varchar(100) NOT NULL DEFAULT '[]',
  `premium_points` int(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `worlds`
--

CREATE TABLE IF NOT EXISTS `worlds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sp_id` varchar(10) NOT NULL DEFAULT 'serverX',
  `name` varchar(20) NOT NULL DEFAULT 'World X',
  `status` enum('on','off') NOT NULL DEFAULT 'on',
  `speed` int(10) NOT NULL DEFAULT '1',
  `start` int(100) NOT NULL,
  `villages_circle` int(100) NOT NULL DEFAULT '0',
  `circle` int(100) NOT NULL DEFAULT '0',
  `all_villages` int(100) NOT NULL DEFAULT '0',
  `start_points` int(100) NOT NULL DEFAULT '0',
  `start_villages` int(100) NOT NULL DEFAULT '1',
  `bonus_villages` enum('1','0') NOT NULL DEFAULT '0',
  `storage` varchar(5000) NOT NULL DEFAULT '{"1":"1000","2":"1229","3":"1512","4":"1859","5":"2285","6":"2810","7":"3454","8":"4247","9":"5222","10":"6420","11":"7893","12":"9705","13":"11932","14":"14670","15":"18037","16":"22177","17":"27266","18":"33523","19":"41217","20":"50675","21":"62305","22":"76604","23":"94184","24":"115798","25":"142373","26":"175047","27":"215219","28":"264611","29":"325337","30":"400000"}',
  `farm` varchar(5000) NOT NULL DEFAULT '{"1":"240","2":"281","3":"329","4":"386","5":"452","6":"530","7":"622","8":"729","9":"854","10":"1002","11":"1174","12":"1376","13":"1613","14":"1891","15":"2216","16":"2598","17":"3045","18":"3569","19":"4183","20":"4904","21":"5748","22":"6737","23":"7896","24":"9255","25":"10848","26":"12715","27":"14904","28":"17469","29":"20476","30":"24000"}',
  `player_protect` int(100) NOT NULL DEFAULT '1440',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
