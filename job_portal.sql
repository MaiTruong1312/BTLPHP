-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2025 at 03:09 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidate_education`
--

CREATE TABLE `candidate_education` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_profile_id` bigint(20) UNSIGNED NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `degree` varchar(255) DEFAULT NULL,
  `field_of_study` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidate_education`
--

INSERT INTO `candidate_education` (`id`, `candidate_profile_id`, `school_name`, `degree`, `field_of_study`, `start_date`, `end_date`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Banking Academy', '2027', 'Tôi đã phải trải qua nhiều thứ mà không ai biết :)))', '2023-11-25', '2025-11-25', NULL, '2025-11-24 17:45:15', '2025-11-24 17:45:15');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_experiences`
--

CREATE TABLE `candidate_experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `candidate_profile_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidate_experiences`
--

INSERT INTO `candidate_experiences` (`id`, `candidate_profile_id`, `company_name`, `position`, `start_date`, `end_date`, `is_current`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'banking academy', 'Back End', '2020-12-31', '2021-12-12', 0, NULL, '2025-11-23 11:21:14', '2025-11-24 17:40:07');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_profiles`
--

CREATE TABLE `candidate_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `cv_path` varchar(255) DEFAULT NULL,
  `is_searchable` tinyint(1) NOT NULL DEFAULT 0,
  `years_of_experience` int(11) DEFAULT NULL,
  `expected_salary_min` int(11) DEFAULT NULL,
  `expected_salary_max` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidate_profiles`
--

INSERT INTO `candidate_profiles` (`id`, `user_id`, `phone`, `date_of_birth`, `gender`, `address`, `summary`, `cv_path`, `is_searchable`, `years_of_experience`, `expected_salary_min`, `expected_salary_max`, `created_at`, `updated_at`) VALUES
(1, 3, '0364335411', '2025-11-25', 'male', '12 chua boc', 'Experienced software developer with 5+ years in web development.', NULL, 0, 5, 3000000, 50000000, '2025-11-21 09:01:55', '2025-11-24 17:38:42'),
(2, 5, '0364335411', '2025-11-25', NULL, '12 chua boc', NULL, NULL, 0, 5, 3000000, 50000000, '2025-11-29 23:35:09', '2025-11-29 23:35:46'),
(3, 8, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2025-12-05 09:19:34', '2025-12-05 09:19:34');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_skill`
--

CREATE TABLE `candidate_skill` (
  `candidate_profile_id` bigint(20) UNSIGNED NOT NULL,
  `skill_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `candidate_skill`
--

INSERT INTO `candidate_skill` (`candidate_profile_id`, `skill_id`) VALUES
(1, 1),
(1, 3),
(1, 11),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `job_id`, `user_id`, `parent_id`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, 3, NULL, 'Job này rất hay nha', '2025-11-27 21:57:26', '2025-11-27 21:57:26'),
(2, 2, 3, NULL, 'React Hayyy nè', '2025-11-27 22:50:32', '2025-11-27 22:50:32'),
(3, 1, 2, 1, 'Bạn muốn ứng tuyển không?', '2025-11-27 23:05:18', '2025-11-27 23:05:18'),
(4, 1, 2, 1, 'Oke', '2025-11-27 23:17:34', '2025-11-27 23:17:34'),
(5, 1, 2, 1, 'hehe', '2025-11-27 23:21:04', '2025-11-27 23:21:04'),
(6, 7, 4, NULL, 'Mại dô mại dô', '2025-11-28 09:14:03', '2025-11-28 09:14:03'),
(7, 2, 5, 2, 'Thanks bạn', '2025-11-30 01:57:18', '2025-11-30 01:57:18'),
(8, 8, 3, NULL, 'Hi', '2025-12-09 05:11:52', '2025-12-09 05:11:52'),
(9, 8, 2, 8, 'Hi', '2025-12-09 06:14:45', '2025-12-09 06:14:45');

-- --------------------------------------------------------

--
-- Table structure for table `comment_likes`
--

CREATE TABLE `comment_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `user_id`, `name`, `subject`, `body`, `type`, `created_at`, `updated_at`) VALUES
(1, 2, 'Phỏng vấn 1', 'Lịch hẹn phỏng vấn', 'Bạn đã được chúng tôi ...', 'interview', '2025-11-30 01:13:19', '2025-11-30 01:13:19');

-- --------------------------------------------------------

--
-- Table structure for table `employer_profiles`
--

CREATE TABLE `employer_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_slug` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `company_size` enum('1-10','11-50','51-200','201-500','501-1000','1000+') DEFAULT NULL,
  `about` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employer_profiles`
--

INSERT INTO `employer_profiles` (`id`, `user_id`, `company_name`, `company_slug`, `logo`, `website`, `phone`, `address`, `company_size`, `about`, `created_at`, `updated_at`) VALUES
(1, 2, 'Tech Solutions Inc.', 'tech-solutions-inc', NULL, NULL, NULL, NULL, '51-200', 'A leading technology company providing innovative solutions.', '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(2, 4, 'banking academy', 'banking-academy', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-28 09:10:15', '2025-11-28 09:10:15'),
(3, 6, 'BanKing Lion', 'banking-lion', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-03 02:43:43', '2025-12-03 02:43:43'),
(4, 7, 'Job Portal', 'job-portal', NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-05 04:56:10', '2025-12-05 04:56:10');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `employer_profile_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `location_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `description` longtext NOT NULL,
  `requirements` longtext DEFAULT NULL,
  `salary_min` int(11) DEFAULT NULL,
  `salary_max` int(11) DEFAULT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'VND',
  `salary_type` enum('month','year','hour','negotiable') NOT NULL DEFAULT 'month',
  `job_type` enum('full_time','part_time','internship','freelance','remote') NOT NULL DEFAULT 'full_time',
  `experience_level` enum('junior','mid','senior','lead') DEFAULT NULL,
  `is_remote` tinyint(1) NOT NULL DEFAULT 0,
  `vacancies` int(11) NOT NULL DEFAULT 1,
  `deadline` date DEFAULT NULL,
  `status` enum('draft','published','closed','pending_approval','rejected') NOT NULL DEFAULT 'pending_approval',
  `views_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `user_id`, `employer_profile_id`, `category_id`, `location_id`, `title`, `slug`, `short_description`, `description`, `requirements`, `salary_min`, `salary_max`, `currency`, `salary_type`, `job_type`, `experience_level`, `is_remote`, `vacancies`, `deadline`, `status`, `views_count`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 6, 2, 'Senior PHP Developer', 'senior-php-developer-1763740915-0', 'We are looking for an experienced professional to join our team.', 'This is a detailed job description. We are seeking a talented individual who can contribute to our team and help us achieve our goals. The ideal candidate should have relevant experience and a passion for excellence.', 'Bachelor degree in related field. Minimum 2 years of experience. Strong communication skills.', 10000000, 20000000, 'VND', 'month', 'full_time', 'senior', 1, 2, NULL, 'published', 49, '2025-11-21 09:01:55', '2025-12-01 07:48:06'),
