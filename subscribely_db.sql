-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 10, 2025 at 07:17 AM
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
-- Database: `subscribely_db`
--

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_10_15_093327_create_subscriptions_table', 2),
(6, '2025_10_16_114027_add_user_id_to_subscriptions_table', 3),
(7, '2025_11_03_100637_create_password_otps_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_otps`
--

CREATE TABLE `password_otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'auth_token', '93d7809f167929226bef5b40aa45433389da50c2e27a9ed74e43c17fcb92d635', '[\"*\"]', NULL, NULL, '2025-10-16 05:15:52', '2025-10-16 05:15:52'),
(3, 'App\\Models\\User', 2, 'auth_token', '8a89d8eed763e9310e124788f382a9f4e75b8de23cb836c637dcc64e0eef078c', '[\"*\"]', NULL, NULL, '2025-10-16 05:47:29', '2025-10-16 05:47:29'),
(5, 'App\\Models\\User', 3, 'auth_token', 'bd6734faa4c1fc449858f9e7083c0cf7e4f938f63289fbe1cd5e0b077219d96d', '[\"*\"]', NULL, NULL, '2025-10-16 07:34:58', '2025-10-16 07:34:58'),
(6, 'App\\Models\\User', 3, 'auth_token', '446d32bc223a724d08cf5e71aeef40a8590287685c820134f48e4be154c26dbd', '[\"*\"]', '2025-10-31 00:53:19', NULL, '2025-10-16 07:35:17', '2025-10-31 00:53:19'),
(7, 'App\\Models\\User', 4, 'auth_token', '4122c589c9f8940ce50009f8edfc9366b9460ba845052f0c46820862d68af636', '[\"*\"]', NULL, NULL, '2025-10-17 07:38:04', '2025-10-17 07:38:04'),
(8, 'App\\Models\\User', 5, 'auth_token', '79895accd79f46f0f566fa409e1f629810951c2f0341f3ee1fb65e1ad1294c9f', '[\"*\"]', NULL, NULL, '2025-10-30 07:13:45', '2025-10-30 07:13:45'),
(9, 'App\\Models\\User', 5, 'auth_token', '40e9b383e2a56d8cbb384e2be3b31d1bfe97e50813d90d16c6347b8aeb323d71', '[\"*\"]', '2025-10-31 00:51:34', NULL, '2025-10-30 07:14:52', '2025-10-31 00:51:34'),
(10, 'App\\Models\\User', 5, 'auth_token', '1f9c945ab44e3dc5a014be93b85ae7e264de00c6690d9e5ad63b698898078560', '[\"*\"]', '2025-10-31 04:28:43', NULL, '2025-10-31 00:52:02', '2025-10-31 04:28:43'),
(11, 'App\\Models\\User', 5, 'auth_token', '7a2b81931a35309863b37ad98230df52c12d5ba4d2fcbed2702b934766d2645a', '[\"*\"]', '2025-11-06 05:27:12', NULL, '2025-10-31 04:44:43', '2025-11-06 05:27:12'),
(12, 'App\\Models\\User', 5, 'auth_token', '671eccdfcf38ea0c18ce6fc0bd6cc6b401f55dff960af54ffa79121f72a44aa6', '[\"*\"]', '2025-11-03 04:25:38', NULL, '2025-11-03 04:22:25', '2025-11-03 04:25:38'),
(13, 'App\\Models\\User', 1, 'auth_token', '327040f48836ba70f70c05785dadce6dd6b75fbff11a82f059fc7c11fd185de1', '[\"*\"]', NULL, NULL, '2025-11-03 23:59:58', '2025-11-03 23:59:58'),
(14, 'App\\Models\\User', 1, 'auth_token', '65f77a090d3340258b3b49eed7d7e238452c318360f2acb387bed1dc8bd30b46', '[\"*\"]', NULL, NULL, '2025-11-04 00:01:13', '2025-11-04 00:01:13'),
(15, 'App\\Models\\User', 1, 'auth_token', 'b0b66738b7a9fd55acd5e85f056d1e6b33bf029fba5153fbc2d8bab8510a8ca0', '[\"*\"]', NULL, NULL, '2025-11-04 00:02:33', '2025-11-04 00:02:33'),
(16, 'App\\Models\\User', 1, 'auth_token', 'a3ceb3d6d57d9f3743c76c05ea5def200ada95ad872abd69a8762339c2ee1973', '[\"*\"]', NULL, NULL, '2025-11-04 00:04:19', '2025-11-04 00:04:19'),
(17, 'App\\Models\\User', 1, 'auth_token', 'a2bd9184ee006afd7723c84730a36ab9db595df4180a1c3042e39444b0c1add6', '[\"*\"]', NULL, NULL, '2025-11-04 00:10:39', '2025-11-04 00:10:39'),
(18, 'App\\Models\\User', 1, 'auth_token', '4ce1f46445e9fa38c33359e7b8afaf756cfa56b949805da90bed6443444c67d5', '[\"*\"]', NULL, NULL, '2025-11-04 00:21:21', '2025-11-04 00:21:21'),
(19, 'App\\Models\\User', 6, 'auth_token', '01507083d5a8cb307a112b6c296f8531c30135668af226cc30617ba85f5bc3a7', '[\"*\"]', NULL, NULL, '2025-11-04 00:27:03', '2025-11-04 00:27:03'),
(20, 'App\\Models\\User', 1, 'auth_token', '301d511fc37f25ca478445a3f65074fe488bc04b95fdcd639b090b23ca64cd09', '[\"*\"]', NULL, NULL, '2025-11-04 07:36:56', '2025-11-04 07:36:56'),
(21, 'App\\Models\\User', 1, 'auth_token', '8344611ad2a85b5045e40c1724c9161a094dc2f6303a2154c1d6100439e54aec', '[\"*\"]', NULL, NULL, '2025-11-04 08:29:18', '2025-11-04 08:29:18'),
(22, 'App\\Models\\User', 6, 'auth_token', '6b1960e58b0c0c98a9d4f2ba08b9eafea3569457620f0bb0b2f8e3aeed98a3a8', '[\"*\"]', NULL, NULL, '2025-11-04 23:58:59', '2025-11-04 23:58:59'),
(23, 'App\\Models\\User', 6, 'auth_token', '46b09dbb8b4b3c202f0aa7dffa2af623be65200cf4f7b6ba4534bed2ff99f067', '[\"*\"]', NULL, NULL, '2025-11-05 00:12:38', '2025-11-05 00:12:38'),
(24, 'App\\Models\\User', 6, 'auth_token', 'b7fcf4daa18f42557479a2d9109af2c224e05b811a19e33fbf036420288ff9fd', '[\"*\"]', NULL, NULL, '2025-11-05 00:12:54', '2025-11-05 00:12:54'),
(25, 'App\\Models\\User', 6, 'auth_token', '15477827715e9a8276e3c08a99b8f4e8ae662cdbbf41eaf08c33e7395a458778', '[\"*\"]', NULL, NULL, '2025-11-05 00:18:27', '2025-11-05 00:18:27'),
(26, 'App\\Models\\User', 6, 'auth_token', 'd4124c029dfc438790e25c802993438bde18e0458acc8667614732f4b99adcb5', '[\"*\"]', '2025-11-05 00:29:32', NULL, '2025-11-05 00:29:31', '2025-11-05 00:29:32'),
(27, 'App\\Models\\User', 6, 'auth_token', 'f47ec8e4d4ed459d404377d77c8d82aa74c0694f17b44d992dbec4af867e73d2', '[\"*\"]', '2025-11-05 00:29:56', NULL, '2025-11-05 00:29:54', '2025-11-05 00:29:56'),
(28, 'App\\Models\\User', 6, 'auth_token', 'c693f73e01e728c5e98504be3bb81ee468e6d7bc538464b0b95f70f450b6ed71', '[\"*\"]', '2025-11-05 01:07:45', NULL, '2025-11-05 00:44:42', '2025-11-05 01:07:45'),
(29, 'App\\Models\\User', 6, 'auth_token', '29afe96a9af4d69ba12c59cd4e9557618be9b795c89816d1052f08817c5cbe69', '[\"*\"]', '2025-11-05 01:08:08', NULL, '2025-11-05 01:08:06', '2025-11-05 01:08:08'),
(30, 'App\\Models\\User', 6, 'auth_token', 'b2b08ae6524f15971a7c8e23474b2cbf93574e187403bdf972db62046d5e43ce', '[\"*\"]', '2025-11-05 01:15:32', NULL, '2025-11-05 01:15:30', '2025-11-05 01:15:32'),
(31, 'App\\Models\\User', 1, 'auth_token', '09cad6cd8a5b4683a6e455a87b05a378aa7dd6950ae95e78fba7af217f1a0cbf', '[\"*\"]', '2025-11-05 01:16:36', NULL, '2025-11-05 01:16:35', '2025-11-05 01:16:36'),
(32, 'App\\Models\\User', 1, 'auth_token', '9c6783c5334a36dd4c59010a8a8ad498dbbec26408c7ff3e968af5bac5ac98d4', '[\"*\"]', '2025-11-05 01:17:00', NULL, '2025-11-05 01:16:59', '2025-11-05 01:17:00'),
(33, 'App\\Models\\User', 1, 'auth_token', '6ffe31fba7fe368c80da39d500a91eac44960a9c6523bc79234e0c182208f9b0', '[\"*\"]', '2025-11-05 01:17:27', NULL, '2025-11-05 01:17:26', '2025-11-05 01:17:27'),
(34, 'App\\Models\\User', 1, 'auth_token', 'f5fd934340eaf31b27cdcb6364d75d4fe8af377043823496605930a376c5bbfd', '[\"*\"]', '2025-11-05 01:17:55', NULL, '2025-11-05 01:17:54', '2025-11-05 01:17:55'),
(35, 'App\\Models\\User', 1, 'auth_token', 'e480bb784766bafb0ece28d386b1d44ea5434bd59fa9d76ecffafecb3e9e73d3', '[\"*\"]', '2025-11-05 01:32:44', NULL, '2025-11-05 01:21:09', '2025-11-05 01:32:44'),
(36, 'App\\Models\\User', 7, 'auth_token', 'be1ee8b716dbf58cb3a0dba3195796a73e6b5271a2470251d2fbc584c7d05737', '[\"*\"]', '2025-11-05 01:35:35', NULL, '2025-11-05 01:34:40', '2025-11-05 01:35:35'),
(37, 'App\\Models\\User', 1, 'auth_token', '6926c20483d9db95a9af1ef01cc4af50b2734b68e75188ed4108e719f9519276', '[\"*\"]', '2025-11-05 01:48:13', NULL, '2025-11-05 01:46:02', '2025-11-05 01:48:13'),
(38, 'App\\Models\\User', 1, 'auth_token', '0f70f8282dac6d2a47a92578bdc8fe00b7675efa30839e2b7323f3aefa426076', '[\"*\"]', '2025-11-05 01:54:54', NULL, '2025-11-05 01:53:32', '2025-11-05 01:54:54'),
(39, 'App\\Models\\User', 1, 'auth_token', '556715668f2bd63fa3ada6f5a691d96a6fb0aaced1dacebc5de4c9b1f66a99c7', '[\"*\"]', '2025-11-05 01:59:28', NULL, '2025-11-05 01:56:24', '2025-11-05 01:59:28'),
(40, 'App\\Models\\User', 1, 'auth_token', '864599fd973a763e9b249a5520e5164bf16e0b3233ee1bf5773e6c47846e144e', '[\"*\"]', '2025-11-05 04:02:47', NULL, '2025-11-05 02:00:07', '2025-11-05 04:02:47'),
(41, 'App\\Models\\User', 1, 'auth_token', '4c7af0ea14562f495197267fbb111b106a5ff68d247f72373fa03e301c9d2837', '[\"*\"]', '2025-11-05 05:00:33', NULL, '2025-11-05 04:12:15', '2025-11-05 05:00:33'),
(42, 'App\\Models\\User', 8, 'auth_token', '7ccc001925abb8090f6a7c5ebfbe531d5701fb43a0a9f90068a9c8fcf9cb85cd', '[\"*\"]', '2025-11-05 05:03:27', NULL, '2025-11-05 05:02:44', '2025-11-05 05:03:27'),
(43, 'App\\Models\\User', 8, 'auth_token', 'd2f442a22dc9f8cdeb9772d823763d66b6b687898163501dc7a1554b8235e065', '[\"*\"]', '2025-11-05 05:05:32', NULL, '2025-11-05 05:04:02', '2025-11-05 05:05:32'),
(44, 'App\\Models\\User', 1, 'auth_token', '37784060e830766547ad90e7e155601f4f91fc97f1d31c38a1b73c8378164728', '[\"*\"]', '2025-11-05 06:23:27', NULL, '2025-11-05 05:18:19', '2025-11-05 06:23:27'),
(45, 'App\\Models\\User', 1, 'auth_token', '3669ae561d86f59a9888c2164b940cb81c907cfeb7fa26d78a188b8311587b73', '[\"*\"]', '2025-11-05 06:25:56', NULL, '2025-11-05 06:24:28', '2025-11-05 06:25:56'),
(46, 'App\\Models\\User', 8, 'auth_token', 'de7d5d81c3bbdc53e6b085226bc0b130cd124dfcd8db1e0df4369acc24d5078e', '[\"*\"]', '2025-11-05 06:38:01', NULL, '2025-11-05 06:37:56', '2025-11-05 06:38:01'),
(47, 'App\\Models\\User', 1, 'auth_token', '1cf9262ce4621d1c752f4289add42da0c2a39aacf041c482ab33021ca3611929', '[\"*\"]', '2025-11-05 07:24:51', NULL, '2025-11-05 07:24:13', '2025-11-05 07:24:51'),
(48, 'App\\Models\\User', 1, 'auth_token', 'cdfabc902ad626a31fd7ff95362105599c9e81e2879af304a380acfbb024a893', '[\"*\"]', '2025-11-05 07:51:27', NULL, '2025-11-05 07:50:31', '2025-11-05 07:51:27'),
(49, 'App\\Models\\User', 1, 'auth_token', 'ccc79f813af54fa52eaf96a4d8276b3d41d35e60900b4d90d4dd651cd83e6b23', '[\"*\"]', '2025-11-06 00:27:24', NULL, '2025-11-05 07:51:42', '2025-11-06 00:27:24'),
(50, 'App\\Models\\User', 1, 'auth_token', '312cf7047c535da71e6c268a1c2fbb60dc5158f65aede8770b778b0f21a12dca', '[\"*\"]', '2025-11-06 00:31:19', NULL, '2025-11-06 00:27:53', '2025-11-06 00:31:19'),
(51, 'App\\Models\\User', 1, 'auth_token', 'f8428b1d3279ee913c9880467a59aa0525d1c54d2acea14a8fe008478c731aaa', '[\"*\"]', '2025-11-06 06:07:33', NULL, '2025-11-06 04:13:02', '2025-11-06 06:07:33'),
(52, 'App\\Models\\User', 1, 'auth_token', 'ecfb3c2fd5e864b5758991748fa67fd4dd5a3fd7c82dae93f466426f6bcc9412', '[\"*\"]', '2025-11-06 06:20:54', NULL, '2025-11-06 06:07:44', '2025-11-06 06:20:54'),
(53, 'App\\Models\\User', 1, 'auth_token', '550f654db80c3168766e7f8a7ffd40b1e93e5386488a06b8ff318c4ddb128066', '[\"*\"]', '2025-11-06 07:19:18', NULL, '2025-11-06 06:21:05', '2025-11-06 07:19:18');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `billing_cycle` varchar(255) NOT NULL,
  `next_renewal_date` date NOT NULL,
  `notification_email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `service_name`, `category`, `amount`, `billing_cycle`, `next_renewal_date`, `notification_email`, `created_at`, `updated_at`) VALUES
