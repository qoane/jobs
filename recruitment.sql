-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2024 at 07:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recruitment`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `cover_letter` text DEFAULT NULL,
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cv` varchar(255) DEFAULT NULL,
  `transcript` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `job_id`, `user_id`, `cover_letter`, `applied_at`, `cv`, `transcript`) VALUES
(2, 2, 3, 'I am a good driver', '2024-09-19 16:03:44', '1726761824_Document.docx', ''),
(3, 2, 5, 'I am a good driver', '2024-09-19 16:05:55', '1726761955_Qoane_CV.pdf', ''),
(4, 3, 7, 'Nhireng', '2024-09-19 18:02:15', '1726768935_poe.pdf', '');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `required_documents` varchar(255) DEFAULT NULL,
  `job_type` varchar(20) DEFAULT NULL,
  `employment_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `user_id`, `title`, `description`, `location`, `created_at`, `required_documents`, `job_type`, `employment_type`) VALUES
(2, 4, 'Driver', 'Code 14 Driver', 'Maseru', '2024-09-19 16:02:48', 'CV', 'On-site', NULL),
(3, 6, 'Chef', 'To cook meat', 'Naledi', '2024-09-19 18:00:37', 'CV', 'On-site', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `role` enum('job_seeker','job_poster') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `experience` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `google_id`, `role`, `created_at`, `phone`, `address`, `skills`, `experience`) VALUES
(3, 'Qoane', 'sqoane@gmail.com', '$2y$10$f6J/bYvaLa2PW6onkJsLxe159rTZuJUeNGKnWroMypebC4I9SkcDq', NULL, 'job_seeker', '2024-09-19 15:59:58', '57661097', 'Naledi', 'Php, c#', 'Work'),
(4, 'Bee', 'beeonlinecc@gmail.com', '$2y$10$FM2r8Gce4dYiPeKpKWd5zeWZWicoLbsUqlypWz26a4ABinAP8iGpq', NULL, 'job_poster', '2024-09-19 16:00:55', '62131311', 'Koalabata', '', ''),
(5, 'Keneiloe Thinyane', 'thinyaneck@gmail.com', '$2y$10$3Ndgu1zm0FWDPET4PWNKzu5AcAoSL1kIRDntH.kZ0gOrq9gV4qsye', NULL, 'job_seeker', '2024-09-19 16:05:25', '58028385', 'Koalabata', 'Sales, Marketing, Business Analysis', 'Metropolitan'),
(6, 'Doregos', 'thabindabambi@gmail.com', '$2y$10$Ylr4Q/PTE3DepNHIHoynSuOcNNz5a.c3E6zVWZ/.mapEyF7j/A.VG', NULL, 'job_poster', '2024-09-19 17:59:55', '59404743', 'Naledi Center', '', ''),
(7, 'Motsoto Mothopeng', 'motsotomothopeng15@gmail.com', '$2y$10$VMD21ToUuOKclr6T9Iww9OIf.q6Ba0l5Ypq2vRTh2rz6UqQmwzZZG', NULL, 'job_seeker', '2024-09-19 18:01:45', '53976145', 'Naledi', 'Waiting, Cooking, Customer service', 'BeeOnline'),
(8, 'Thato', 'thato@gmail.com', '$2y$10$iFNVaimDlPml9BUsX7MhZ.bRNK3WNVaiM6qTPLeU1y3c/cQP13Mba', NULL, 'job_seeker', '2024-09-24 11:18:28', '56347865', 'Koalabata', 'A,B,C,D', '0-2'),
(9, 'Dredd', 'dredd@gmail.com', '$2y$10$KJPQhaQvJTfzNgz3k177PuePJ4/ETNjveCM7e2NhkGMsL3s7ZGpVi', NULL, 'job_poster', '2024-09-24 11:22:32', '56248166', 'Sekamaneng', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`),
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
