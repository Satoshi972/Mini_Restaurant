-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 14 Mars 2017 à 20:00
-- Version du serveur :  10.1.19-MariaDB
-- Version de PHP :  5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `restaurant`
--
CREATE DATABASE IF NOT EXISTS `restaurant` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `restaurant`;

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE `contacts` (
  `cts_id` int(11) NOT NULL,
  `cts_content` text NOT NULL,
  `cts_date` datetime NOT NULL,
  `cts_statuts` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `contacts`
--

INSERT INTO `contacts` (`cts_id`, `cts_content`, `cts_date`, `cts_statuts`) VALUES
(1, '{"last_name":"codekiller","first_name":"killer","email":"admin@free.fr","comment":"eztgresgbwerbre"}', '2017-03-14 14:04:38', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `recipe`
--

CREATE TABLE `recipe` (
  `rcp_id` int(11) NOT NULL,
  `rcp_title` varchar(255) NOT NULL,
  `rcp_usr_id` int(11) NOT NULL,
  `rcp_content` text NOT NULL,
  `rcp_picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `recipe`
--

INSERT INTO `recipe` (`rcp_id`, `rcp_title`, `rcp_usr_id`, `rcp_content`, `rcp_picture`) VALUES
(1, 'Gratin de concombres au basilic', 15, 'ÉTAPE 2\r\nVersez 2 c. à soupe de sel et laissez reposer 2 heures.\r\n\r\nÉTAPE 3\r\nEnsuite, égouttez-les et essorez-les.\r\n\r\nÉTAPE 4\r\nFaites revenir à la poêle les concombres, la créme et 20 g de beurre. Saupoudrez de basilic ciselé, de poivre et laissez mijoter à feu doux pendant 15 minutes.\r\n\r\nÉTAPE 5\r\nMettez le tout dans un plat à gratin, parsemez de fromage râpé et déposez une noix de beurre sur le dessus.\r\n\r\nÉTAPE 6\r\nFaites gratiner 5 minutes.\r\n\r\n\r\nEn savoir plus sur \r\nappeler RUddy', './admin/uploads/image_58c41e7d0d4ac.JPG'),
(2, 'gratin de ti nain', 15, 'Dans un saladier, écrasez finement les bananes vertes déjà cuites. \r\nDans une casserole, mettez à fondre le beurre dans un filet d''huile. \r\nUne fois le beurre mousseux, ajoutez les mélanges 4 épices et bouquet garni puis l''oignon. \r\nLaissez l''oignon devenir translucide, ce qui prend environ 1-2 minutes.', './admin/uploads/image_58c6a81887c5c.jpg'),
(3, 'gratin au bananes jaunes', 14, 'Épluchez les bananes et faites-les cuire à la vapeur 15 à 20 minutes. Préparez une béchamel épaisse avec le lait, le beurre, la farine et le demi cube de bouillon de légumes. Écrasez les bananes dans la béchamel et mélangez pour avoir une pâte épaisse. Ajoutez une poignée de fromage.', './admin/uploads/image_58c6a83c40002.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `reset_password`
--

CREATE TABLE `reset_password` (
  `psw_id` int(11) NOT NULL,
  `psw_usr_id` int(11) NOT NULL,
  `psw_token` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `reset_password`
--

INSERT INTO `reset_password` (`psw_id`, `psw_usr_id`, `psw_token`) VALUES
(22, 10, '7aa6a470cc2a9d367f2510118ed2d079');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `rol_id` int(11) NOT NULL,
  `rol_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `role`
--

INSERT INTO `role` (`rol_id`, `rol_name`) VALUES
(3, 'admin'),
(4, 'editor');

-- --------------------------------------------------------

--
-- Structure de la table `site_info`
--

CREATE TABLE `site_info` (
  `inf_id` int(11) NOT NULL,
  `inf_address` varchar(255) NOT NULL,
  `inf_picture` varchar(255) NOT NULL,
  `inf_content` text NOT NULL,
  `inf_name` varchar(255) NOT NULL,
  `inf_phone` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Contenu de la table `site_info`
--

INSERT INTO `site_info` (`inf_id`, `inf_address`, `inf_picture`, `inf_content`, `inf_name`, `inf_phone`) VALUES
(1, '73 Rue de Prony 75017 Paris France', 'uploads/img_58c826e1ac92b.jpg', 'LA DÉCORATION – Simple mais accueillante, la décoration que vous offre ce restaurant vous laissera savourer votre repas dans un lieu très bien aménagé avec un mobilier très agréable à l’œil, à tester !\r\n\r\nL’AMBIANCE – Lorsque vous irez déjeuner ou dîner dans cet établissement, vous aurez l’impression d’être chez vous, l’ambiance vraiment très relaxante ne pourra que vous mettre à l’aise, un vrai plus.\r\n\r\nLA TERRASSE – Si vous aimez prendre votre déjeuner en terrasse alors le restaurant L''assiette Gourmande ne pourra que vous donner satisfaction, de quoi profiter du beau temps.', 'L''assiette Gourmande', '0142536778');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `usr_id` int(11) NOT NULL,
  `usr_lastname` varchar(50) NOT NULL,
  `usr_firstname` varchar(50) NOT NULL,
  `usr_email` varchar(255) NOT NULL,
  `usr_password` varchar(255) NOT NULL,
  `usr_subscribedate` datetime NOT NULL,
  `usr_rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`usr_id`, `usr_lastname`, `usr_firstname`, `usr_email`, `usr_password`, `usr_subscribedate`, `usr_rol_id`) VALUES
(14, 'admin', 'admin', 'admin@admin.fr', '$2y$10$.waLe9MD/FUKEhS9ebSM8Ow0NzNRR2b3mBhWS6.2vuTuT/2fjNTzG', '2017-03-14 14:38:04', 3),
(15, 'editeur', 'editeur', 'editeur@editeur.fr', '$2y$10$4r3ChrD9smVMK1O0XuKzj.djWk2y5i2ECgUP4E8sVwzyTFGHOt0XW', '2017-03-14 14:39:12', 4);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`cts_id`);

--
-- Index pour la table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`rcp_id`);

--
-- Index pour la table `reset_password`
--
ALTER TABLE `reset_password`
  ADD PRIMARY KEY (`psw_id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`rol_id`);

--
-- Index pour la table `site_info`
--
ALTER TABLE `site_info`
  ADD PRIMARY KEY (`inf_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usr_id`),
  ADD UNIQUE KEY `usr_email` (`usr_email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `cts_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `rcp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `reset_password`
--
ALTER TABLE `reset_password`
  MODIFY `psw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `rol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `site_info`
--
ALTER TABLE `site_info`
  MODIFY `inf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
