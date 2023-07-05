-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 05, 2023 at 12:51 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bpp_sekolah`
--

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `billings` bigint NOT NULL DEFAULT '840000',
  `recent_bill` bigint NOT NULL DEFAULT '0',
  `status` enum('YA','BELUM') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BELUM',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `student_id`, `billings`, `recent_bill`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 840000, 0, 'BELUM', '2023-06-25 07:12:02', '2023-06-25 07:12:02'),
(2, 2, 840000, 0, 'BELUM', '2023-06-25 07:12:02', '2023-06-25 07:12:02');

-- --------------------------------------------------------

--
-- Table structure for table `cash_transactions`
--

CREATE TABLE `cash_transactions` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `amount` bigint NOT NULL,
  `paid_on` date NOT NULL,
  `is_paid` enum('PENDING','APPROVED','REJECTED') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `note` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_transactions`
--

INSERT INTO `cash_transactions` (`id`, `transaction_code`, `bill_id`, `user_id`, `student_id`, `amount`, `paid_on`, `is_paid`, `note`, `created_at`, `updated_at`, `deleted_at`) VALUES
('4f1727ec-ebcc-443b-adfa-7115845a93f3', 'TRANS-lJV4b3', 2, 1, 2, 70000, '2023-10-18', 'PENDING', 'Note transactions', '2023-06-25 07:12:02', '2023-06-25 07:12:02', NULL),
('d628b3fe-6ec5-44c9-8f8e-eb273e9793a4', 'TRANS-ENEXni', 1, 1, 1, 70000, '2023-03-19', 'PENDING', 'Note transactions', '2023-06-25 07:12:02', '2023-06-25 07:12:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_01_27_122132_create_school_majors_table', 1),
(5, '2021_01_27_122348_create_school_classes_table', 1),
(6, '2021_01_30_213027_create_students_table', 1),
(7, '2021_06_18_195836_add_deleted_at_column_to_school_classes', 1),
(8, '2021_06_19_184641_add_deleted_at_column_to_school_majors', 1),
(9, '2021_07_02_135035_add_deleted_at_column_to_students', 1),
(10, '2021_10_12_165938_create_jobs_table', 1),
(11, '2023_05_29_073257_create_permission_tables', 1),
(12, '2023_05_31_021647_create_bills_table', 1),
(13, '2023_06_06_134540_create_cash_transactions_table', 1),
(14, '2023_06_07_174108_add_deleted_at_column_to_cash_transactions', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Student', 1),
(2, 'App\\Models\\Student', 1),
(3, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 1),
(5, 'App\\Models\\User', 1),
(6, 'App\\Models\\User', 1),
(1, 'App\\Models\\Student', 2),
(2, 'App\\Models\\Student', 2),
(3, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Student', 1),
(2, 'App\\Models\\User', 1),
(1, 'App\\Models\\Student', 2),
(3, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'create', 'student', '2023-06-25 07:12:01', '2023-06-25 07:12:01'),
(2, 'read', 'student', '2023-06-25 07:12:01', '2023-06-25 07:12:01'),
(3, 'create', 'admin', '2023-06-25 07:12:01', '2023-06-25 07:12:01'),
(4, 'read', 'admin', '2023-06-25 07:12:01', '2023-06-25 07:12:01'),
(5, 'update', 'admin', '2023-06-25 07:12:01', '2023-06-25 07:12:01'),
(6, 'delete', 'admin', '2023-06-25 07:12:01', '2023-06-25 07:12:01');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'student', 'student', '2023-06-25 07:12:01', '2023-06-25 07:12:01'),
(2, 'admin', 'admin', '2023-06-25 07:12:01', '2023-06-25 07:12:01'),
(3, 'supervisor', 'admin', '2023-06-25 07:12:01', '2023-06-25 07:12:01');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(3, 3),
(4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `school_classes`
--

CREATE TABLE `school_classes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_classes`
--

INSERT INTO `school_classes` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'X MIA 1', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(2, 'XI MIA 1', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(3, 'XII MIA 1', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(4, 'X ISS 1', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(5, 'X MIA 2', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(6, 'XI MIA 2', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(7, 'XII MIA 2', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(8, 'X ISS 2', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(9, 'X MIA 3', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(10, 'XI MIA 3', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(11, 'XII MIA 3', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(12, 'X ISS 3', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(13, 'X MIA 4', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(14, 'XI MIA 4', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(15, 'XII MIA 4', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(16, 'X ISS 4', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(17, 'X MIA 5', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(18, 'XI MIA 5', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(19, 'XII MIA 5', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(20, 'X ISS 5', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(21, 'XI ISS 1', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(22, 'XII ISS 1', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(23, 'XI ISS 2', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(24, 'XII ISS 2', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(25, 'XI ISS 3', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(26, 'XII ISS 3', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(27, 'XI ISS 4', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(28, 'XII ISS 4', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `school_majors`
--

CREATE TABLE `school_majors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbreviated_word` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `school_majors`
--

INSERT INTO `school_majors` (`id`, `name`, `abbreviated_word`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Matematika dan Ilmu Alam', 'MIA', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(2, 'Ilmu-Ilmu Sosial', 'IIS', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint UNSIGNED NOT NULL,
  `school_class_id` bigint UNSIGNED NOT NULL,
  `school_major_id` bigint UNSIGNED NOT NULL,
  `student_identification_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` tinyint NOT NULL,
  `school_year_start` int NOT NULL,
  `school_year_end` int NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '$2y$10$GxnoTD2qsi72h9BVRVls6OgFDx/v5Gd2WEBlYsOAWgGsG5iMdl3g.',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `school_class_id`, `school_major_id`, `student_identification_number`, `name`, `email`, `phone_number`, `gender`, `school_year_start`, `school_year_end`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, '10389', 'Susanto', 'susanto@gmail.com', '087723456789', 1, 2014, 2017, '$2y$10$1GBWpEjO55mJKfzuJ6fO0e5FJ0oi/qOp4tYoL5NET/iKutL8XxKmG', '2023-06-25 07:12:01', '2023-06-25 07:12:01', NULL),
(2, 1, 2, '10399', 'Susanti Testing berhasil', 'susanti@gmail.com', '089923456778', 2, 2014, 2017, '$2y$10$B1Zs9ltvYZWSZYHJtgv8TeP10lcnonLQ/a.vgbrg3aXHjPYeOct6C', '2023-06-25 07:12:01', '2023-06-26 19:58:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin BPP', 'admin@mail.com', '2023-06-25 07:12:01', '$2y$10$yc9IpIiIoiryj5dIoAvWV.01.uBUZ6H98VCC924szpuHuk.y0kcxW', 'id6HFdfEIQauGPYdVwtlsKN0y6q0ATEivPP0S2wCptEDs6PVV7WFLyr7BgiN', '2023-06-25 07:12:01', '2023-06-25 07:12:01'),
(2, 'Kepla sekolah', 'kepsek@mail.com', '2023-06-25 07:12:01', '$2y$10$/dZu5GVjAaDQvs3kCuUwjONqqoOioMEvEzCoYym.IJvZSHml8Nmca', 'VxVPSgodduXezW5NydE2jpIY8OA67DR4gSPz1FjBUAeX4f2vDDqcJ5mXFdax', '2023-06-25 07:12:01', '2023-06-25 07:12:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bills_student_id_foreign` (`student_id`);

--
-- Indexes for table `cash_transactions`
--
ALTER TABLE `cash_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cash_transactions_bill_id_foreign` (`bill_id`),
  ADD KEY `cash_transactions_user_id_foreign` (`user_id`),
  ADD KEY `cash_transactions_student_id_foreign` (`student_id`);

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
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `school_classes`
--
ALTER TABLE `school_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_majors`
--
ALTER TABLE `school_majors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_student_identification_number_unique` (`student_identification_number`),
  ADD UNIQUE KEY `students_email_unique` (`email`),
  ADD UNIQUE KEY `students_phone_number_unique` (`phone_number`),
  ADD KEY `students_school_class_id_foreign` (`school_class_id`),
  ADD KEY `students_school_major_id_foreign` (`school_major_id`);

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
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `school_classes`
--
ALTER TABLE `school_classes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `school_majors`
--
ALTER TABLE `school_majors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cash_transactions`
--
ALTER TABLE `cash_transactions`
  ADD CONSTRAINT `cash_transactions_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cash_transactions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cash_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_school_class_id_foreign` FOREIGN KEY (`school_class_id`) REFERENCES `school_classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_school_major_id_foreign` FOREIGN KEY (`school_major_id`) REFERENCES `school_majors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
