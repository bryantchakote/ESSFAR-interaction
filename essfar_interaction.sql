-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2023 at 06:41 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `essfar_interaction`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrateurs`
--

CREATE TABLE `administrateurs` (
  `admin_id` tinyint(4) NOT NULL,
  `admin_nom` varchar(50) NOT NULL,
  `admin_prenom` varchar(50) DEFAULT NULL,
  `admin_sexe` varchar(1) NOT NULL,
  `admin_email` varchar(70) NOT NULL,
  `admin_mdp` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrateurs`
--

INSERT INTO `administrateurs` (`admin_id`, `admin_nom`, `admin_prenom`, `admin_sexe`, `admin_email`, `admin_mdp`) VALUES
(1, 'Tatieze', 'Thierry', 'M', 'thierrytatieze@gmail.com', 'thierrytatieze');

-- --------------------------------------------------------

--
-- Table structure for table `appartient`
--

CREATE TABLE `appartient` (
  `UE_id` tinyint(4) NOT NULL,
  `niv_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appartient`
--

INSERT INTO `appartient` (`UE_id`, `niv_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 1),
(5, 2),
(6, 3),
(7, 5),
(7, 6),
(8, 5),
(9, 4),
(10, 4),
(10, 6);

-- --------------------------------------------------------

--
-- Table structure for table `enseignants`
--

CREATE TABLE `enseignants` (
  `ens_id` smallint(6) NOT NULL,
  `ens_nom` varchar(50) NOT NULL,
  `ens_prenom` varchar(50) DEFAULT NULL,
  `ens_sexe` varchar(1) NOT NULL,
  `ens_email` varchar(70) NOT NULL,
  `ens_mdp` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enseignants`
--

INSERT INTO `enseignants` (`ens_id`, `ens_nom`, `ens_prenom`, `ens_sexe`, `ens_email`, `ens_mdp`) VALUES
(1, 'Nkuimi', 'Celestin', 'M', 'celestinnkuimi@gmail.com', 'celestinnkuimi'),
(2, 'Toussile', 'Wilson', 'M', 'wilsontoussile@gmail.com', 'wilsontoussile'),
(3, 'Tegankong', 'David', 'M', 'davidtegankong@gmail.com', 'davidtegankong'),
(4, 'Nguetseng', 'Gabriel', 'M', 'gabrielnguetseng@gmail.com', 'gabrielnguetseng'),
(5, 'Pouna', 'Virginie', 'F', 'virginiepouna@gmail.com', 'virginiepouna'),
(6, 'Fotso', 'Simeon', 'M', 'simeonfotso@gmail.com', 'simeonfotso');

-- --------------------------------------------------------

--
-- Table structure for table `enseigne`
--

CREATE TABLE `enseigne` (
  `ens_id` smallint(6) NOT NULL,
  `UE_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enseigne`
--

INSERT INTO `enseigne` (`ens_id`, `UE_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(2, 2),
(2, 3),
(2, 7),
(2, 8),
(3, 4),
(3, 5),
(3, 6),
(4, 4),
(4, 5),
(4, 6),
(5, 7),
(5, 9),
(5, 10),
(6, 7),
(6, 9),
(6, 10);

-- --------------------------------------------------------

--
-- Table structure for table `etudiants`
--

CREATE TABLE `etudiants` (
  `et_id` smallint(6) NOT NULL,
  `et_matricule` bigint(20) NOT NULL,
  `et_nom` varchar(50) NOT NULL,
  `et_prenom` varchar(50) DEFAULT NULL,
  `et_sexe` varchar(1) NOT NULL,
  `et_email` varchar(70) NOT NULL,
  `et_mdp` varchar(70) NOT NULL,
  `niv_id` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `etudiants`
--

INSERT INTO `etudiants` (`et_id`, `et_matricule`, `et_nom`, `et_prenom`, `et_sexe`, `et_email`, `et_mdp`, `niv_id`) VALUES
(1, 13060219032, 'Tchakote', 'Bryan', 'M', 'bryantchakote@gmail.com', 'bryantchakote', 1),
(2, 2040019031, 'Tatsinkou', 'Leslie', 'F', 'leslietatsinkou@gmail.com', 'leslietatsinkou', 1),
(3, 14050018012, 'Ngnibo', 'Michelle', 'F', 'michellengnibo@gmail.com', 'michellengnibo', 2),
(4, 20060118008, 'Mekie', 'Karl', 'M', 'karlmekie@gmail.com', 'karlmekie', 2),
(5, 23119810020, 'Kamdem', 'Armelle', 'F', 'armellekamdem@gmail.com', 'armellekamdem', 3),
(6, 2019619039, 'Dongmo', 'Paulin', 'M', 'paulindongmo@gmail.com', 'paulindongmo', 3),
(7, 5109818009, 'Meka', 'Vanillie', 'F', 'vanilliemeka@gmail.com', 'vanilliemeka', 4),
(8, 11039718002, 'Dongmo', 'Theophile', 'M', 'theophiledongmo@gmail.com', 'theophiledongmo', 4),
(9, 8079618001, 'Tsafack', 'Pamela', 'F', 'pamelatsafack@gmail.com', 'pamelatsafack', 5),
(10, 28109921112, 'Ngaleu', 'Paul', 'M', 'paulngaleu@gmail.com', 'paulngaleu', 5),
(11, 28049920098, 'Demeze', 'Ariane', 'F', 'arianedemeze@gmail.com', 'arianedemeze', 6),
(12, 22099620073, 'Ngassam', 'Kate', 'M', 'katengassam@gmail.com', 'katengassam', 6);

-- --------------------------------------------------------

--
-- Table structure for table `niveaux`
--

CREATE TABLE `niveaux` (
  `niv_id` tinyint(4) NOT NULL,
  `niv_nom` varchar(50) NOT NULL,
  `niv_alias` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `niveaux`
--

INSERT INTO `niveaux` (`niv_id`, `niv_nom`, `niv_alias`) VALUES
(1, 'Licence 1', 'L1'),
(2, 'Licence 2', 'L2'),
(3, 'Licence 3', 'L3'),
(4, 'Master 1 Actuariat', 'M1 ACT'),
(5, 'Master 1 Statistiques et Big Data', 'M1 SBD'),
(6, 'Master 1 Ingénieurie Financière', 'M1 INF');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `quest_id` int(11) NOT NULL,
  `quest_libelle` text NOT NULL,
  `quest_date` date NOT NULL,
  `quest_heure` time NOT NULL,
  `ans_libelle` text NOT NULL DEFAULT '',
  `ans_date` date DEFAULT NULL,
  `ans_heure` time DEFAULT NULL,
  `et_id` smallint(6) NOT NULL,
  `ens_id` smallint(6) NOT NULL,
  `UE_id` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`quest_id`, `quest_libelle`, `quest_date`, `quest_heure`, `ans_libelle`, `ans_date`, `ans_heure`, `et_id`, `ens_id`, `UE_id`) VALUES
(1, 'Bonjour monsieur, s\'il vous plaît c\'est quoi le nombre d\'éléments du groupe symétrique Sn ?', '2023-02-06', '18:12:03', 'Assurément ce nombre se trouve entre n^(n/2) et ((n+1)/2)^n.\r\n\r\nCherchez un peu et vous trouverez monsieur Tchakote !', '2023-02-06', '18:37:26', 1, 1, 1),
(2, 'S\'il vous plaît y\'a-t-il une différence entre un minorant et un minimum d\'un intervalle ?', '2023-02-06', '18:13:30', '', NULL, NULL, 1, 4, 4),
(3, 'Bonsoir monsieur, nous n\'avons toujours pas reçu les exercices à traiter sur la fiche de TD pouvez-vous nous les envoyer s\'il vous plaît ?', '2023-02-06', '18:14:32', '', NULL, NULL, 1, 3, 4),
(4, 'Pouvez-vous nous envoyer le support du dernier cours svp ? ', '2023-02-06', '18:16:38', 'D\'accord, je le fais tout de suite. Bonne soirée.', '2023-02-06', '18:31:25', 2, 2, 1),
(5, 'Bonjour monsieur, juste pour signaler une possible erreur à la question 4.a de l\'exercie 3. Pouvez-vous regarder de plus près s\'il vous plaît ?', '2023-02-06', '18:17:48', '', NULL, NULL, 2, 2, 1),
(6, 'Bonjour monsieur, s\'il vous plaît y\'a-t-il une différence entre les conditions de triangularisation et de jordanisation d\'une matrice ?', '2023-02-06', '18:19:15', '', NULL, NULL, 3, 2, 2),
(7, 'Bonjour monsieur, svp qu\'appelle-t-on matrice orthogonale ? On en a besoin pour un exercice de la fiche.', '2023-02-06', '18:20:30', 'Bonsoir Karl, une petite recherche Google ne vous tuerait pas !', '2023-02-06', '18:33:18', 4, 2, 2),
(8, 'Bonjour monsieur, aurons-nous une fiche de TD sur les suites de fonctions ?', '2023-02-06', '18:21:36', '', NULL, NULL, 4, 4, 5),
(9, 'Bonsoir monsieur. Juste une petite question s\'il vous plaît, peut-on affirmer qu\'une série dont le terme général tend vers 0 converge ? ', '2023-02-06', '18:22:47', '', NULL, NULL, 4, 4, 5),
(10, 'Bonsoir madame, concernant la régression linéaire, quand parle-t-on homoscédasticité ?', '2023-02-06', '18:24:52', '', NULL, NULL, 12, 5, 7),
(11, 'Bonjour madame, une préoccupation à la question 2 de l\'exercie 3 de la fiche de TD ... vous demandez de considérer a0 = 2.1, a1 = 0.6 et a2 = 1.8, mais ces valeurs ne permettent pas de retrouver le t de Student proposé. D\'autres camarades ont le même problème.', '2023-02-06', '18:28:05', '', NULL, NULL, 12, 5, 7),
(12, 'Bonjour monsieur, une question s\'il vous plaît. Quand devons-nous rendre le projet, et via quel moyen ?', '2023-02-06', '18:29:42', '', NULL, NULL, 12, 2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `ues`
--

CREATE TABLE `ues` (
  `UE_id` tinyint(4) NOT NULL,
  `UE_nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ues`
--

INSERT INTO `ues` (`UE_id`, `UE_nom`) VALUES
(1, 'Algèbre 1'),
(2, 'Algèbre 2'),
(3, 'Algèbre 3'),
(4, 'Analyse 1'),
(5, 'Analyse 2'),
(6, 'Analyse 3'),
(7, 'Econométrie'),
(9, 'Machine Learning'),
(8, 'Mathématiques pour Assurance Vie'),
(10, 'Méthode de Monte-Carlo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrateurs`
--
ALTER TABLE `administrateurs`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `administrateurs_AK` (`admin_email`);

--
-- Indexes for table `appartient`
--
ALTER TABLE `appartient`
  ADD PRIMARY KEY (`UE_id`,`niv_id`),
  ADD KEY `appartient_niveaux_FK` (`niv_id`);

--
-- Indexes for table `enseignants`
--
ALTER TABLE `enseignants`
  ADD PRIMARY KEY (`ens_id`),
  ADD UNIQUE KEY `enseignants_AK` (`ens_email`);

--
-- Indexes for table `enseigne`
--
ALTER TABLE `enseigne`
  ADD PRIMARY KEY (`ens_id`,`UE_id`),
  ADD KEY `enseigne_UEs_FK` (`UE_id`);

--
-- Indexes for table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`et_id`),
  ADD UNIQUE KEY `etudiants_AK_mat` (`et_matricule`),
  ADD UNIQUE KEY `etudiants_AK_mail` (`et_email`),
  ADD KEY `etudiants_niveaux_FK` (`niv_id`);

--
-- Indexes for table `niveaux`
--
ALTER TABLE `niveaux`
  ADD PRIMARY KEY (`niv_id`),
  ADD UNIQUE KEY `niveaux_AK_nom` (`niv_nom`),
  ADD UNIQUE KEY `niveaux_AK_alias` (`niv_alias`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`quest_id`),
  ADD KEY `questions_etudiants_FK` (`et_id`),
  ADD KEY `questions_enseignants_FK` (`ens_id`),
  ADD KEY `questions_UEs_FK` (`UE_id`);

--
-- Indexes for table `ues`
--
ALTER TABLE `ues`
  ADD PRIMARY KEY (`UE_id`),
  ADD UNIQUE KEY `UEs_AK` (`UE_nom`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrateurs`
--
ALTER TABLE `administrateurs`
  MODIFY `admin_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `enseignants`
--
ALTER TABLE `enseignants`
  MODIFY `ens_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `et_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `niveaux`
--
ALTER TABLE `niveaux`
  MODIFY `niv_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `quest_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ues`
--
ALTER TABLE `ues`
  MODIFY `UE_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appartient`
--
ALTER TABLE `appartient`
  ADD CONSTRAINT `appartient_UEs_FK` FOREIGN KEY (`UE_id`) REFERENCES `ues` (`UE_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appartient_niveaux_FK` FOREIGN KEY (`niv_id`) REFERENCES `niveaux` (`niv_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `enseigne`
--
ALTER TABLE `enseigne`
  ADD CONSTRAINT `enseigne_UEs_FK` FOREIGN KEY (`UE_id`) REFERENCES `ues` (`UE_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `enseigne_enseignants_FK` FOREIGN KEY (`ens_id`) REFERENCES `enseignants` (`ens_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `etudiants`
--
ALTER TABLE `etudiants`
  ADD CONSTRAINT `etudiants_niveaux_FK` FOREIGN KEY (`niv_id`) REFERENCES `niveaux` (`niv_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_UEs_FK` FOREIGN KEY (`UE_id`) REFERENCES `ues` (`UE_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `questions_enseignants_FK` FOREIGN KEY (`ens_id`) REFERENCES `enseignants` (`ens_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `questions_etudiants_FK` FOREIGN KEY (`et_id`) REFERENCES `etudiants` (`et_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
