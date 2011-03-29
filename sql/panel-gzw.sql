-- phpMyAdmin SQL Dump
-- version 3.3.8
-- http://www.phpmyadmin.net
--
-- Serveur: stan.gzw.local
-- Généré le : Mer 16 Mars 2011 à 22:16
-- Version du serveur: 5.1.49
-- Version de PHP: 5.3.3-7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `panel-gzw`
--
CREATE DATABASE `panel-gzw` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `panel-gzw`;

-- --------------------------------------------------------

--
-- Structure de la table `aliases`
--

CREATE TABLE IF NOT EXISTS `aliases` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `domain_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------

--
-- Structure de la table `bills`
--

CREATE TABLE IF NOT EXISTS `bills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `price` varchar(20) NOT NULL,
  `taxe` varchar(7) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Contenu de la table `bills`
--

-- --------------------------------------------------------

--
-- Structure de la table `crons`
--

CREATE TABLE IF NOT EXISTS `crons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `type` varchar(255) NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Contenu de la table `crons`
--


-- --------------------------------------------------------

--
-- Structure de la table `domains`
--

CREATE TABLE IF NOT EXISTS `domains` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `registrar` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Contenu de la table `domains`
--

-- --------------------------------------------------------

--
-- Structure de la table `ftpgroups`
--

CREATE TABLE IF NOT EXISTS `ftpgroups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `gid` bigint(6) DEFAULT NULL,
  `member` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupname` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;


-- --------------------------------------------------------

--
-- Structure de la table `ftplimits`
--

CREATE TABLE IF NOT EXISTS `ftplimits` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `quota_type` varchar(7) NOT NULL DEFAULT 'group',
  `per_session` varchar(7) NOT NULL DEFAULT 'false',
  `limit_type` varchar(7) NOT NULL DEFAULT 'hard',
  `bytes_in_avail` int(11) unsigned NOT NULL DEFAULT '0',
  `bytes_out_avail` int(11) unsigned NOT NULL DEFAULT '0',
  `bytes_xfer_avail` int(11) unsigned NOT NULL DEFAULT '0',
  `files_in_avail` int(10) unsigned NOT NULL DEFAULT '0',
  `files_out_avail` int(10) unsigned NOT NULL DEFAULT '0',
  `files_xfer_avail` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Contenu de la table `ftplimits`
--


-- --------------------------------------------------------

--
-- Structure de la table `ftptotals`
--

CREATE TABLE IF NOT EXISTS `ftptotals` (
  `name` varchar(255) NOT NULL,
  `quota_type` enum('user','group','class','all') NOT NULL DEFAULT 'user',
  `bytes_in_used` float unsigned NOT NULL DEFAULT '0',
  `bytes_out_used` float unsigned NOT NULL DEFAULT '0',
  `bytes_xfer_used` float unsigned NOT NULL DEFAULT '0',
  `files_in_used` int(10) unsigned NOT NULL DEFAULT '0',
  `files_out_used` int(10) unsigned NOT NULL DEFAULT '0',
  `files_xfer_used` int(10) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `ftptotals`
--


-- --------------------------------------------------------

--
-- Structure de la table `ftpusers`
--

CREATE TABLE IF NOT EXISTS `ftpusers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `uid` bigint(6) DEFAULT '5500',
  `gid` bigint(6) DEFAULT '5500',
  `homedir` varchar(255) NOT NULL,
  `shell` varchar(16) NOT NULL DEFAULT '/bin/bash',
  `count` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `accessed` datetime DEFAULT '0000-00-00 00:00:00',
  `modified` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userid` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `action` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` varchar(255) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Contenu de la table `logs`
--

-- --------------------------------------------------------

--
-- Structure de la table `mailboxes`
--

CREATE TABLE IF NOT EXISTS `mailboxes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `domain_id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `maildir` varchar(255) NOT NULL,
  `quota` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Contenu de la table `mailboxes`
--

-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `version` char(5) NOT NULL,
  `display` tinyint(1) NOT NULL,
  `element` varchar(30) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `translateName` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `modules`
--

INSERT INTO `modules` (`id`, `name`, `link`, `version`, `display`, `element`, `controller`, `action`, `image`, `translateName`, `status`) VALUES
(1, 'EMAIL', '/mail/mailboxes', '0.1', 1, '', '', '', '0', 'Mailboxes', 0),
(2, 'CRON', '/crontab/crons', '0.1', 1, '', '', '', '0', 'Cronjobs', 0),
(3, 'DNS', '/dns/domains', '0.1', 1, '', '', '', '0', 'Domains', 0),
(4, 'FTP', '/ftp/ftpusers', '0.1', 1, '', '', '', '0', 'File transfer', 0),
(5, 'SQL', '/sql/sqlusers', '0.1', 1, '', '', '', '0', 'Databases', 0),
(6, 'BILLING', '/billing/bills', '0.1', 0, 'users', 'bills', 'index', '/billing/img/options/bill/view_bills.jpg', 'Bills', 0),
(7, 'REDIRECT', '/redirect/redirections', '0.1', 0, 'domains', 'redirections', 'index', '/redirect/img/options/redirection/add_redirection.png', 'Redirections', 0);

