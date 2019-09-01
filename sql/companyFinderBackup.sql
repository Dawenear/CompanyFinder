-- Adminer 4.7.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `web` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `web`;

DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ico` int(11) NOT NULL,
  `dic` varchar(128) NOT NULL,
  `name` varchar(256) NOT NULL,
  `city` varchar(256) NOT NULL,
  `street` varchar(256) NOT NULL,
  `psc` int(11) NOT NULL,
  `last_updated` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ico` (`ico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2019-09-01 15:11:00