(2, 2, 1, 2, 4, 'Frontend Developer (React)', 'frontend-developer-react-1763740915-1', 'We are looking for an experienced professional to join our team.', 'This is a detailed job description. We are seeking a talented individual who can contribute to our team and help us achieve our goals. The ideal candidate should have relevant experience and a passion for excellence.', 'Bachelor degree in related field. Minimum 2 years of experience. Strong communication skills.', 12000000, 23000000, 'VND', 'month', 'remote', 'senior', 1, 1, NULL, 'published', 43, '2025-11-21 09:01:55', '2025-12-01 23:36:29'),
(3, 2, 1, 6, 1, 'Full Stack Developer', 'full-stack-developer-1763740915-2', 'We are looking for an experienced professional to join our team.', 'This is a detailed job description. We are seeking a talented individual who can contribute to our team and help us achieve our goals. The ideal candidate should have relevant experience and a passion for excellence.', 'Bachelor degree in related field. Minimum 2 years of experience. Strong communication skills.', 14000000, 26000000, 'VND', 'month', 'full_time', 'senior', 0, 3, NULL, 'published', 21, '2025-11-21 09:01:55', '2025-12-07 08:54:37'),
(4, 2, 1, 2, 1, 'Marketing Manager', 'marketing-manager-1763740915-3', 'We are looking for an experienced professional to join our team.', 'This is a detailed job description. We are seeking a talented individual who can contribute to our team and help us achieve our goals. The ideal candidate should have relevant experience and a passion for excellence.', 'Bachelor degree in related field. Minimum 2 years of experience. Strong communication skills.', 16000000, 29000000, 'VND', 'month', 'full_time', 'junior', 0, 3, NULL, 'published', 8, '2025-11-21 09:01:55', '2025-12-01 07:49:05'),
(5, 2, 1, 1, 3, 'Sales Executive', 'sales-executive-1763740915-4', 'We are looking for an experienced professional to join our team.', 'This is a detailed job description. We are seeking a talented individual who can contribute to our team and help us achieve our goals. The ideal candidate should have relevant experience and a passion for excellence.', 'Bachelor degree in related field. Minimum 2 years of experience. Strong communication skills.', 18000000, 32000000, 'VND', 'month', 'remote', 'senior', 1, 2, NULL, 'published', 4, '2025-11-21 09:01:55', '2025-11-30 02:12:56'),
(6, 2, 1, 1, 1, 'Lập trình PHP', 'lap-trinh-php-1764039828', 'Thành thạo PHP', 'a', 'a', 30000000, 50000000, 'VND', 'month', 'full_time', NULL, 0, 1, '2025-11-27', 'published', 8, '2025-11-24 20:03:48', '2025-12-03 02:04:27'),
(7, 4, 2, 1, 2, 'Lập trình Java', 'lap-trinh-java-1764346429', 'Sử dụng thành thạo Java', 'Code được các dự án java lớn cùng với team hoàn thiện các chương trình', NULL, 5000000, 15000000, 'VND', 'month', 'internship', 'mid', 0, 2, '2025-12-06', 'published', 14, '2025-11-28 09:13:49', '2025-12-01 08:59:30'),
(8, 2, 1, 1, 2, 'Tuyển cộng tác viên React', 'tuyen-cong-tac-vien-react-1764752855', 'Công việc mà chúng tôi đang cần', 'Chạy deadline vui vẻ', 'Thành thạo các ngôn ngữ liên quan', 10000000, 30000000, 'VND', 'month', 'remote', 'mid', 0, 2, '2025-12-31', 'published', 9, '2025-12-03 02:07:35', '2025-12-09 06:14:46'),
(11, 2, 1, 1, 2, 'Tuyển Intern PHP', 'tuyen-intern-php-1765284111', 'Công việc mà chúng tôi đang cần', 'Giới thiệu công việc:..............................', 'Yêu cầu về công việc:,....................................', 10000000, 30000000, 'VND', 'month', 'internship', 'junior', 0, 4, '2025-12-31', 'published', 0, '2025-12-09 05:41:51', '2025-12-09 05:45:53');

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `candidate_profile_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cover_letter` longtext DEFAULT NULL,
  `cv_path` varchar(255) DEFAULT NULL,
  `status` enum('applied','reviewing','interview','offered','rejected','withdrawn') NOT NULL DEFAULT 'applied',
  `rejection_reason` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_applications`
--

INSERT INTO `job_applications` (`id`, `job_id`, `user_id`, `candidate_profile_id`, `cover_letter`, `cv_path`, `status`, `rejection_reason`, `notes`, `applied_at`, `updated_at`, `created_at`) VALUES
(3, 2, 3, 1, 'Tôi muốn ứng tuyển', 'cvs/lTzUobTngx8jU1gycTjKzLUdlbHJK0WdZK3lsGnE.pdf', 'rejected', NULL, NULL, '2025-11-30 03:36:08', NULL, '2025-11-30 03:36:08'),
(4, 7, 3, 1, 'Tôi muốn ứng tuyển', 'cvs/mHo0O5arNTZflmZLm9HbCmDDEiGD6NHdiEW7C9cm.pdf', 'applied', NULL, NULL, '2025-11-30 05:32:56', NULL, '2025-11-30 05:32:56'),
(5, 5, 3, 1, 'Tôi muốn ứng tuyển', 'cvs/L9lje3q1AML1tG8U7E0jdHigojF6MTHxvgsgmrtC.pdf', 'interview', NULL, NULL, '2025-11-30 05:35:51', NULL, '2025-11-30 05:35:51'),
(6, 7, 5, 2, 'Heheeeee', 'cvs/zCTHseMKBK4tZQFnW0actm1gFxQsZOWjIC78Uh23.pdf', 'applied', NULL, NULL, '2025-11-30 06:36:30', NULL, '2025-11-30 06:36:30'),
(7, 3, 5, 2, 'Tôi muốn ứng tuyển', 'cvs/0T40ANjzNULfq7AMnK9drkzCIfbUxZeCglMnSqgv.pdf', 'interview', NULL, 'Có yếu tố tốt', '2025-11-30 06:38:32', NULL, '2025-11-30 06:38:32'),
(8, 1, 3, 1, 'Tôi muốn ứng tuyển', 'cvs/ZqD2UkoEwY6QBwqZTqS3lYuEUYVzB6ygnd5BU1wG.pdf', 'interview', NULL, NULL, '2025-11-30 08:39:31', NULL, '2025-11-30 08:39:31'),
(9, 2, 5, 2, 'Tôi muốn ứng tuyển', NULL, 'interview', NULL, NULL, '2025-11-30 08:57:36', NULL, '2025-11-30 08:57:36'),
(10, 4, 3, 1, 'Hú Hú', 'cvs/dGnY4aAJo17dzG6V9ZJC9jY3FXtYnp4U130N8Xey.pdf', 'interview', NULL, NULL, '2025-11-30 09:13:12', NULL, '2025-11-30 09:13:12'),
(11, 8, 3, 1, 'Tôi muốn ứng tuyển', 'cvs/oy0j1uNRbsad3i8duTs1jAjpjKDsfCwPUwnjPXxQ.pdf', 'applied', NULL, NULL, '2025-12-09 12:12:17', NULL, '2025-12-09 12:12:17');

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_categories`
--

