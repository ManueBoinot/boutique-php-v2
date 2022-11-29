-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 29 nov. 2022 à 13:35
-- Version du serveur : 5.7.36
-- Version de PHP : 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `boutique_en_ligne`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresses`
--

DROP TABLE IF EXISTS `adresses`;
CREATE TABLE IF NOT EXISTS `adresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) NOT NULL,
  `adresse` varchar(40) NOT NULL,
  `cp` varchar(5) NOT NULL,
  `ville` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_client` (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_gamme` int(11) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `description` varchar(25) NOT NULL,
  `description_detaillee` text NOT NULL,
  `image` varchar(40) NOT NULL,
  `prix` float NOT NULL,
  `stock` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_gamme` (`id_gamme`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `id_gamme`, `nom`, `description`, `description_detaillee`, `image`, `prix`, `stock`) VALUES
(1, 3, 'Nature', 'Rusticité et élégance', 'Notre arbre à chat vedette !\r\nMatériaux 100% naturels et non traités => Bois flotté, chêne brut et sisal naturel.\r\nDimensions : Hauteur env. 180 cm - Base carrée : 50 x 50 cm ', 'images\\arbre_naturel.jpg', 180, 2),
(2, 2, 'Nuage', 'Légèreté et douceur', 'Votre chat adorera ses plateformes moelleuses et toutes douces !\r\nMatériaux 100% naturels et non traités => Bois flotté, sisal naturel et fibre de coton bio.\r\nDimensions : Hauteur env. 180 cm - Base ronde : diam. 30 cm', 'images\\arbre_nuage2.jpg', 150, 1),
(3, 1, 'Chic', 'Classe et modernité', 'Parce qu\'un arbre à chat peut aussi être un objet de décoration !\r\nMatériaux => Panneau aggloméré FSC, sisal naturel et coussins en mousse recyclée.\r\nDimensions : Hauteur env. 180 cm - Base rectangulaire : 80 x 40 cm', 'images\\arbre_chic.jpg', 200, 1),
(4, 1, 'Chic noir', 'Classe et modernité', 'Parce qu\'un arbre à chat peut aussi être un objet de décoration !\r\nMatériaux => Panneau aggloméré FSC, sisal naturel et coussins en mousse recyclée.\r\nDimensions : Hauteur env. 180 cm - Base rectangulaire : 80 x 40 cm', 'images\\arbre_chic_noir.jpg', 200, 0),
(5, 2, 'Nuage noir', 'Légèreté et douceur', 'Votre chat adorera ses plateformes moelleuses et toutes douces !\r\nMatériaux 100% naturels et non traités => Bois flotté, sisal naturel et fibre de coton bio.\r\nDimensions : Hauteur env. 180 cm - Base ronde : diam. 30 cm', 'images\\arbre_nuage_noir2.jpg', 150, 3),
(6, 3, 'Nature noir', 'Rusticité et élégance', 'Notre arbre à chat vedette !\r\nMatériaux 100% naturels et non traités => Bois flotté, chêne brut et sisal naturel.\r\nDimensions : Hauteur env. 180 cm - Base carrée : 50 x 50 cm ', 'images\\arbre_naturel_noir.jpg', 180, 2);

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) NOT NULL,
  `prenom` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `date_commande` varchar(25) NOT NULL,
  `prix` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_client_commande` (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commandes_articles`
--

DROP TABLE IF EXISTS `commandes_articles`;
CREATE TABLE IF NOT EXISTS `commandes_articles` (
  `id_commande` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  KEY `fk_id_commande` (`id_commande`),
  KEY `fk_id_article` (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `gammes`
--

DROP TABLE IF EXISTS `gammes`;
CREATE TABLE IF NOT EXISTS `gammes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `gammes`
--

INSERT INTO `gammes` (`id`, `nom`) VALUES
(1, 'Moderne'),
(2, 'Cosy'),
(3, 'Rustique');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `adresses`
--
ALTER TABLE `adresses`
  ADD CONSTRAINT `fk_id_client` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`);

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `fk_id_gamme` FOREIGN KEY (`id_gamme`) REFERENCES `gammes` (`id`);

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `fk_id_client_commande` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`);

--
-- Contraintes pour la table `commandes_articles`
--
ALTER TABLE `commandes_articles`
  ADD CONSTRAINT `fk_id_article` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `fk_id_commande` FOREIGN KEY (`id_commande`) REFERENCES `commandes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
