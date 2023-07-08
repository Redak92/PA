-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 08, 2023 at 06:38 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projet_annuel`
--

-- --------------------------------------------------------

--
-- Table structure for table `event_post`
--

CREATE TABLE `event_post` (
  `id_event` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `corps_de_texte` varchar(1000) NOT NULL,
  `date_event` datetime DEFAULT NULL,
  `date_post` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event_post`
--

INSERT INTO `event_post` (`id_event`, `titre`, `categorie`, `corps_de_texte`, `date_event`, `date_post`) VALUES
(1, 'Séance de coaching', 'Cours de cuisine', 'lorel ipsum\r\n', '2023-07-04 00:00:00', '2023-07-08 09:21:11'),
(6, 'oooo', 'coaching', 'ooo', NULL, '2023-07-08 09:21:11'),
(7, 'oooo', 'coaching', 'ooo', NULL, '2023-07-08 09:21:11'),
(8, 'tester date', 'coaching', 'tester ', '2023-07-14 00:00:00', '2023-07-08 09:23:16'),
(9, 'tester date', 'coaching', 'tester ', '2023-07-14 00:00:00', '2023-07-08 09:25:05'),
(10, 'teste heure', 'coaching', 'tester heure', '2023-07-08 23:00:00', '2023-07-08 09:30:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event_post`
--
ALTER TABLE `event_post`
  ADD PRIMARY KEY (`id_event`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event_post`
--
ALTER TABLE `event_post`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