CREATE TABLE `job_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_categories`
--

INSERT INTO `job_categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Information Technology', 'information-technology', NULL, '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(2, 'Marketing', 'marketing', NULL, '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(3, 'Sales', 'sales', NULL, '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(4, 'Human Resources', 'human-resources', NULL, '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(5, 'Finance', 'finance', NULL, '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(6, 'Design', 'design', NULL, '2025-11-21 09:01:55', '2025-11-21 09:01:55');

-- --------------------------------------------------------

--
-- Table structure for table `job_locations`
--

CREATE TABLE `job_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL DEFAULT 'Vietnam',
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_locations`
--

INSERT INTO `job_locations` (`id`, `city`, `country`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Ho Chi Minh City', 'Vietnam', 'ho-chi-minh-city', '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(2, 'Hanoi', 'Vietnam', 'hanoi', '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(3, 'Da Nang', 'Vietnam', 'da-nang', '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(4, 'Can Tho', 'Vietnam', 'can-tho', '2025-11-21 09:01:55', '2025-11-21 09:01:55');

-- --------------------------------------------------------

--
-- Table structure for table `job_skill`
--

CREATE TABLE `job_skill` (
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `skill_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_skill`
--

INSERT INTO `job_skill` (`job_id`, `skill_id`) VALUES
(1, 1),
(1, 4),
(1, 8),
(2, 6),
(2, 7),
(2, 9),
(3, 2),
(3, 3),
(3, 8),
(4, 4),
(4, 6),
(4, 10),
(5, 1),
(5, 7),
(5, 8),
(6, 1),
(6, 5),
(7, 3),
(7, 7),
(8, 4),
(11, 1),
(11, 2),
(11, 6);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000003_create_personal_access_tokens_table', 1),
(5, '2024_01_01_000004_create_job_categories_table', 1),
(6, '2024_01_01_000005_create_job_locations_table', 1),
(7, '2024_01_01_000006_create_skills_table', 1),
(8, '2024_01_01_000007_create_candidate_profiles_table', 1),
(9, '2024_01_01_000008_create_employer_profiles_table', 1),
(10, '2024_01_01_000009_create_job_postings_table', 1),
(11, '2024_01_01_000010_create_job_skill_table', 1),
(12, '2024_01_01_000011_create_job_applications_table', 1),
(13, '2024_01_01_000012_create_saved_jobs_table', 1),
(14, '2024_01_01_000013_create_candidate_experiences_table', 1),
(15, '2024_01_01_000014_create_candidate_educations_table', 1),
(16, '2024_01_01_000015_create_candidate_skill_table', 1),
(17, '2025_11_21_065141_add_role_and_avatar_to_users_table', 1),
(18, '2025_11_25_034456_create_posts_table', 2),
(19, '2025_11_26_065855_add_image_to_posts_table', 3),
(20, '2025_11_28_044356_create_comments_table', 4),
(21, '2025_11_28_054439_create_comment_likes_table', 5),
(22, '2025_11_28_143343_create_notifications_table', 6),
(23, '2025_11_28_180000_add_approval_status_to_jobs_table', 7),
(24, '2025_11_30_043858_add_rejection_reason_to_job_applications_table', 8),
(25, '2025_11_30_100000_create_email_templates_table', 9),
(26, '2025_11_30_082401_add_notes_to_job_applications_table', 10),
(27, '2025_12_02_113952_add_is_searchable_to_candidate_profiles_table', 11),
(28, '2025_12_02_114136_create_plans_table', 12),
(29, '2025_12_02_114136_create_subscriptions_table', 13),
(30, '2025_12_02_114137_create_subscriptions_table', 14);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('14dbf70d-a0dd-4d8d-86b4-75d21bd83774', 'App\\Notifications\\NewApplicantNotification', 'App\\Models\\User', 2, '{\"applicant_id\":3,\"applicant_name\":\"Mai Truong\",\"job_id\":4,\"job_title\":\"Marketing Manager\",\"message\":\"<strong>Mai Truong<\\/strong> \\u0111\\u00e3 \\u1ee9ng tuy\\u1ec3n v\\u00e0o v\\u1ecb tr\\u00ed <strong>Marketing Manager<\\/strong>.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/jobs\\/4\\/applications\"}', '2025-11-30 02:13:33', '2025-11-30 02:13:12', '2025-11-30 02:13:33'),
('151b4d7b-1caa-4aec-99e9-50c133e04ecd', 'App\\Notifications\\ApplicationStatusUpdated', 'App\\Models\\User', 3, '{\"job_id\":4,\"job_title\":\"Marketing Manager\",\"status\":\"interview\",\"message\":\"H\\u1ed3 s\\u01a1 c\\u1ee7a b\\u1ea1n cho v\\u1ecb tr\\u00ed <strong>Marketing Manager<\\/strong> \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c c\\u1eadp nh\\u1eadt tr\\u1ea1ng th\\u00e1i th\\u00e0nh: <strong>interview<\\/strong>.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/jobs\\/marketing-manager-1763740915-3\"}', NULL, '2025-12-01 23:31:01', '2025-12-01 23:31:01'),
('6266496d-b86c-42a1-a7c5-8d78f48c5c93', 'App\\Notifications\\ApplicationStatusUpdated', 'App\\Models\\User', 3, '{\"job_id\":1,\"job_title\":\"Senior PHP Developer\",\"status\":\"interview\",\"message\":\"H\\u1ed3 s\\u01a1 c\\u1ee7a b\\u1ea1n cho v\\u1ecb tr\\u00ed <strong>Senior PHP Developer<\\/strong> \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c c\\u1eadp nh\\u1eadt tr\\u1ea1ng th\\u00e1i th\\u00e0nh: <strong>interview<\\/strong>.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/jobs\\/senior-php-developer-1763740915-0\"}', '2025-11-30 02:11:24', '2025-11-30 02:10:48', '2025-11-30 02:11:24'),
('70947631-92e9-41cf-b743-1687b90dbafa', 'App\\Notifications\\NewApplicantNotification', 'App\\Models\\User', 2, '{\"applicant_id\":3,\"applicant_name\":\"Mai Truong\",\"job_id\":8,\"job_title\":\"Tuy\\u1ec3n c\\u1ed9ng t\\u00e1c vi\\u00ean React\",\"message\":\"<strong>Mai Truong<\\/strong> \\u0111\\u00e3 \\u1ee9ng tuy\\u1ec3n v\\u00e0o v\\u1ecb tr\\u00ed <strong>Tuy\\u1ec3n c\\u1ed9ng t\\u00e1c vi\\u00ean React<\\/strong>.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/employer\\/applications\"}', '2025-12-09 06:14:15', '2025-12-09 05:12:17', '2025-12-09 06:14:15'),
('98b227e5-481f-405a-90bd-a0b20a254244', 'App\\Notifications\\ApplicationStatusUpdated', 'App\\Models\\User', 5, '{\"job_id\":2,\"job_title\":\"Frontend Developer (React)\",\"status\":\"interview\",\"message\":\"H\\u1ed3 s\\u01a1 c\\u1ee7a b\\u1ea1n cho v\\u1ecb tr\\u00ed <strong>Frontend Developer (React)<\\/strong> \\u0111\\u00e3 \\u0111\\u01b0\\u1ee3c c\\u1eadp nh\\u1eadt tr\\u1ea1ng th\\u00e1i th\\u00e0nh: <strong>interview<\\/strong>.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/jobs\\/frontend-developer-react-1763740915-1\"}', NULL, '2025-12-01 23:31:11', '2025-12-01 23:31:11'),
('cb9168f2-fca5-477b-97ba-af50d0a9917c', 'App\\Notifications\\NewApplicantNotification', 'App\\Models\\User', 2, '{\"applicant_id\":3,\"applicant_name\":\"Mai Truong\",\"job_id\":1,\"job_title\":\"Senior PHP Developer\",\"message\":\"<strong>Mai Truong<\\/strong> \\u0111\\u00e3 \\u1ee9ng tuy\\u1ec3n v\\u00e0o v\\u1ecb tr\\u00ed <strong>Senior PHP Developer<\\/strong>.\",\"url\":\"http:\\/\\/localhost:8000\\/jobs\\/1\\/applications\"}', '2025-11-28 09:01:35', '2025-11-28 07:59:19', '2025-11-28 09:01:35');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`features`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `slug`, `price`, `features`, `created_at`, `updated_at`) VALUES
(1, 'Basic', 'basic', 0.00, '{\"post_jobs_limit\":10,\"can_search_cvs\":false,\"featured_jobs\":0}', '2025-12-02 22:21:32', '2025-12-02 22:21:32'),
(2, 'Standard', 'standard', 499000.00, '{\"post_jobs_limit\":20,\"can_search_cvs\":false,\"featured_jobs\":2}', '2025-12-02 22:21:32', '2025-12-02 22:21:32'),
(3, 'Premium', 'premium', 999000.00, '{\"post_jobs_limit\":-1,\"can_search_cvs\":true,\"featured_jobs\":5}', '2025-12-02 22:21:32', '2025-12-02 22:21:32');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `slug`, `content`, `image`, `featured_image`, `status`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'The Future of Remote Work', 'the-future-of-remote-work', 'The COVID-19 pandemic has accelerated the trend of remote work. In this post, we explore the future of remote work and what it means for both employees and employers. We will look at the benefits, challenges, and the tools needed to succeed in a remote-first world.', NULL, NULL, 'published', '2025-11-16 08:02:28', '2025-11-26 08:02:28', '2025-11-26 08:02:28'),
(2, 1, 'Top 10 In-Demand Skills for 2025', 'top-10-in-demand-skills-for-2025', 'The job market is constantly evolving. To stay competitive, it\'s crucial to know which skills are in high demand. This article breaks down the top 10 skills that employers will be looking for in 2025, from AI and machine learning to soft skills like emotional intelligence.', NULL, NULL, 'published', '2025-11-21 08:02:28', '2025-11-26 08:02:28', '2025-11-26 08:02:28'),
(3, 1, 'How to Ace Your Next Job Interview', 'how-to-ace-your-next-job-interview', 'Job interviews can be stressful. Preparation is key to success. In this guide, we provide tips and tricks on how to prepare for your next interview, from researching the company to practicing common interview questions and following up afterward.', NULL, NULL, 'published', '2025-11-24 08:02:28', '2025-11-26 08:02:28', '2025-11-26 08:02:28'),
(4, 1, 'Crafting the Perfect Resume', 'crafting-the-perfect-resume', 'Your resume is your first impression. A well-crafted resume can open doors to new opportunities. This post offers a step-by-step guide to writing a resume that stands out, including choosing the right format, highlighting your achievements, and tailoring it to the job description.', NULL, NULL, 'draft', NULL, '2025-11-26 08:02:28', '2025-11-26 08:02:28'),
(5, 4, 'Test', 'test', 'Tôi đang trải nghiệm việc code php bằng famework laravel', NULL, NULL, 'published', '2025-11-28 16:14:00', '2025-11-28 09:15:39', '2025-11-28 09:15:39'),
(6, 2, 'Test Xem ảnh được không', 'test-xem-anh-duoc-khong', 'Test', NULL, NULL, 'published', '2025-12-02 06:34:00', '2025-12-01 23:34:15', '2025-12-01 23:34:15');

-- --------------------------------------------------------

--
-- Table structure for table `queue_jobs`
--

CREATE TABLE `queue_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saved_jobs`
--

CREATE TABLE `saved_jobs` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `saved_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `saved_jobs`
--

