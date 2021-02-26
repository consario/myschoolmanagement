-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 26 fév. 2021 à 23:31
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `clown`
--

-- --------------------------------------------------------

--
-- Structure de la table `filiere`
--

DROP TABLE IF EXISTS `filiere`;
CREATE TABLE IF NOT EXISTS `filiere` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8 NOT NULL,
  `Netudiants` int(11) NOT NULL,
  `filiere_statut` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `filiere`
--

INSERT INTO `filiere` (`id`, `nom`, `Netudiants`, `filiere_statut`) VALUES
(1, 'Création de site web', 4, 1),
(2, 'Délégué Médicale', 3, 1),
(3, 'Secrétariat et Caissière polyvalent', 0, 1),
(4, 'Billetterie et Gestion des agences de voyage', 1, 1),
(5, 'Audiovisuel , Cadrage et Montage', 1, 1),
(6, 'Auxiliaire de Banque et Microfinance', 0, 1),
(7, 'Montage antenne parabolique et panneaux solaires', 2, 1),
(8, 'Décoration événementielle  ', 1, 1),
(9, 'Expertise Maritime', 1, 1),
(11, 'Esthétique Cosmétique', 0, 1),
(12, 'Informatique d\'Entreprise , PAO , OPS', 0, 1),
(13, 'Génie Informatique , Maintenance informatique ', 0, 1),
(15, 'Menuiserie Aluminium', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `matieres`
--

DROP TABLE IF EXISTS `matieres`;
CREATE TABLE IF NOT EXISTS `matieres` (
  `id` int(13) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `id_filiere` int(13) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `matieres`
--

INSERT INTO `matieres` (`id`, `nom`, `id_filiere`) VALUES
(1, 'Développement web', 1),
(2, 'Marketing Digitale', 1),
(3, 'anatomie', 2),
(4, 'technique de Négociation', 2),
(5, 'comptabilité', 3),
(6, 'utilisation de Logiciel de gestion', 3),
(7, 'AMADEUS + GALILEO', 4),
(8, 'gestion de structure de gestion de transfert d\'argent ', 4),
(9, 'Tourisme', 4),
(10, 'Assurance', 4),
(11, 'Cadrage Professionnel ', 5),
(12, 'Prise de Vue', 5),
(13, 'Montage et POST-PRODUCTION', 5),
(14, 'Electricité Bâtiment', 7),
(15, 'Froid', 7),
(16, 'Climatisation et Energie renouvelable', 7),
(17, 'Assurance de Banque et Microfinance', 6),
(18, 'Tourisme', 8),
(19, 'Hôtellerie', 8),
(20, 'cuisine et pâtisserie', 8),
(21, 'Transit International', 9),
(22, 'Magasinage', 9),
(23, 'Commerce International', 9),
(24, 'Esthétique Cosmétique', 11),
(25, 'Bien-Etre', 11),
(26, 'Onglerie et Soins de Visage', 11),
(27, 'Make-up', 11),
(28, 'Graphisme', 12),
(29, 'Perfecto', 12),
(30, 'Sage Saari', 12),
(31, 'Maintenance Informatique', 13),
(32, 'Réparation des Téléphones Portables', 13),
(33, 'Antennes paraboliques', 13),
(34, 'Miroiterie Aluminium', 15),
(35, 'pose de chaises Nacos', 15),
(36, 'baies vitrées', 15);

-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

DROP TABLE IF EXISTS `notes`;
CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `note` int(13) NOT NULL,
  `matiere` varchar(255) NOT NULL,
  `id_etu` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `notes`
--

INSERT INTO `notes` (`id`, `note`, `matiere`, `id_etu`) VALUES
(10, 19, '2', 128),
(9, 13, '1', 128),
(11, 12, '1', 130),
(12, 13, '2', 130),
(13, 12, '1', 109),
(14, 5, '2', 109),
(15, 15, '7', 120),
(16, 11, '9', 120);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `sexe` char(2) NOT NULL,
  `statut` varchar(255) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `active_user` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=136 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `birthday`, `sexe`, `statut`, `purpose`, `active_user`) VALUES
(127, 'louisère', 'jean', 'users10522@gmail.com', '1991-07-02', 'M', 'etudiant', '2', 1),
(130, 'Akpe', 'jean', 'akpe56@gmail.com', '1995-02-04', 'M', 'etudiant', '1', 1),
(131, 'admin', 'admin', 'usersadmin@gmail.com', NULL, 'F', 'admin', 'Professeur', 0),
(132, 'Zinvo', 'claire', 'clairezv8@gmail.com', '1993-01-03', 'F', 'etudiant', '2', 1),
(129, 'louisère', 'jean', 'kugkuusers105@gmail.com', '1990-08-01', 'M', 'etudiant', '5', 1),
(128, 'louis', 'jean', 'users105kh@gmail.com', '1996-09-10', 'M', 'etudiant', '1', 1),
(121, 'Bidossessi', 'jean', 'users106@gmail.com', '1994-06-04', 'M', 'etudiant', '8', 1),
(120, 'kolonon', 'jules', 'jules12@gmail.com', '1990-06-08', 'M', 'etudiant', '4', 1),
(119, 'Bidossessi', 'martin', 'sosjean35@gmail.com', '1993-06-01', 'F', 'etudiant', '2', 1),
(118, 'Boko', 'Bernadette', 'bernadettebk26@gmail.com', '1998-04-04', 'F', 'etudiant', '7', 1),
(117, 'Houevi', 'Beatrice', 'bea12@gmail.com', '1995-09-24', 'F', 'etudiant', '15', 1),
(116, 'Tossou', 'Léatrice', 'leatrice57@gamil.com', NULL, 'F', 'admin', 'Secretaire', 0),
(115, 'Tossou', 'Léatrice', 'leatrice56@gamil.com', NULL, 'F', 'admin', 'Secretaire', 0),
(114, 'houessou', 'paul', 'yas26@gmail.com', NULL, 'F', 'admin', 'Professeur', 0),
(113, 'houessou', 'yasmine', 'yas25@gmail.com', NULL, 'F', 'admin', 'Comptable', 0),
(112, 'kokou', 'merveille', 'user20@gmail.com', NULL, 'F', 'admin', 'Directeur(e) Général(e)', 0),
(111, 'kokou', 'merveille', 'users2@gmail.com', NULL, 'F', 'admin', 'Directeur(e) Général(e)', 0),
(110, 'Dovonou', 'Pierre', 'users200@gmail.com', '1993-03-03', 'M', 'etudiant', '7', 1),
(109, 'Dossou', 'clement', 'users@gmail.com', '1993-03-04', 'F', 'etudiant', '1', 1),
(108, 'louis', 'jean', 'users1050@gmail.com', '1990-01-06', 'F', 'etudiant', '1', 1),
(133, 'Bidossou', 'jeanne', 'jeannebid15@gmail.com', '1991-01-03', 'F', 'etudiant', '9', 1),
(134, 'louisère', 'klekle', 'users10500@gmail.com', '1995-03-24', 'F', 'etudiant', '15', 0),
(135, 'kponou', 'leornat', 'leornatkp23@gmail.com', NULL, 'M', 'parent', 'jules12@gmail.com', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `filiere`
--
ALTER TABLE `filiere` ADD FULLTEXT KEY `nom` (`nom`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
