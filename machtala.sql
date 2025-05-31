-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 31 mai 2025 à 20:54
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `machtala`
--

-- --------------------------------------------------------

--
-- Structure de la table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `blog`
--

INSERT INTO `blog` (`id`, `name`, `text`, `image`, `created_at`) VALUES
(3, 'hiba', 'hiba hiba hiba hiba hiba hiba hiba hiba hhiba hiba hiba hiba ', 'AFRIKAN.png', '2025-05-21 14:53:54');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `zipcode` varchar(20) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `plant_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pepiniere`
--

CREATE TABLE `pepiniere` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `rating` float DEFAULT 0,
  `rating_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `pepiniere`
--

INSERT INTO `pepiniere` (`id`, `user_id`, `name`, `address`, `email`, `phone`, `description`, `image`, `rating`, `rating_count`) VALUES
(5, 3, 'HIBA NAILI', 'citÃ© essarouel N221 elbonni annaba', 'biba@gmail.com', '0669885835', 'hibahbahhhfffgt', '1.jpg', 3, 1),
(6, 6, 'PEPINIERE', 'city elbouni ', 'hibahiba@gmail.com', '0660821707', 'hba hiba ddjduhezdjscqush', '8.jfif', 2.5, 2),
(7, 7, 'RANA', 'SIDI AMMAR', 'rana@gmail.com', '066695432', 'jhjhuhujjjijj', '9.jpg', 0, 0),
(8, 12, 'machtal', 'annaba', 'machtal@gmail.com', '0667554433', 'ghvsibsdifvnsdmfvjis', '8.jfif', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `plantes`
--

CREATE TABLE `plantes` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `exposition_soleil` varchar(100) DEFAULT NULL,
  `temperature` varchar(50) DEFAULT NULL,
  `type_sol` varchar(100) DEFAULT NULL,
  `arrosage` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `plantes`
--

INSERT INTO `plantes` (`id`, `nom`, `type`, `exposition_soleil`, `temperature`, `type_sol`, `arrosage`, `description`, `image`) VALUES
(3, 'African Mask Plant', 'plante tropicale vivace', 'lumiÃ¨re indirecte vive', '18-25Â°C', 'Sol bien drainÃ©', 'modÃ©rÃ© lorsque le sol en surface est sec ', 'L\'Alocasia, connue sous le nom de plante masque africain, est une plante tropicale de la famille des AracÃ©es. Elle se distingue par ses grandes feuilles brillantes en forme de flÃ¨che, de couleur vert foncÃ© avec des nervures blanches saillantes. Originaire d\'Asie du Sud-Est, elle est cultivÃ©e comme plante d\'intÃ©rieur en raison de sa forme unique. Elle est considÃ©rÃ©e comme toxique si ingÃ©rÃ©e, donc il faut faire attention avec les enfants et les animaux.', 'african.png'),
(4, 'Pothos', ' grimpante ou retombante', ' Il prÃ©fÃ¨re la lumiÃ¨re indirecte mais tolÃ¨re les endroits peu lumineux.', 'Entre 18Â°C et 30Â°C', 'Sol bien drainÃ©', 'Une fois que le sol est sec sur le dessus (environ tous les 7 Ã  10 jours)', 'Le Pothos est une plante dâ€™intÃ©rieur tropicale au feuillage en forme de cÅ“ur, souvent panachÃ© de vert et de jaune, trÃ¨s dÃ©corative, facile Ã  entretenir, idÃ©ale en suspension ou en pot, qui sâ€™adapte bien Ã  la lumiÃ¨re indirecte et purifie lâ€™air ambiant.', 'p.png'),
(5, 'Pothos', ' grimpante ou retombante', ' Il prÃ©fÃ¨re la lumiÃ¨re indirecte mais tolÃ¨re les endroits peu lumineux.', 'Entre 18Â°C et 30Â°C', 'Sol bien drainÃ©', 'Une fois que le sol est sec sur le dessus (environ tous les 7 Ã  10 jours)', 'Le Pothos est une plante dâ€™intÃ©rieur tropicale au feuillage en forme de cÅ“ur, souvent panachÃ© de vert et de jaune, trÃ¨s dÃ©corative, facile Ã  entretenir, idÃ©ale en suspension ou en pot, qui sâ€™adapte bien Ã  la lumiÃ¨re indirecte et purifie lâ€™air ambiant.', 'p.png'),
(6, 'African Mask Plant', ' grimpante ou retombante', ' Il prÃ©fÃ¨re la lumiÃ¨re indirecte mais tolÃ¨re les endroits peu lumineux.', 'Entre 18Â°C et 30Â°C', 'Sol bien drainÃ©', 'Une fois que le sol est sec sur le dessus (environ tous les 7 Ã  10 jours)', 'Le Pothos est une plante dâ€™intÃ©rieur tropicale au feuillage en forme de cÅ“ur, souvent panachÃ© de vert et de jaune, trÃ¨s dÃ©corative, facile Ã  entretenir, idÃ©ale en suspension ou en pot, qui sâ€™adapte bien Ã  la lumiÃ¨re indirecte et purifie lâ€™air ambiant.', 'AFRIKAN.png'),
(7, 'African Mask Plant', ' grimpante ou retombante', ' Il prÃ©fÃ¨re la lumiÃ¨re indirecte mais tolÃ¨re les endroits peu lumineux.', 'Entre 18Â°C et 30Â°C', 'Sol bien drainÃ©', 'Une fois que le sol est sec sur le dessus (environ tous les 7 Ã  10 jours)', 'Le Pothos est une plante dâ€™intÃ©rieur tropicale au feuillage en forme de cÅ“ur, souvent panachÃ© de vert et de jaune, trÃ¨s dÃ©corative, facile Ã  entretenir, idÃ©ale en suspension ou en pot, qui sâ€™adapte bien Ã  la lumiÃ¨re indirecte et purifie lâ€™air ambiant.', 'african.png'),
(9, 'imen', ' grimpante ', ' Il prÃ©fÃ¨re la lumiÃ¨re indirecte mais tolÃ¨re les endroits peu lumineux.', '18-25Â°C', 'Sol argileux', 'imen', 'sjnuhfezuirjkfpaxi,rferfnÃ§rfy,peoifj', '8.jfif');

-- --------------------------------------------------------

--
-- Structure de la table `plants`
--

CREATE TABLE `plants` (
  `id` int(11) NOT NULL,
  `pepiniere_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `plants`
