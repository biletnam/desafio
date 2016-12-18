-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `desafio`;
CREATE DATABASE `desafio` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `desafio`;

CREATE USER 'desafio_user'@'localhost' IDENTIFIED BY PASSWORD '*08EAF53ECC31AF7399853D91AC9A00E2E2587B36';
GRANT ALL PRIVILEGES ON `desafio`.* TO 'desafio_user'@'localhost' WITH GRANT OPTION;

DROP TABLE IF EXISTS `reservas`;
CREATE TABLE `reservas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salas_id` int(11) unsigned NOT NULL,
  `usuarios_id` int(11) unsigned NOT NULL,
  `hora` varchar(5) NOT NULL DEFAULT '08:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `salas_id` (`salas_id`),
  KEY `usuarios_id` (`usuarios_id`),
  CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`salas_id`) REFERENCES `salas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

INSERT INTO `reservas` (`id`, `salas_id`, `usuarios_id`, `hora`) VALUES
(10,	2,	9,	'12:00'),
(24,	2,	9,	'10:00'),
(27,	4,	11,	'16:00'),
(28,	3,	11,	'09:00'),
(30,	5,	11,	'10:00'),
(31,	5,	11,	'15:00'),
(32,	2,	9,	'15:00'),
(33,	2,	9,	'09:00'),
(34,	3,	9,	'08:00'),
(35,	4,	11,	'08:00'),
(36,	5,	11,	'11:00'),
(37,	3,	11,	'18:00'),
(38,	3,	11,	'19:00');

DROP TABLE IF EXISTS `salas`;
CREATE TABLE `salas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL DEFAULT '''''',
  `capacidade` tinyint(2) NOT NULL DEFAULT '0',
  `datashow` tinyint(1) NOT NULL DEFAULT '0',
  `observacoes` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `salas` (`id`, `nome`, `capacidade`, `datashow`, `observacoes`) VALUES
(2,	'Sala Business',	10,	1,	'Sala para reuniões e demonstrações. Máquina de café, assentos confortáveis e quadro branco.'),
(3,	'Sala Small',	5,	0,	'Sala para reunões relâmpago.	 Editar'),
(4,	'Sala de Conferência',	20,	1,	'Datashow, mesa grande, impressoras.'),
(5,	'Sala Business2',	10,	0,	'');

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `passwd` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

INSERT INTO `usuarios` (`id`, `username`, `passwd`) VALUES
(9,	'joao',	'356a192b7913b04c54574d18c28d46e6395428ab'),
(10,	'pedro',	'356a192b7913b04c54574d18c28d46e6395428ab'),
(11,	'bruno',	'356a192b7913b04c54574d18c28d46e6395428ab'),
(12,	'amauri',	'356a192b7913b04c54574d18c28d46e6395428ab');

-- 2016-12-18 13:27:08