-- --------------------------------------------------------

--
-- Structure de la table `offers`
--

CREATE TABLE IF NOT EXISTS `offers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `offers`
--

INSERT INTO `offers` (`id`, `name`, `created`, `status`) VALUES
(1, 'free', '2009-09-22 10:08:40', 0);

-- --------------------------------------------------------

--
-- Structure de la table `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `id` int(11) NOT NULL,
  `version` char(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `maintenance` tinyint(4) NOT NULL,
  `maintenance_description` text NOT NULL,
  `language` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `ns1` varchar(255) NOT NULL,
  `ns2` varchar(255) NOT NULL,
  `ns3` varchar(255) NOT NULL,
  `ipns1` varchar(255) NOT NULL,
  `ipns2` varchar(255) NOT NULL,
  `ipns3` varchar(255) NOT NULL,
  `mx1` varchar(255) NOT NULL,
  `mx2` varchar(255) NOT NULL,
  `ipmx1` varchar(255) NOT NULL,
  `ipmx2` varchar(255) NOT NULL,
  `zone_path` varchar(255) NOT NULL,
  `named_path` varchar(255) NOT NULL,
  `link_sql` varchar(255) NOT NULL,
  `link_ftp` varchar(255) NOT NULL,
  `link_email` varchar(255) NOT NULL,
  `link_doc` varchar(255) NOT NULL,
  `link_forum` varchar(255) NOT NULL,
  `link_irc` varchar(255) NOT NULL,
  `link_phpinfo` varchar(255) NOT NULL,
  `link_mailing` varchar(255) NOT NULL,
  `display_weblink` tinyint(1) NOT NULL,
  `display_reset_account` tinyint(1) NOT NULL,
  `display_delete_account` tinyint(1) NOT NULL,
  `port_ftp` varchar(255) NOT NULL,
  `port_web` varchar(255) NOT NULL,
  `port_ssl` varchar(255) NOT NULL,
  `port_mysql` varchar(255) NOT NULL,
  `port_pop` varchar(255) NOT NULL,
  `port_imap` varchar(255) NOT NULL,
  `port_smtp` varchar(255) NOT NULL,
  `port_dns` varchar(255) NOT NULL,
  `mail_admin` varchar(255) NOT NULL,
  `mail_robot` varchar(255) NOT NULL,
  `mail_abuse` varchar(255) NOT NULL,
  `mail_business` varchar(255) NOT NULL,
  `mail_support` varchar(255) NOT NULL,
  `vhost_path` varchar(255) NOT NULL,
  `logs_path` varchar(255) NOT NULL,
  `check_version` tinyint(1) NOT NULL DEFAULT '0',
  `logs_module` int(1) NOT NULL DEFAULT '1',
  `ip_web` varchar(255) NOT NULL,
  `mail_postmaster` varchar(255) NOT NULL,
  `phpcgi_path` varchar(255) NOT NULL,
  `ftp_address` varchar(255) NOT NULL,
  `sql_address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `options`
--

INSERT INTO `options` (`id`, `version`, `name`, `maintenance`, `maintenance_description`, `language`, `address`, `path`, `ns1`, `ns2`, `ns3`, `ipns1`, `ipns2`, `ipns3`, `mx1`, `mx2`, `ipmx1`, `ipmx2`, `zone_path`, `named_path`, `link_sql`, `link_ftp`, `link_email`, `link_doc`, `link_forum`, `link_irc`, `link_phpinfo`, `link_mailing`, `display_weblink`, `display_reset_account`, `display_delete_account`, `port_ftp`, `port_web`, `port_ssl`, `port_mysql`, `port_pop`, `port_imap`, `port_smtp`, `port_dns`, `mail_admin`, `mail_robot`, `mail_abuse`, `mail_business`, `mail_support`, `vhost_path`, `logs_path`, `check_version`, `logs_module`, `ip_web`, `mail_postmaster`, `phpcgi_path`, `ftp_address`, `sql_address`) VALUES
(1, 'b0.1', 'GoldZone Web', 0, '<h2>Maintenance</h2><br />\r\n\r\n<p>Votre espace membre est actuellement en cours de maintenance.</p><br />\r\n\r\n<p>Pour toutes questions n''hÃ©sitez pas Ã  venir nous rejoindre sur notre forum.</p><br />\r\n\r\n<p>L''Ã©quipe d''administration</p>', 'french', 'https://panel.domain.tld', '/srv/data/', 'ns1.domain.tld', 'ns3.domain.tld', 'ns2.domain.tld', '192.168.0.10', '192.168.0.11', '192.168.0.12', 'mail01.domain.tld', 'mail02.domain.tld', '192.168.0.10', '192.168.0.11', '/var/cache/bind/zones/', '/etc/bind/named.conf', 'https://phpmyadmin.domain.tld', 'https://webftp.domain.tld', 'https://webmail.domain.tld', 'http://docs.domain.tld', 'http://forum.domain.tld', 'http://irc.domain.tld', 'http://phpinfo.domain.tld', 'http://mailing-list.domain.tld', 0, 1, 1, '21', '80', '443', '3306', '110', '143', '25', '53', 'admin@domain.tld', 'robot@domain.tld', 'abus@domain.tld', 'commercial@domain.tld', 'support@domain.tld', '/srv/config/', '/srv/data/', 1, 1, '192.168.0.100', 'postmaster.domain.tld', '/etc/php5-fcgi/', 'ftp01.domain.tld', 'sql.domain.tld');

-- --------------------------------------------------------

--
-- Structure de la table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `profiles`
--

INSERT INTO `profiles` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Member');

-- --------------------------------------------------------

--
-- Structure de la table `quotas`
--

CREATE TABLE IF NOT EXISTS `quotas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `offer_id` int(11) NOT NULL,
  `ftpuser` varchar(5) NOT NULL,
  `sqluser` varchar(5) NOT NULL,
  `sqldata` varchar(5) NOT NULL,
  `mailbox` varchar(5) NOT NULL,
  `alias` varchar(5) NOT NULL,
  `domain` varchar(5) NOT NULL,
  `subdomain` varchar(5) NOT NULL,
  `cron` varchar(5) NOT NULL,
  `diskspace` varchar(255) NOT NULL,
  `bandwidth` varchar(255) NOT NULL,
  `redirection` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Contenu de la table `quotas`
--

INSERT INTO `quotas` (`id`, `offer_id`, `ftpuser`, `sqluser`, `sqldata`, `mailbox`, `alias`, `domain`, `subdomain`, `cron`, `diskspace`, `bandwidth`, `redirection`) VALUES
(1, 1, '2', '1', '3', '3', '3', '1', '0', '1', '500', 'unlimited', '1');

-- --------------------------------------------------------

--
-- Structure de la table `quotasprogresses`
--

CREATE TABLE IF NOT EXISTS `quotasprogresses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `bandwidth` varchar(12) NOT NULL DEFAULT '0',
  `diskspace` varchar(12) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Contenu de la table `quotasprogresses`
--

-- --------------------------------------------------------

--
-- Structure de la table `redirections`
--

CREATE TABLE IF NOT EXISTS `redirections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `domain_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Contenu de la table `redirections`
--


-- --------------------------------------------------------

--
-- Structure de la table `robot`
--

CREATE TABLE IF NOT EXISTS `robot` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `data` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `domain` int(11) NOT NULL,
  `tmp` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Contenu de la table `robot`
--

-- --------------------------------------------------------

--
-- Structure de la table `sqldatas`
--

CREATE TABLE IF NOT EXISTS `sqldatas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sqluser_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Contenu de la table `sqldatas`
--

-- --------------------------------------------------------

--
-- Structure de la table `sqlusers`
--

CREATE TABLE IF NOT EXISTS `sqlusers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `sqlusers`
--

-- --------------------------------------------------------

--
-- Structure de la table `subdomains`
--

CREATE TABLE IF NOT EXISTS `subdomains` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `domain_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `subdomains`
--


-- --------------------------------------------------------

--
-- Structure de la table `transports`
--

CREATE TABLE IF NOT EXISTS `transports` (
  `domain` varchar(128) NOT NULL,
  `transport` varchar(128) NOT NULL,
  UNIQUE KEY `domain` (`domain`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `transports`
--


-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `offer_id` tinyint(5) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(1) DEFAULT NULL,
  `registered` datetime NOT NULL,
  `last_time` datetime NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `language` char(20) NOT NULL,
  `uid` int(6) NOT NULL,
  `gid` int(6) NOT NULL,
  `reset` tinyint(4) NOT NULL,
  `newsletter` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `profile_id`, `offer_id`, `lastname`, `firstname`, `email`, `name`, `password`, `status`, `registered`, `last_time`, `address`, `zipcode`, `city`, `country`, `telephone`, `language`, `uid`, `gid`, `reset`, `newsletter`) VALUES
(1, 1, 12, 'GoldZone Web', 'Panel', 'admin@domain.tld', 'administrator', '', 0, '2009-05-12 21:44:00', '0000-00-00 00:00:00', '8 street of server', '00000', 'ServerCity', 'ServerLand', '+330000000', 'french', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `vacations`
--

CREATE TABLE IF NOT EXISTS `vacations` (
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `cache` text NOT NULL,
  `domain` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`email`),
  KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `vacations`
--


-- --------------------------------------------------------

--
-- Structure de la table `virtualdomains`
--

CREATE TABLE IF NOT EXISTS `virtualdomains` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `aliases` int(10) NOT NULL DEFAULT '0',
  `mailboxes` int(10) NOT NULL DEFAULT '0',
  `maxquota` int(10) NOT NULL DEFAULT '0',
  `transport` varchar(255) DEFAULT NULL,
  `backupmx` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

--
-- Contenu de la table `virtualdomains`
--

