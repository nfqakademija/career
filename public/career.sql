-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2019 at 10:06 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `career`
--

-- --------------------------------------------------------

--
-- Table structure for table `competence`
--

CREATE TABLE `competence` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_applicable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `competence`
--

INSERT INTO `competence` (`id`, `title`, `is_applicable`) VALUES
(1, 'Experience', 1),
(2, 'Technical skills', 1),
(3, 'Responsibilities', 1),
(4, 'English', 1),
(5, 'Other competencies', 1);

-- --------------------------------------------------------

--
-- Table structure for table `criteria`
--

CREATE TABLE `criteria` (
  `id` int(11) NOT NULL,
  `fk_competence_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_applicable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`id`, `fk_competence_id`, `title`, `is_applicable`) VALUES
(1, 1, 'Successfully released product / project to production', 1),
(2, 2, 'Can use PHP, OOP', 1),
(3, 2, 'Can use relational database', 1),
(4, 2, 'Can use PDO or other database abstraction', 1),
(5, 2, 'Can use a modern PHP framework (Symfony)', 1),
(6, 2, 'Can use UNIX', 1),
(7, 2, 'Can use version control system (GIT)', 1),
(8, 2, 'Can use NoSQL database', 1),
(9, 2, 'Can use JavaScript', 1),
(10, 2, 'Can refactor code', 1),
(11, 2, 'Can automate development process (CI/CD)', 1),
(12, 2, 'Can write tests', 1),
(13, 2, 'Has knowledge of security', 1),
(14, 2, 'Has knowledge of API standards', 1),
(15, 2, 'Has knowledge of design patterns, SOLID', 1),
(16, 2, 'Has knowledge of server infrastructure', 1),
(17, 2, 'Has knowledge of frontend', 1),
(18, 3, 'Can build features', 1),
(19, 3, 'Can fix bugs', 1),
(20, 3, 'Can demonstrate ownership', 1),
(21, 3, 'Features testing', 1),
(22, 3, 'Reviewing code', 1),
(23, 3, 'Asking and giving help', 1),
(24, 3, 'Receiving and giving feedback', 1),
(25, 3, 'Presenting technologies/case studies', 1),
(26, 3, 'Mentoring', 1),
(27, 3, 'Following internal processess', 1),
(28, 3, 'Showing positive attitude towards others', 1),
(29, 3, 'Writing unit, integration and acceptance tests', 1),
(30, 4, 'Can communicate in writing', 1),
(31, 4, 'Is able to understand others', 1),
(32, 4, 'Speaks in full sentences', 1),
(33, 4, 'Is able to discuss and argue his results', 1),
(34, 4, 'Can present his/her ideas and defend them', 1),
(35, 4, 'Can manage discussions and/or conflicts', 1),
(36, 5, 'Dealing with Ambiguity', 1),
(37, 5, 'Customer Focus', 1),
(38, 5, 'Planning', 1),
(39, 5, 'Problem Solving', 1),
(40, 5, 'Drive for Results', 1),
(41, 5, 'Timely Decision Making', 1);

-- --------------------------------------------------------

--
-- Table structure for table `criteria_choice`
--

CREATE TABLE `criteria_choice` (
  `id` int(11) NOT NULL,
  `fk_criteria_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_applicable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `criteria_choice`
--

INSERT INTO `criteria_choice` (`id`, `fk_criteria_id`, `title`, `is_applicable`) VALUES
(1, 1, 'None', 1),
(2, 1, 'At least one', 1),
(3, 1, 'More than one', 1),
(4, 2, 'Unfamiliar', 1),
(5, 2, 'Basic level', 1),
(6, 2, 'Intermediate level', 1),
(7, 2, 'Expert level', 1),
(8, 3, 'Unfamiliar', 1),
(9, 3, 'Basic level', 1),
(10, 3, 'Intermediate (design/optimise)', 1),
(11, 3, 'Expert (design/optimise/refactor)', 1),
(12, 4, 'Unfamiliar', 1),
(13, 4, 'Basic level', 1),
(14, 4, 'Intermediate level', 1),
(15, 4, 'Expert level', 1),
(16, 5, 'Unfamiliar', 1),
(17, 5, 'Basic level', 1),
(18, 5, 'Intermediate level', 1),
(19, 5, 'Expert level', 1),
(20, 6, 'Unfamiliar', 1),
(21, 6, 'Basic level', 1),
(22, 6, 'Intermediate level', 1),
(23, 6, 'Expert level', 1),
(24, 7, 'Unfamiliar', 1),
(25, 7, 'Basic level', 1),
(26, 7, 'Intermediate level', 1),
(27, 7, 'Expert level', 1),
(28, 8, 'Unfamiliar', 1),
(29, 8, 'Basic level', 1),
(30, 8, 'Intermediate', 1),
(31, 8, 'Expert level', 1),
(32, 9, 'Unfamiliar', 1),
(33, 9, 'Basic level', 1),
(34, 9, 'Intermediate level', 1),
(35, 9, 'Expert level', 1),
(36, 10, 'Unfamiliar', 1),
(37, 10, 'Existing code', 1),
(38, 10, 'Big parts of existing code', 1),
(39, 11, 'Unfamiliar', 1),
(40, 11, 'Can setup CI workflow', 1),
(41, 11, 'Can automate development process (CI/CD)', 1),
(42, 12, 'Unfamiliar', 1),
(43, 12, 'Unit tests', 1),
(44, 12, 'Unit/functional/integration tests', 1),
(45, 12, 'Can write/refactor and optimise unit/functional/integration/acceptance/stress tests', 1),
(46, 13, 'Unfamiliar', 1),
(47, 13, 'Basic level', 1),
(48, 13, 'Intermediate level', 1),
(49, 13, 'Expert level', 1),
(50, 14, 'Unfamiliar', 1),
(51, 14, 'Basic level', 1),
(52, 14, 'Can implement APIs/has knowledge of API standards', 1),
(53, 15, 'Unfamiliar', 1),
(54, 15, 'Basic level', 1),
(55, 15, 'Can use design patterns', 1),
(56, 16, 'Unfamiliar', 1),
(57, 16, 'Basic level', 1),
(58, 16, 'Intermediate level', 1),
(59, 16, 'Expert level', 1),
(60, 17, 'Unfamiliar', 1),
(61, 17, 'Basic level', 1),
(62, 17, 'Intermediate level', 1),
(63, 17, 'Expert level', 1),
(64, 18, 'Unfamiliar', 1),
(65, 18, 'Under supervision', 1),
(66, 18, 'Without supervision', 1),
(67, 18, 'Can build big critical features', 1),
(68, 19, 'Unfamiliar', 1),
(69, 19, 'Simple bugs', 1),
(70, 19, 'Harder/more advanced bugs', 1),
(71, 19, 'Advanced critical bugs', 1),
(72, 20, 'Can\'t demonstrate ownership', 1),
(73, 20, 'Over a specific task', 1),
(74, 20, 'Over a specific project', 1),
(75, 20, 'Over a specific tech. stack/project in the team', 1),
(76, 21, 'Do not test features', 1),
(77, 21, 'Manually test features', 1),
(78, 21, 'Manually test features and help others finding edge cases', 1),
(79, 22, 'Do not provide his code for review', 1),
(80, 22, 'Provide his code for review', 1),
(81, 22, 'Provides his code for review and review the code of others', 1),
(82, 23, 'Does not ask for help when needed', 1),
(83, 23, 'Asks for help when needed', 1),
(84, 23, 'Asks for help and actively offers help', 1),
(85, 24, 'Does not listen to given feedback', 1),
(86, 24, 'Listens to given feedback', 1),
(87, 24, 'Listens given feedback and gives feedback to others', 1),
(88, 25, 'No', 1),
(89, 25, 'To team members', 1),
(90, 25, 'To team and NFQ', 1),
(91, 26, 'No', 1),
(92, 26, 'One junior colleague', 1),
(93, 26, 'Two junior colleagues', 1),
(94, 26, 'More than two colleagues', 1),
(95, 27, 'Yes', 1),
(96, 27, 'No', 1),
(97, 28, 'No', 1),
(98, 28, 'Yes', 1),
(99, 29, 'No', 1),
(100, 29, 'Yes', 1),
(101, 30, 'No', 1),
(102, 30, 'Yes', 1),
(103, 31, 'No', 1),
(104, 31, 'Yes', 1),
(105, 32, 'No', 1),
(106, 32, 'Yes', 1),
(107, 33, 'No', 1),
(108, 33, 'Yes', 1),
(109, 34, 'No', 1),
(110, 34, 'Yes', 1),
(111, 35, 'No', 1),
(112, 35, 'Yes', 1),
(113, 36, 'Less skilled', 1),
(114, 36, 'Has this competence', 1),
(115, 36, 'Over engineered', 1),
(116, 37, 'Less skilled', 1),
(117, 37, 'Has this competence', 1),
(118, 37, 'Talented', 1),
(119, 37, 'Over engineered', 1),
(120, 38, 'Less skilled', 1),
(121, 38, 'Has this competence', 1),
(122, 38, 'Talented', 1),
(123, 38, 'Over engineered', 1),
(124, 39, 'Less skilled', 1),
(125, 39, 'Has this competence', 0),
(126, 39, 'Talented', 1),
(127, 39, 'Over engineered', 1),
(128, 40, 'Less skilled', 1),
(129, 40, 'Has this competence', 1),
(130, 40, 'Talented', 1),
(131, 40, 'Over engineered', 1),
(132, 41, 'Less skilled', 1),
(133, 41, 'Has this competence', 1),
(134, 41, 'Talented', 1),
(135, 41, 'Over engineered', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `competence`
--
ALTER TABLE `competence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criteria`
--
ALTER TABLE `criteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_competence_id` (`fk_competence_id`);

--
-- Indexes for table `criteria_choice`
--
ALTER TABLE `criteria_choice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_criteria_id` (`fk_criteria_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `competence`
--
ALTER TABLE `competence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `criteria`
--
ALTER TABLE `criteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `criteria_choice`
--
ALTER TABLE `criteria_choice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `criteria`
--
ALTER TABLE `criteria`
  ADD CONSTRAINT `criteria_ibfk_1` FOREIGN KEY (`fk_competence_id`) REFERENCES `competence` (`id`);

--
-- Constraints for table `criteria_choice`
--
ALTER TABLE `criteria_choice`
  ADD CONSTRAINT `criteria_choice_ibfk_1` FOREIGN KEY (`fk_criteria_id`) REFERENCES `criteria` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;