INSERT INTO `saved_jobs` (`user_id`, `job_id`, `saved_at`, `updated_at`) VALUES
(3, 2, '2025-11-25 23:09:54', '2025-11-25 23:09:54'),
(3, 3, '2025-11-23 09:50:24', '2025-11-23 09:50:24'),
(3, 4, '2025-11-25 23:10:04', '2025-11-25 23:10:04'),
(3, 8, '2025-12-09 05:12:20', '2025-12-09 05:12:20'),
(5, 3, '2025-11-29 23:38:17', '2025-11-29 23:38:17');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'PHP', 'php', '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(2, 'Laravel', 'laravel', '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(3, 'JavaScript', 'javascript', '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(4, 'React', 'react', '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(5, 'Vue.js', 'vuejs', '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(6, 'MySQL', 'mysql', '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(7, 'Git', 'git', '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(8, 'Docker', 'docker', '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(9, 'AWS', 'aws', '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(10, 'SEO', 'seo', '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(11, 'Marketing', 'marketing', '2025-12-09 05:34:18', '2025-12-09 05:34:18');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employer_profile_id` bigint(20) UNSIGNED NOT NULL,
  `plan_id` bigint(20) UNSIGNED NOT NULL,
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `employer_profile_id`, `plan_id`, `starts_at`, `ends_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-12-02 22:21:43', NULL, '2025-12-02 22:21:43', '2025-12-02 22:21:43'),
(2, 1, 3, '2025-12-02 22:22:33', '2026-01-02 22:22:33', '2025-12-02 22:22:33', '2025-12-02 22:22:33'),
(3, 1, 2, '2025-12-02 22:22:44', '2026-01-02 22:22:44', '2025-12-02 22:22:44', '2025-12-02 22:22:44'),
(4, 3, 1, '2025-12-03 02:48:38', NULL, '2025-12-03 02:48:38', '2025-12-03 02:48:38'),
(5, 4, 1, '2025-12-05 04:56:48', NULL, '2025-12-05 04:56:46', '2025-12-05 04:56:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('candidate','employer','admin') NOT NULL DEFAULT 'candidate',
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@example.com', NULL, '$2y$12$9CJxRb9rOYyZZnq/9U5BgeY3uXSRcqaDc8yvxaZ76tSxRdNWaOW8a', 'admin', NULL, NULL, '2025-11-21 09:01:55', '2025-11-21 09:01:55'),
(2, 'John Employer', 'employer@example.com', NULL, '$2y$12$C3J.FBYZSNla/t96a6UGKuEKQyhwjhu/mhkqTP7HPzn7uADX9XF3e', 'employer', 'avatars/692e8be107fbe.jpg', NULL, '2025-11-21 09:01:55', '2025-12-01 23:49:05'),
(3, 'Mai Truong', 'candidate@example.com', NULL, '$2y$12$AlN.ThJBYeGITAKy0gKfc.WCTRQEgUVhHahXvMNFxagjVd5lyEX.a', 'candidate', 'avatars/6924fbcdaf955.jpg', NULL, '2025-11-21 09:01:55', '2025-11-24 17:43:57'),
(4, 'Sơn Quý', 'progamevip2310@gmail.com', NULL, '$2y$12$hsEQG2YnwlEIGFiYw7nDve6KVC9RXx9Lzv511wXbVAB5dVtCdw2jO', 'employer', 'avatars/6929c9ab356fe.jpg', NULL, '2025-11-28 09:10:15', '2025-11-28 09:11:24'),
(5, 'Mai Văn Trường', 'goodjobem2@gmail.com', NULL, '$2y$12$QNdZHchrSo20WP5T9/K7QO3accofz2lEbvKi/gL2FLF6aLXyiPsya', 'candidate', NULL, NULL, '2025-11-29 23:35:09', '2025-11-29 23:35:09'),
(6, 'Mai Văn Trường', 'maitruong1312205@gmail.com', NULL, '$2y$12$sT52joyvi1L37JT3OHJnlu2OwUa8nNrIm.KIDw9xAqn7229oph5ES', 'employer', NULL, NULL, '2025-12-03 02:43:43', '2025-12-03 02:43:43'),
(7, 'Mai Văn Trường', 'a@gmail.com', NULL, '$2y$12$pHhbwWed/f9qLD5/t0y4Ee8hr6IuonZd0/P32pzhFDWuae/3tEkKi', 'employer', NULL, NULL, '2025-12-05 04:56:10', '2025-12-05 04:56:10'),
(8, 'Sơn Quý', '26a4041674@hvnh.edu.vn', NULL, '$2y$12$M3V6w.XnTJ69.F6zommLselgjucBH7MCUu9m7d6T562mtC5rIPG1G', 'candidate', NULL, NULL, '2025-12-05 09:19:34', '2025-12-05 09:19:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `candidate_education`
--
ALTER TABLE `candidate_education`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_educations_candidate_profile_id_index` (`candidate_profile_id`);

--
-- Indexes for table `candidate_experiences`
--
ALTER TABLE `candidate_experiences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidate_experiences_candidate_profile_id_index` (`candidate_profile_id`);

--
-- Indexes for table `candidate_profiles`
--
ALTER TABLE `candidate_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `candidate_profiles_user_id_unique` (`user_id`);

--
-- Indexes for table `candidate_skill`
--
ALTER TABLE `candidate_skill`
  ADD PRIMARY KEY (`candidate_profile_id`,`skill_id`),
  ADD KEY `candidate_skill_skill_id_index` (`skill_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_job_id_foreign` (`job_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `comment_likes_user_id_comment_id_unique` (`user_id`,`comment_id`),
  ADD KEY `comment_likes_comment_id_foreign` (`comment_id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_templates_user_id_foreign` (`user_id`),
  ADD KEY `email_templates_type_index` (`type`);

--
-- Indexes for table `employer_profiles`
--
ALTER TABLE `employer_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employer_profiles_user_id_unique` (`user_id`),
  ADD UNIQUE KEY `employer_profiles_company_slug_unique` (`company_slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jobs_slug_unique` (`slug`),
  ADD KEY `jobs_employer_profile_id_foreign` (`employer_profile_id`),
  ADD KEY `jobs_user_id_index` (`user_id`),
  ADD KEY `jobs_category_id_index` (`category_id`),
  ADD KEY `jobs_location_id_index` (`location_id`),
  ADD KEY `jobs_status_index` (`status`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_applications_candidate_profile_id_foreign` (`candidate_profile_id`),
  ADD KEY `job_applications_job_id_index` (`job_id`),
  ADD KEY `job_applications_user_id_index` (`user_id`),
  ADD KEY `job_applications_status_index` (`status`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job_categories`
--
ALTER TABLE `job_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `job_categories_slug_unique` (`slug`);

--
-- Indexes for table `job_locations`
--
ALTER TABLE `job_locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `job_locations_slug_unique` (`slug`);

--
-- Indexes for table `job_skill`
--
ALTER TABLE `job_skill`
  ADD PRIMARY KEY (`job_id`,`skill_id`),
  ADD KEY `job_skill_skill_id_index` (`skill_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plans_slug_unique` (`slug`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `queue_jobs`
--
ALTER TABLE `queue_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `queue_jobs_queue_index` (`queue`);

--
-- Indexes for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  ADD PRIMARY KEY (`user_id`,`job_id`),
  ADD KEY `saved_jobs_job_id_index` (`job_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `skills_slug_unique` (`slug`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_employer_profile_id_foreign` (`employer_profile_id`),
  ADD KEY `subscriptions_plan_id_foreign` (`plan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_index` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidate_education`
--
ALTER TABLE `candidate_education`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `candidate_experiences`
--
ALTER TABLE `candidate_experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `candidate_profiles`
--
ALTER TABLE `candidate_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comment_likes`
--
ALTER TABLE `comment_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employer_profiles`
--
ALTER TABLE `employer_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `job_categories`
--
ALTER TABLE `job_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `job_locations`
--
ALTER TABLE `job_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `queue_jobs`
--
ALTER TABLE `queue_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidate_education`
--
ALTER TABLE `candidate_education`
  ADD CONSTRAINT `candidate_educations_candidate_profile_id_foreign` FOREIGN KEY (`candidate_profile_id`) REFERENCES `candidate_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `candidate_experiences`
--
ALTER TABLE `candidate_experiences`
  ADD CONSTRAINT `candidate_experiences_candidate_profile_id_foreign` FOREIGN KEY (`candidate_profile_id`) REFERENCES `candidate_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `candidate_profiles`
--
ALTER TABLE `candidate_profiles`
  ADD CONSTRAINT `candidate_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `candidate_skill`
--
ALTER TABLE `candidate_skill`
  ADD CONSTRAINT `candidate_skill_candidate_profile_id_foreign` FOREIGN KEY (`candidate_profile_id`) REFERENCES `candidate_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `candidate_skill_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD CONSTRAINT `comment_likes_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD CONSTRAINT `email_templates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employer_profiles`
--
ALTER TABLE `employer_profiles`
  ADD CONSTRAINT `employer_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `job_categories` (`id`),
  ADD CONSTRAINT `jobs_employer_profile_id_foreign` FOREIGN KEY (`employer_profile_id`) REFERENCES `employer_profiles` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `jobs_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `job_locations` (`id`),
  ADD CONSTRAINT `jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_candidate_profile_id_foreign` FOREIGN KEY (`candidate_profile_id`) REFERENCES `candidate_profiles` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `job_applications_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `job_skill`
--
ALTER TABLE `job_skill`
  ADD CONSTRAINT `job_skill_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `job_skill_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `saved_jobs`
--
ALTER TABLE `saved_jobs`
  ADD CONSTRAINT `saved_jobs_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `saved_jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_employer_profile_id_foreign` FOREIGN KEY (`employer_profile_id`) REFERENCES `employer_profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscriptions_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