(3, 3, 'Netflix', 'Entertainment', 599.00, 'Monthly', '2025-10-18', 'crystal@example.com', '2025-10-16 07:43:57', '2025-10-16 07:49:09'),
(4, 3, 'spotify', 'Music', 149.00, 'Monthly', '2025-12-17', 'Avani@example.com', '2025-10-30 07:19:24', '2025-10-30 07:19:24'),
(5, 3, 'spotify', 'Music', 149.00, 'Monthly', '2025-12-17', 'Avani@example.com', '2025-10-31 00:53:19', '2025-10-31 00:53:19'),
(6, 5, 'spotify', 'Music', 599.00, 'Monthly', '2025-11-03', 'Avani@example.com', '2025-10-31 04:45:04', '2025-10-31 04:48:06'),
(10, 8, 'spotify', NULL, 149.00, 'monthly', '2025-11-21', NULL, '2025-11-05 05:04:37', '2025-11-05 05:04:37'),
(18, 5, 'spotify', 'Music', 200.00, 'Monthly', '2025-11-26', 'Avani@example.com', '2025-10-31 04:45:04', '2025-10-31 04:48:06'),
(20, 1, 'spotify', 'Entertainment', 149.00, 'monthly', '2025-11-13', NULL, '2025-11-06 07:13:46', '2025-11-06 07:13:46'),
(21, 1, 'AWS', 'Cloud Storage', 3000.00, 'yearly', '2025-11-22', NULL, '2025-11-06 07:14:17', '2025-11-06 07:14:17'),
(22, 1, 'Bill', 'Utility Bills', 345.00, 'monthly', '2025-11-23', NULL, '2025-11-06 07:14:43', '2025-11-06 07:14:43'),
(23, 1, 'ff', 'Others', 888.00, 'monthly', '2025-11-14', NULL, '2025-11-06 07:15:00', '2025-11-06 07:15:00'),
(24, 1, 'ghgg', 'Mobile/Internet', 666.00, 'monthly', '2025-11-22', NULL, '2025-11-06 07:15:17', '2025-11-06 07:15:17'),
(25, 1, 'hghg', 'Cloud Storage', 7676.00, 'monthly', '2025-11-19', NULL, '2025-11-06 07:15:37', '2025-11-06 07:15:50'),
(26, 1, 'hdfhfh', 'Productivity', 7667.00, 'yearly', '2025-11-22', NULL, '2025-11-06 07:16:07', '2025-11-06 07:16:07'),
(27, 1, 'hhhhh', 'Finance/Bank', 7776.00, 'yearly', '2025-11-07', NULL, '2025-11-06 07:16:27', '2025-11-06 07:16:27'),
(28, 1, 'jjjjj', 'Finance/Bank', 777.00, 'monthly', '2025-12-06', NULL, '2025-11-06 07:16:45', '2025-11-06 07:16:45'),
(29, 1, 'gfgfg', 'Cloud Storage', 6656.00, 'yearly', '2025-11-28', NULL, '2025-11-06 07:17:01', '2025-11-06 07:17:01'),
(30, 1, 'yyryry', 'Finance/Bank', 6577.00, 'monthly', '2025-11-29', NULL, '2025-11-06 07:17:37', '2025-11-06 07:17:37');

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
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'john@example.com', NULL, '$2y$12$hAf4XWn/2ggBw9F3SkmjnudruG44xWwR6HpGxqF2ZZ4ja2y4Z0Bqq', NULL, '2025-10-16 05:15:52', '2025-11-05 01:54:47'),
(2, 'Mark Doe', 'mark@example.com', NULL, '$2y$12$P7ipi6NY5.ov8m7Hee.FnumUVENib3i8fyBSuGCkZGlb/dQna8jFW', NULL, '2025-10-16 05:47:29', '2025-10-16 05:47:29'),
(3, 'crystal Doe', 'crystal@example.com', NULL, '$2y$12$5.gFQUxpqwL4Orgesj89XeS561JVKF0c8.ScfQqiRavJ9QnnreMLG', NULL, '2025-10-16 07:34:58', '2025-10-16 07:34:58'),
(4, 'srejan Doe', 'shrejan@example.com', NULL, '$2y$12$TndDfKiu.ubzSXMZIRxMM.kpDohe87VGi9.6bUqUxP0G0g27cwSjS', NULL, '2025-10-17 07:38:04', '2025-10-17 07:38:04'),
(5, 'Avani Desuza', 'avani123@example.com', NULL, '$2y$12$P8ReLZoxLNgIlDQJu7/YEOpv7cuwy7bLtTA0b7s7BsS84lYGBy5lK', NULL, '2025-10-30 07:13:45', '2025-11-03 04:25:38'),
(6, 'Rashi khanna', 'rashi123@gmail.com', NULL, '$2y$12$somRzYncRhKIBm7pYMWmtenwdn1H8uP.GnnmG4/kVGnSVOEGWRfve', NULL, '2025-11-04 00:27:03', '2025-11-04 00:27:03'),
(7, 'Adriza', 'adriza123@gmail.com', NULL, '$2y$12$pR3BZbbQNInmy14PFlAA/ejJlSpxHSSId/SYBmgdjdgUdXllyTaR.', NULL, '2025-11-05 01:34:40', '2025-11-05 01:34:40'),
(8, 'khushboo m', 'khusboo.softrefine@gmail.com', NULL, '$2y$12$Hchkk2/NCsFH21dThA/2KO6db5EFmCxtiBKYx1Z3CO37.kXEV5TzG', NULL, '2025-11-05 05:02:44', '2025-11-05 06:37:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_otps`
--
ALTER TABLE `password_otps`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `password_otps`
--
ALTER TABLE `password_otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
