-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Sam 19 Novembre 2016 à 11:29
-- Version du serveur :  5.1.73
-- Version de PHP :  5.4.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `vandenbr3u`
--

-- --------------------------------------------------------

--
-- Structure de la table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `id_event` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Activity_Event_idx` (`id_event`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `activity`
--

INSERT INTO `activity` (`id`, `name`, `description`, `price`, `date`, `id_event`) VALUES
(6, 'Marathon 40km', 'At nunc si ad aliquem bene nummatum tumentemque ideo honestus advena salutatum introieris, primitus tamquam exoptatus suscipieris et interrogatus multa coactusque mentiri, miraberis numquam antea visus summatem virum tenuem te sic enixius observantem, ut paeniteat ob haec bona tamquam praecipua non vidisse ante decennium Romam.', '10', '2016-11-18 10:15:00', 4),
(7, 'Sprint 300m', 'At nunc si ad aliquem bene nummatum tumentemque ideo honestus advena salutatum introieris, primitus tamquam exoptatus suscipieris et interrogatus multa coactusque mentiri, miraberis numquam antea visus summatem virum tenuem te sic enixius observantem, ut paeniteat ob haec bona tamquam praecipua non vidisse ante decennium Romam.', '1', '2016-11-18 19:50:00', 4),
(8, 'Natation 700m', 'At nunc si ad aliquem bene nummatum tumentemque ideo honestus advena salutatum introieris, primitus tamquam exoptatus suscipieris et interrogatus multa coactusque mentiri, miraberis numquam antea visus summatem virum tenuem te sic enixius observantem, ut paeniteat ob haec bona tamquam praecipua non vidisse ante decennium Romam.', '4', '2016-11-18 09:00:00', 4),
(9, 'Foulée 15km', 'At nunc si ad aliquem bene nummatum tumentemque ideo honestus advena salutatum introieris, primitus tamquam exoptatus suscipieris et interrogatus multa coactusque mentiri, miraberis numquam antea visus summatem virum tenuem te sic enixius observantem, ut paeniteat ob haec bona tamquam praecipua non vidisse ante decennium Romam.', '3', '2016-11-18 13:10:00', 4),
(10, 'Marathon Lille Lens gare', 'Marathon de 30km', '8', '2016-11-30 06:00:00', 5),
(11, 'Les 10km de Lens', 'Marathon de la gare de Lens jusqu''au terril. ', '8', '2016-11-30 10:00:00', 5),
(12, 'Course libre', '//', '3', '2016-11-25 15:00:00', 7);

-- --------------------------------------------------------

--
-- Structure de la table `discipline`
--

CREATE TABLE IF NOT EXISTS `discipline` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `discipline`
--

INSERT INTO `discipline` (`id`, `name`) VALUES
(1, 'marathon'),
(2, 'vélo'),
(3, 'triathlon');

-- --------------------------------------------------------

--
-- Structure de la table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `addresse` varchar(100) DEFAULT NULL,
  `id_promoter` int(11) DEFAULT NULL,
  `id_discipline` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_event_promoter_idx` (`id_promoter`),
  KEY `fk_event_discipline_idx` (`id_discipline`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `event`
--

INSERT INTO `event` (`id`, `name`, `description`, `startDate`, `endDate`, `status`, `addresse`, `id_promoter`, `id_discipline`) VALUES
(4, 'Triathlon 60km', 'At nunc si ad aliquem bene nummatum tumentemque ideo honestus advena salutatum introieris, primitus tamquam exoptatus suscipieris et interrogatus multa coactusque mentiri, miraberis numquam antea visus summatem virum tenuem te sic enixius observantem, ut paeniteat ob haec bona tamquam praecipua non vidisse ante decennium Romam.', '2016-11-25', '2016-11-27', 1, 'Nancy-Metz', 5, 3),
(5, 'La route du Louvre-Lens', 'Marathon de Lille à Lens.', '2016-11-30', '2016-11-30', 4, 'Lens', 5, 1),
(7, 'Téléthon', 'Course d&#39;endurance libre prévue pour récolter des fonds pour des associations humanitaires.', '2016-11-25', '2016-11-25', 1, 'Marseille', 6, 1);

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

CREATE TABLE IF NOT EXISTS `participant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(255) DEFAULT NULL,
  `birthDate` date DEFAULT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `participant`
--

INSERT INTO `participant` (`id`, `mail`, `birthDate`, `firstName`, `lastName`) VALUES
(1, 'Bli@blu.com', '0000-00-00', 'Bli', 'Blu'),
(2, 'do@d.fr', '2016-12-12', 'tgyub', 'buyttnuyè bnu'),
(3, 'dorian@dorianv.fr', '1994-04-04', 'Dorian', 'Dodo'),
(4, 'dorian.vdb@hotmail.com', '1994-04-04', 'Dorian', 'Vdb'),
(5, 'jean@bon.com', '1957-12-15', 'Jean', 'Bon'),
(6, 'Marcel@p.fe', '1994-04-04', 'Marcel', 'Pagnol'),
(7, 'jck.d@hotmail.fr', '1990-02-10', 'Jack', 'Dob'),
(8, 'david.jhn@hotmail.fr', '1986-12-09', 'David', 'John'),
(9, 'john.cena@hotmail.fr', '1990-09-25', 'John', 'Cena'),
(10, 'michel.dpt@hotmail.fr', '1998-06-14', 'Michel', 'Dupont'),
(11, 'marco.velo@gmail.com', '1990-09-08', 'Marco', 'Velo'),
(12, 'jack.dupont@web.fr', '1992-12-12', 'Jack', 'Dupont'),
(13, 'emma.ich@web.fr', '2000-10-14', 'Emma', 'Ich'),
(14, 'jp.lee@gmail.com', '1960-09-07', 'Jean-Paul', 'Lee');

-- --------------------------------------------------------

--
-- Structure de la table `participant_activity`
--

CREATE TABLE IF NOT EXISTS `participant_activity` (
  `id_participant` int(11) NOT NULL,
  `id_activity` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `ranking` int(11) DEFAULT NULL,
  `participant_number` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_participant`,`id_activity`),
  KEY `fk_participant_activity__activity_idx` (`id_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `participant_activity`
--

INSERT INTO `participant_activity` (`id_participant`, `id_activity`, `score`, `ranking`, `participant_number`) VALUES
(3, 12, NULL, NULL, '142563'),
(4, 10, NULL, NULL, '199292'),
(4, 11, NULL, NULL, '525055'),
(6, 10, NULL, NULL, '713773'),
(7, 6, NULL, NULL, '114739'),
(7, 8, NULL, NULL, '517450'),
(8, 6, NULL, NULL, '406980'),
(8, 8, NULL, NULL, '200225'),
(9, 11, 3, 5, '289776'),
(10, 11, 2, 8, '060569'),
(11, 6, NULL, NULL, '805088'),
(11, 7, NULL, NULL, '690357'),
(12, 12, NULL, NULL, '897173'),
(13, 12, NULL, NULL, '568023'),
(14, 8, NULL, NULL, '833077'),
(14, 12, NULL, NULL, '000277');

-- --------------------------------------------------------

--
-- Structure de la table `promoter`
--

CREATE TABLE IF NOT EXISTS `promoter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `promoter`
--

INSERT INTO `promoter` (`id`, `name`, `mail`, `login`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin', 'admin'),
(2, 'marco', 'marco@gmail.com', 'marco', 'marco'),
(3, 'dorian', 'dorian@dorian.com', 'dorian', '$2y$10$wchWKuNHKV6wqPBYr0HwDu0STQV8A0MvW563kyhBGuw6W5qzFfN06'),
(4, 'Emma', 'emma@emma.fr', 'emma', '$2y$10$s2Wvel5UqKHOuIzdmfLFdODIMSTYsvCJaoed0dJiTs33Mh/Ki5Snu'),
(5, 'dodo', 'do@d.fr', 'dodo', '$2y$10$l6duy/z9n70itnGvJwYCae8itziZUCrNSOTo5DgrJQmmkefTrKFmi'),
(6, 'Toto', 'toto@hotmail.fr', 'Toto', '$2y$10$R4Wupx.D8O6J61Wt3OGUgOGl4lzU3HEqv.fspVTb5LF8SUpAGsM7G');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `fk_activity_event` FOREIGN KEY (`id_event`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Contraintes pour la table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `fk_event_discipline` FOREIGN KEY (`id_discipline`) REFERENCES `discipline` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_event_promoter` FOREIGN KEY (`id_promoter`) REFERENCES `promoter` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Contraintes pour la table `participant_activity`
--
ALTER TABLE `participant_activity`
  ADD CONSTRAINT `fk_participant_activity_participant` FOREIGN KEY (`id_participant`) REFERENCES `participant` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_participant_activity__activity` FOREIGN KEY (`id_activity`) REFERENCES `activity` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
