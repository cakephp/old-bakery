-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Vert: localhost
-- Generert den: 14. Okt, 2008 klokka 11:05 AM
-- Tjenerversjon: 5.0.51
-- PHP-Versjon: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `swf`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `dum_dummy_fields`
--

CREATE TABLE IF NOT EXISTS `dum_dummy_fields` (
  `id` int(11) NOT NULL auto_increment,
  `tablename` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `field_type` varchar(255) NOT NULL,
  `allow_null` varchar(255) NOT NULL,
  `default` varchar(255) default NULL,
  `active` tinyint(1) NOT NULL default '1',
  `type` varchar(100) default NULL,
  `custom_min` varchar(100) default NULL,
  `custom_max` varchar(100) default NULL,
  `custom_variable` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `dum_dummy_tables`
--

CREATE TABLE IF NOT EXISTS `dum_dummy_tables` (
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL default '1',
  `number` smallint(6) NOT NULL default '10',
  `created` datetime NOT NULL,
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