--

INSERT INTO `plants` (`id`, `pepiniere_id`, `name`, `price`, `description`, `image`, `created_at`) VALUES
(3, 5, 'african', 10.00, '', 'african.png', '2025-05-14 09:29:12'),
(4, 5, 'HIBA', 55.00, '', '681fa77fb7705-4.png', '2025-05-14 09:50:48'),
(5, 5, 'african', 66.00, '', 'AFRIKAN.png', '2025-05-14 09:57:54'),
(6, 5, 'YAYA', 77.00, '', 'pp.png', '2025-05-14 10:03:15'),
(10, 6, 'HIBA', 55.00, 'hhhh', '9.jpg', '2025-05-27 21:45:45'),
(11, 7, 'HIBA', 55.00, 'hhhh', '8.jfif', '2025-05-28 11:00:12');

-- --------------------------------------------------------

--
-- Structure de la table `proprietaire`
--

CREATE TABLE `proprietaire` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `proprietaire`
--

INSERT INTO `proprietaire` (`id`, `user_id`, `email`, `password`) VALUES
(4, 12, '', '');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `created_at`) VALUES
(3, 'nailihiba49@gmail.com', '$2y$10$syhkDfE3gU2YQUEHZkDOceX8Biuo7asDrw2jblVMla8ENlxAxnrQa', 'proprietaire', '2025-05-13 20:57:38'),
(4, 'aymen@gmail.com', '$2y$10$CqCpSBPfnyUEbWSeAKodNOc0Q5EeW3Ix6USExQrWu2fx923rX1fja', 'admin', '2025-05-18 09:42:21'),
(5, 'hiya@gmail.com', '$2y$10$BJiOwLuD.f4S4ZAV8LJhj.vU9KUZTlMMgBOAHVMwyD72vNsSDhqJa', 'proprietaire', '2025-05-18 09:43:55'),
(6, 'hibahiba@gmail.com', '$2y$10$2kFbU3vBlQBbFmluZQakQuRwRAnM/5lCkWgjI9spvOb5KlTytH38K', 'proprietaire', '2025-05-24 12:17:03'),
(7, 'rana@gmail.com', '$2y$10$UbwdfhjVyWMvR510Rvku0OFFXkBPQiAxC009eir4NaJ3ZUjEkUsDO', 'proprietaire', '2025-05-28 10:57:54'),
(12, 'nassima@gmail.com', '$2y$10$dCwnjIVnA7bTOpaknrVWk.0l1oVLFTe1kFBlZB.An1DU5aiojNsh2', 'proprietaire', '2025-05-30 10:36:47');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `plant_id` (`plant_id`);

--
-- Index pour la table `pepiniere`
--
ALTER TABLE `pepiniere`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `plantes`
--
ALTER TABLE `plantes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `plants`
--
ALTER TABLE `plants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pepiniere_id` (`pepiniere_id`);

--
-- Index pour la table `proprietaire`
--
ALTER TABLE `proprietaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pepiniere`
--
ALTER TABLE `pepiniere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `plantes`
--
ALTER TABLE `plantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `plants`
--
ALTER TABLE `plants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `proprietaire`
--
ALTER TABLE `proprietaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`plant_id`) REFERENCES `plants` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `pepiniere`
--
ALTER TABLE `pepiniere`
  ADD CONSTRAINT `pepiniere_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `plants`
--
ALTER TABLE `plants`
  ADD CONSTRAINT `plants_ibfk_1` FOREIGN KEY (`pepiniere_id`) REFERENCES `pepiniere` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `proprietaire`
--
ALTER TABLE `proprietaire`
  ADD CONSTRAINT `proprietaire_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
