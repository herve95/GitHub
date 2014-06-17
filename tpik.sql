-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Lun 26 Mai 2014 à 12:43
-- Version du serveur: 5.6.14
-- Version de PHP: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `tpik`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` smallint(6) NOT NULL,
  `name` varchar(256) NOT NULL,
  `description` text NOT NULL,
  `position` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `position`) VALUES
(1, 'nr', 'ntrvre', 1);

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE IF NOT EXISTS `compte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `pays` varchar(255) NOT NULL,
  `date_de_naissance` date NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `departement` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `compte`
--

INSERT INTO `compte` (`id`, `pseudo`, `nom`, `prenom`, `ville`, `pays`, `date_de_naissance`, `adresse`, `departement`, `email`, `password`) VALUES
(1, 'herve95', 'DO VAN', 'HervÃ©', 'Villiers-Le-Bel', 'France', '0000-00-00', 'AllÃ©e de la ferme queux', 95, 'hdovan95@gmail.com', 'ab4f63f9ac65152575886860dde480a1'),
(2, 'Doctor United', 'LAROUR', 'Thibault', 'andorre', 'cv', '0000-00-00', 'ze', 1, 'hdovan95@gmail.com', 'ab4f63f9ac65152575886860dde480a1');

-- --------------------------------------------------------

--
-- Structure de la table `concert`
--

CREATE TABLE IF NOT EXISTS `concert` (
  `salle` varchar(40) NOT NULL,
  `date` date NOT NULL,
  `groupe` varchar(40) DEFAULT NULL,
  `prix` int(3) DEFAULT NULL,
  `nom_event` varchar(40) NOT NULL,
  `description` varchar(10000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

CREATE TABLE IF NOT EXISTS `evenement` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `salle` varchar(40) NOT NULL,
  `nom_event` varchar(100) NOT NULL,
  `timestamp` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE IF NOT EXISTS `groupe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_groupe` varchar(255) NOT NULL,
  `gerant_groupe` varchar(255) NOT NULL,
  `style` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `departement` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `groupe`
--

INSERT INTO `groupe` (`id`, `nom_groupe`, `gerant_groupe`, `style`, `email`, `departement`, `telephone`) VALUES
(1, 'DBSK', 'herve95', 'none', 'lol@gmail.com', '95', '0790766');

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `ID` int(5) NOT NULL AUTO_INCREMENT,
  `chemin` varchar(200) NOT NULL,
  `nom_image` varchar(200) NOT NULL,
  `type_compte` varchar(40) NOT NULL,
  `Date` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `image`
--

INSERT INTO `image` (`ID`, `chemin`, `nom_image`, `type_compte`, `Date`) VALUES
(1, 'upload/groupe/DBSK1400596993.jpg', 'DBSK1400596993.jpg', 'DBSK', '2014-05-20 14:43:13.670344'),
(2, 'upload/groupe/DBSK1400597108.jpg', 'DBSK1400597108.jpg', 'DBSK', '2014-05-20 14:45:08.674746'),
(3, 'upload/groupe/DBSK1400597220.jpg', 'DBSK1400597220.jpg', 'DBSK', '2014-05-20 14:47:00.407226'),
(4, 'upload/groupe/DBSK1400597283.jpg', 'DBSK1400597283.jpg', 'DBSK', '2014-05-20 14:48:03.540858'),
(5, 'upload/groupe/DBSK1400597383.jpg', 'DBSK1400597383.jpg', 'DBSK', '2014-05-20 14:49:43.474634'),
(6, 'upload/compte/1.jpg', '1.jpg', 'compte', '2014-05-23 08:20:33.697409'),
(7, 'upload/compte/2.jpg', '2.jpg', 'compte', '2014-05-25 08:12:30.014518');

-- --------------------------------------------------------

--
-- Structure de la table `membre_groupe`
--

CREATE TABLE IF NOT EXISTS `membre_groupe` (
  `pseudo` varchar(40) NOT NULL,
  `groupe` varchar(40) NOT NULL,
  KEY `pseudo` (`pseudo`),
  KEY `groupe` (`groupe`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `membre_groupe`
--

INSERT INTO `membre_groupe` (`pseudo`, `groupe`) VALUES
('Doctor United', 'DBSK');

-- --------------------------------------------------------

--
-- Structure de la table `musique`
--

CREATE TABLE IF NOT EXISTS `musique` (
  `nom_groupe` varchar(40) NOT NULL,
  `titre` varchar(40) NOT NULL,
  `chemin_musique` varchar(200) NOT NULL,
  `Date` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `musique`
--

INSERT INTO `musique` (`nom_groupe`, `titre`, `chemin_musique`, `Date`) VALUES
('DBSK', 'DBSKcarly-rae-jepsen---call-me-maybe.mp3', 'upload/musique/DBSKcarly-rae-jepsen---call-me-maybe', '2014-05-20 14:43:13.701544'),
('DBSK', 'DBSKC ma Life.mp3', 'upload/musique/DBSKC ma Life', '2014-05-20 14:45:08.705946'),
('DBSK', 'DBSKTh day i fall in love.mp3', 'upload/musique/DBSKTh day i fall in love', '2014-05-20 14:47:00.447228'),
('DBSK', 'DBSKChris Brown - Dont Wake Me Up.mp3', 'upload/musique/DBSKChris Brown - Dont Wake Me Up', '2014-05-20 14:48:03.603258'),
('DBSK', 'DBSKT-ara-Sexy_love.mp3', 'upload/musique/DBSKT-ara-Sexy_love', '2014-05-20 14:49:43.537034');

-- --------------------------------------------------------

--
-- Structure de la table `pm`
--

CREATE TABLE IF NOT EXISTS `pm` (
  `id` bigint(20) NOT NULL,
  `id2` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `user1` bigint(20) NOT NULL,
  `user2` bigint(20) NOT NULL,
  `message` text NOT NULL,
  `timestamp` int(10) NOT NULL,
  `user1read` varchar(3) NOT NULL,
  `user2read` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `pm`
--

INSERT INTO `pm` (`id`, `id2`, `title`, `user1`, `user2`, `message`, `timestamp`, `user1read`, `user2read`) VALUES
(1, 1, 'bogosse', 4, 1, 'fezg', 1399882034, 'yes', 'yes'),
(2, 1, 'grehe', 4, 1, 'gefrdhe', 1399882049, 'yes', 'yes'),
(1, 2, '', 4, 0, 'hu-', 1399883065, '', '');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE IF NOT EXISTS `salle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_salle` varchar(255) NOT NULL,
  `gerant_salle` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `departement` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `telephone` int(11) NOT NULL,
  `ville` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `salle`
--

INSERT INTO `salle` (`id`, `nom_salle`, `gerant_salle`, `email`, `departement`, `adresse`, `telephone`, `ville`) VALUES
(1, 'Pokemonaa', 'herve95', 'pokemon@gmail.com', '8009', 'Paris', 0, ''),
(2, 'LALA', 'lalalala', 'lol@gmail.com', '95', 'alle marchand', 0, ''),
(3, 'mama', 'virus', 'lol@gmail.com', '95', 'alle marchand', 0, '');

-- --------------------------------------------------------

--
-- Structure de la table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `parent` smallint(6) NOT NULL,
  `id` int(11) NOT NULL,
  `id2` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `message` longtext NOT NULL,
  `authorid` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `timestamp2` int(11) NOT NULL,
  PRIMARY KEY (`id`,`id2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
