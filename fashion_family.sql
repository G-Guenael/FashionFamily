-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 30, 2026 at 10:39 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fashion_family`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `image_path` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `currency` varchar(10) DEFAULT 'EUR',
  `quantity` int DEFAULT '1',
  `category` varchar(100) DEFAULT NULL,
  `article_condition` enum('new','like_new','good','fair','poor') DEFAULT 'good',
  `status` enum('active','sold','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `user_id`, `title`, `description`, `image_path`, `price`, `currency`, `quantity`, `category`, `article_condition`, `status`, `created_at`, `updated_at`) VALUES
(31, 1, 'T-shirt1', 'Classic Monochrome Tees', './img/Tshirt1.png', 35.00, 'EUR', 3, 'vetements', 'like_new', 'active', '2026-03-28 15:47:22', '2026-03-30 10:07:00'),
(32, 2, 'Chaise ergonomique', 'Chaise de bureau confortable avec support lombaire', '', 120.00, 'EUR', 2, 'Maison', 'good', 'active', '2026-03-28 15:46:21', '2026-03-30 10:07:33'),
(33, 3, 'Vélo de route Trek', 'Vélo carbone très léger, utilisé 1 saison', '', 950.00, 'EUR', 1, 'Sport', 'good', 'active', '2026-03-28 15:45:22', '2026-03-28 15:45:22'),
(34, 1, 'PlayStation 5', 'PS5 édition standard avec 2 manettes', '', 500.00, 'EUR', 1, 'Jeux vidéo', 'like_new', 'active', '2026-03-28 15:44:22', '2026-03-30 10:07:49'),
(35, 6, 'Table en bois massif', 'Grande table à manger en chêne, quelques traces d’usage', '', 300.00, 'EUR', 1, 'Mobilier', 'fair', 'active', '2026-03-28 15:45:22', '2026-03-28 15:45:22'),
(36, 2, 'MacBook Air M1', 'Ordinateur portable Apple très bon état, 8GB RAM', '', 800.00, 'EUR', 1, 'Informatique', 'like_new', 'active', '2026-03-28 15:45:22', '2026-03-28 15:45:22'),
(37, 8, 'Casque Sony WH-1000XM4', 'Casque à réduction de bruit, excellent état', '', 180.00, 'EUR', 1, 'Électronique', 'good', 'active', '2026-03-28 15:45:22', '2026-03-28 15:45:22'),
(38, 3, 'Canapé 3 places', 'Canapé confortable, couleur gris foncé', '', 250.00, 'EUR', 1, 'Mobilier', 'good', 'active', '2026-03-28 15:45:22', '2026-03-28 15:45:22'),
(39, 6, 'Montre connectée Samsung', 'Galaxy Watch en bon état avec chargeur', '', 90.00, 'EUR', 1, 'Électronique', 'good', 'active', '2026-03-28 15:45:22', '2026-03-28 15:45:22'),
(40, 1, 'Clavier mécanique RGB', 'Clavier gaming switches rouges, rétroéclairage RGB', '', 70.00, 'EUR', 1, 'Informatique', 'like_new', 'active', '2026-03-28 15:45:22', '2026-03-28 15:45:22');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `article_id` int DEFAULT NULL,
  `content` text NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `buyer_id` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `article_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `password`, `created_at`) VALUES
(1, 'Paul Gaston', 'kevin.urbain.pro@gmail.com', 'user', 'Keke141291<3', '2026-03-25 16:47:34'),
(2, 'Alice Nevers', 'alice.nevers@gmail.com', 'user', 'Keke141291<3', '2026-03-25 17:51:07'),
(3, 'Camille Peters', 'cam.p@gmail.com', 'user', '$2y$10$Fc9vVaN74./2NT89dNcts.MiimDkGV8cPnTOPUgoq31wXpeRNbDyO', '2026-03-25 17:53:50'),
(6, 'Michael Simon', 'michmich@gmail.com', 'user', '$2y$10$3YvBDlq3oxnd7MEw1f7S8Oe12.Dm7AI3aFAuNpW0b52PUgnn7muiy', '2026-03-25 17:57:01'),
(8, 'Gustave', 'gus@gmail.com', 'user', '$2y$10$7H5MbVxEk6D4380ngjkvAuDONwEWAlOB/lR3SbdQE/hsoCKu5b38e', '2026-03-25 17:58:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `idx_price` (`price`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `idx_messages_sender` (`sender_id`),
  ADD KEY `idx_messages_receiver` (`receiver_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_orders_buyer` (`buyer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `article_id` (`article_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
