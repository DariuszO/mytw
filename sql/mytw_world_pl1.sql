-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 18 Sty 2015, 13:19
-- Wersja serwera: 5.5.27
-- Wersja PHP: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `mytw_world_pl1`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ally`
--

CREATE TABLE IF NOT EXISTS `ally` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `short` varchar(50) NOT NULL,
  `desc` text NOT NULL,
  `desc_bb` text NOT NULL,
  `rank` int(100) NOT NULL,
  `points` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `uid` int(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logins`
--

CREATE TABLE IF NOT EXISTS `logins` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `uid` int(100) NOT NULL,
  `time` int(100) NOT NULL,
  `ip` varchar(500) NOT NULL,
  `vacation` enum('0','1') NOT NULL DEFAULT '0',
  `sid` varchar(100) NOT NULL,
  `hkey` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stats`
--

CREATE TABLE IF NOT EXISTS `stats` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `own_id` int(200) NOT NULL,
  `type` enum('1','2','3') NOT NULL DEFAULT '1',
  `time` int(100) NOT NULL DEFAULT '0',
  `value` int(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `unit_place`
--

CREATE TABLE IF NOT EXISTS `unit_place` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `from` int(100) NOT NULL,
  `to` int(100) NOT NULL,
  `unit_spear` varchar(100) NOT NULL DEFAULT '0',
  `unit_sword` varchar(100) NOT NULL DEFAULT '0',
  `unit_axe` varchar(100) NOT NULL DEFAULT '0',
  `unit_archer` varchar(100) NOT NULL DEFAULT '0',
  `unit_spy` varchar(100) NOT NULL DEFAULT '0',
  `unit_light` varchar(100) NOT NULL DEFAULT '0',
  `unit_cav_archer` varchar(100) NOT NULL DEFAULT '0',
  `unit_heavy` varchar(100) NOT NULL DEFAULT '0',
  `unit_ram` varchar(100) NOT NULL DEFAULT '0',
  `unit_catapult` varchar(100) NOT NULL DEFAULT '0',
  `unit_paladin` varchar(100) NOT NULL DEFAULT '0',
  `unit_snob` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `permissions` varchar(200) NOT NULL DEFAULT '{"user_packet":"Y"}',
  `rank` int(100) NOT NULL DEFAULT '0',
  `points` int(100) NOT NULL DEFAULT '0',
  `villages` int(100) NOT NULL DEFAULT '0',
  `game_start` int(100) NOT NULL DEFAULT '0',
  `ally` int(100) NOT NULL DEFAULT '-1',
  `chat_width` int(100) NOT NULL DEFAULT '500',
  `chat_height` varchar(100) NOT NULL DEFAULT '300',
  `chat_active` enum('0','1') NOT NULL DEFAULT '0',
  `personal_text` text NOT NULL,
  `personal_text_bb` text NOT NULL,
  `b_year` year(4) NOT NULL,
  `b_month` int(100) NOT NULL DEFAULT '0',
  `b_day` int(100) NOT NULL DEFAULT '0',
  `sex` enum('f','m','x') NOT NULL DEFAULT 'x',
  `overview_leftcolumn` varchar(10000) NOT NULL DEFAULT '["show_summary","show_event","show_incoming_units","show_outgoing_units"]',
  `overview_rightcolumn` varchar(10000) NOT NULL DEFAULT '["show_newbie","show_prod","show_buildqueue","show_units","show_mood","show_effects","show_groups","show_notes","show_secret"]',
  `overview_show_summary` enum('1','0') NOT NULL DEFAULT '0',
  `overview_show_event` enum('1','0') NOT NULL DEFAULT '0',
  `overview_show_incoming_units` enum('1','0') NOT NULL DEFAULT '0',
  `overview_show_outgoing_units` enum('1','0') NOT NULL DEFAULT '0',
  `overview_show_newbie` enum('1','0') NOT NULL DEFAULT '0',
  `overview_show_prod` enum('1','0') NOT NULL DEFAULT '0',
  `overview_show_units` enum('1','0') NOT NULL DEFAULT '0',
  `overview_show_mood` enum('1','0') NOT NULL DEFAULT '0',
  `overview_show_groups` enum('1','0') NOT NULL DEFAULT '0',
  `overview_show_notes` enum('1','0') NOT NULL DEFAULT '0',
  `overview_show_secret` enum('1','0') NOT NULL DEFAULT '0',
  `avatar` int(200) NOT NULL DEFAULT '0',
  `home` varchar(200) NOT NULL,
  `am_farm_a` varchar(5000) NOT NULL DEFAULT '[]',
  `map_size_x` int(100) NOT NULL DEFAULT '9',
  `map_size_y` int(100) NOT NULL DEFAULT '9',
  `map_mini_size_x` int(100) NOT NULL DEFAULT '50',
  `map_mini_size_y` int(100) NOT NULL DEFAULT '50',
  `map_popup_show` enum('1','0') NOT NULL DEFAULT '1',
  `map_popup_attack` enum('1','0') NOT NULL DEFAULT '1',
  `map_popup_attack_intel` enum('1','0') NOT NULL DEFAULT '1',
  `map_popup_moral` enum('1','0') NOT NULL DEFAULT '1',
  `map_popup_res` enum('1','0') NOT NULL DEFAULT '1',
  `map_popup_pop` enum('1','0') NOT NULL DEFAULT '1',
  `map_popup_trader` enum('1','0') NOT NULL DEFAULT '1',
  `map_popup_reservation` enum('1','0') NOT NULL DEFAULT '1',
  `map_popup_units` enum('1','0') NOT NULL DEFAULT '1',
  `map_popup_units_home` enum('1','0') NOT NULL DEFAULT '1',
  `map_popup_units_time` enum('1','0') NOT NULL DEFAULT '1',
  `map_popup_flag` enum('1','0') NOT NULL DEFAULT '1',
  `map_popup_notes` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `villages`
--

CREATE TABLE IF NOT EXISTS `villages` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `uid` int(100) NOT NULL DEFAULT '-1',
  `name` varchar(200) NOT NULL DEFAULT 'left village',
  `points` int(100) NOT NULL DEFAULT '0',
  `is_first` enum('1','0') NOT NULL,
  `x` int(4) NOT NULL DEFAULT '0',
  `y` int(4) NOT NULL DEFAULT '0',
  `continent` int(4) NOT NULL DEFAULT '0',
  `create_time` int(100) NOT NULL,
  `reload_time` int(100) NOT NULL,
  `wood_float` int(100) NOT NULL DEFAULT '1000',
  `stone_float` int(100) NOT NULL DEFAULT '1000',
  `iron_float` int(100) NOT NULL DEFAULT '1000',
  `bonus` int(10) NOT NULL DEFAULT '0',
  `pop` int(100) NOT NULL DEFAULT '0',
  `main` int(11) NOT NULL DEFAULT '1',
  `barracks` int(11) NOT NULL DEFAULT '0',
  `stable` int(11) NOT NULL DEFAULT '0',
  `garage` int(11) NOT NULL DEFAULT '0',
  `church` int(11) NOT NULL DEFAULT '0',
  `snob` int(11) NOT NULL DEFAULT '0',
  `smith` int(11) NOT NULL DEFAULT '0',
  `place` int(11) NOT NULL DEFAULT '1',
  `statue` int(11) NOT NULL DEFAULT '0',
  `market` int(11) NOT NULL DEFAULT '0',
  `wood` int(11) NOT NULL DEFAULT '0',
  `stone` int(11) NOT NULL DEFAULT '0',
  `iron` int(11) NOT NULL DEFAULT '0',
  `farm` int(11) NOT NULL DEFAULT '1',
  `storage` int(11) NOT NULL DEFAULT '1',
  `hide` int(11) NOT NULL DEFAULT '0',
  `wall` int(11) NOT NULL DEFAULT '0',
  `groups` varchar(5000) NOT NULL DEFAULT '[]',
  `all_unit_spear` varchar(100) NOT NULL DEFAULT '0',
  `all_unit_sword` varchar(100) NOT NULL DEFAULT '0',
  `all_unit_axe` varchar(100) NOT NULL DEFAULT '0',
  `all_unit_archer` varchar(100) NOT NULL DEFAULT '0',
  `all_unit_spy` varchar(100) NOT NULL DEFAULT '0',
  `all_unit_light` varchar(100) NOT NULL DEFAULT '0',
  `all_unit_cav_archer` varchar(100) NOT NULL DEFAULT '0',
  `all_unit_heavy` varchar(100) NOT NULL DEFAULT '0',
  `all_unit_ram` varchar(100) NOT NULL DEFAULT '0',
  `all_unit_catapult` varchar(100) NOT NULL DEFAULT '0',
  `all_unit_paladin` varchar(100) NOT NULL DEFAULT '0',
  `all_unit_snob` varchar(100) NOT NULL DEFAULT '0',
  `tech_unit_spear` enum('1','0') NOT NULL DEFAULT '0',
  `tech_unit_sword` enum('1','0') NOT NULL DEFAULT '0',
  `tech_unit_axe` enum('1','0') NOT NULL DEFAULT '0',
  `tech_unit_archer` enum('1','0') NOT NULL DEFAULT '0',
  `tech_unit_spy` enum('1','0') NOT NULL DEFAULT '0',
  `tech_unit_light` enum('1','0') NOT NULL DEFAULT '0',
  `tech_unit_cav_archer` enum('1','0') NOT NULL DEFAULT '0',
  `tech_unit_heavy` enum('1','0') NOT NULL DEFAULT '0',
  `tech_unit_ram` enum('1','0') NOT NULL DEFAULT '0',
  `tech_unit_catapult` enum('1','0') NOT NULL DEFAULT '0',
  `tech_unit_paladin` enum('1','0') NOT NULL DEFAULT '0',
  `tech_unit_snob` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
