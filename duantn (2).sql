-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 30, 2025 lúc 03:25 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `duantn2`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `address`
--

CREATE TABLE `address` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `adress` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `address`
--

INSERT INTO `address` (`id`, `adress`, `user_id`, `is_default`, `created_at`, `updated_at`) VALUES
(1, '123 Nguyễn Trãi, Hà Nội', 3, 1, '2025-06-03 02:30:43', '2025-06-03 02:44:41'),
(2, '1456 Nguyễn Trãi, Hà Nội', 3, 0, '2025-06-03 02:34:54', '2025-06-03 02:44:41'),
(3, '56 Nguyễn Trãi, Hà Nội', 3, 0, '2025-06-03 02:35:19', '2025-06-03 02:44:41'),
(5, '123 Đường ABC, Quận 1, TP.HCM', 4, 0, '2025-06-03 07:55:12', '2025-06-03 07:55:12'),
(6, '456 Đường XYZ, Quận 3, TP.HCM', 3, 0, '2025-06-03 07:55:12', '2025-06-03 07:55:12'),
(7, '123456789 Đường Lê Lợi, Quận 1, TP.HCM', 10, 1, '2025-06-04 02:22:14', '2025-06-16 08:55:51'),
(8, '113 Đường Lê Lợi, Quận 9, TP.HCM', 10, 0, '2025-06-04 02:23:31', '2025-06-16 08:55:51'),
(9, '1465413 Đường Lê Lợi, Quận 7, TP.HCM', 10, 0, '2025-06-04 02:23:39', '2025-06-16 08:55:51'),
(10, '1465413 Đường Lê Lợi, Quận 12, TP.HCM', 10, 0, '2025-06-04 02:23:46', '2025-06-16 08:55:51'),
(11, 'L1/11 Tô Ký', 13, 1, '2025-06-28 14:18:00', '2025-06-28 14:18:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_vnpay_6854e37fef961', 'a:7:{s:7:\"user_id\";i:10;s:4:\"cart\";a:2:{i:0;a:3:{s:10:\"variant_id\";i:33;s:5:\"price\";i:380000;s:8:\"quantity\";i:1;}i:1;a:3:{s:10:\"variant_id\";i:36;s:5:\"price\";i:400000;s:8:\"quantity\";i:1;}}s:9:\"coupon_id\";N;s:11:\"shipping_id\";i:1;s:10:\"address_id\";i:1;s:10:\"payment_id\";i:1;s:18:\"totalAfterDiscount\";i:780000;}', 1750395527),
('laravel_cache_vnpay_685a16078b96c', 'a:7:{s:7:\"user_id\";i:9;s:4:\"cart\";a:2:{i:0;a:3:{s:10:\"variant_id\";i:14;s:5:\"price\";i:320000;s:8:\"quantity\";i:2;}i:1;a:3:{s:10:\"variant_id\";i:20;s:5:\"price\";i:330000;s:8:\"quantity\";i:1;}}s:9:\"coupon_id\";N;s:11:\"shipping_id\";i:1;s:10:\"address_id\";i:1;s:10:\"payment_id\";i:1;s:18:\"totalAfterDiscount\";i:640000;}', 1750736143),
('laravel_cache_vnpay_685a1ab00975c', 'a:7:{s:7:\"user_id\";i:9;s:4:\"cart\";a:4:{i:0;a:3:{s:10:\"variant_id\";i:14;s:5:\"price\";i:320000;s:8:\"quantity\";i:2;}i:1;a:3:{s:10:\"variant_id\";i:20;s:5:\"price\";i:330000;s:8:\"quantity\";i:1;}i:2;a:3:{s:10:\"variant_id\";i:14;s:8:\"quantity\";i:2;s:5:\"price\";i:320000;}i:3;a:3:{s:10:\"variant_id\";i:20;s:8:\"quantity\";i:1;s:5:\"price\";i:0;}}s:9:\"coupon_id\";N;s:11:\"shipping_id\";i:1;s:10:\"address_id\";i:1;s:10:\"payment_id\";i:1;s:18:\"totalAfterDiscount\";i:640000;}', 1750737336),
('laravel_cache_vnpay_685a1c8625cde', 'a:7:{s:7:\"user_id\";i:9;s:4:\"cart\";a:3:{i:0;a:3:{s:10:\"variant_id\";i:14;s:5:\"price\";i:320000;s:8:\"quantity\";i:2;}i:1;a:3:{s:10:\"variant_id\";i:20;s:5:\"price\";i:330000;s:8:\"quantity\";i:1;}i:2;a:3:{s:10:\"variant_id\";i:12;s:5:\"price\";i:350000;s:8:\"quantity\";i:1;}}s:9:\"coupon_id\";N;s:11:\"shipping_id\";i:1;s:10:\"address_id\";i:1;s:10:\"payment_id\";i:1;s:18:\"totalAfterDiscount\";i:990000;}', 1750737806),
('laravel_cache_vnpay_685a1d03b4948', 'a:7:{s:7:\"user_id\";i:9;s:4:\"cart\";a:3:{i:0;a:3:{s:10:\"variant_id\";i:14;s:5:\"price\";i:320000;s:8:\"quantity\";i:2;}i:1;a:3:{s:10:\"variant_id\";i:20;s:5:\"price\";i:330000;s:8:\"quantity\";i:2;}i:2;a:3:{s:10:\"variant_id\";i:12;s:5:\"price\";i:350000;s:8:\"quantity\";i:1;}}s:9:\"coupon_id\";N;s:11:\"shipping_id\";i:1;s:10:\"address_id\";i:1;s:10:\"payment_id\";i:1;s:18:\"totalAfterDiscount\";i:990000;}', 1750737931),
('laravel_cache_vnpay_685a1e0604f7a', 'a:7:{s:7:\"user_id\";i:9;s:4:\"cart\";a:3:{i:0;a:3:{s:10:\"variant_id\";i:14;s:5:\"price\";i:320000;s:8:\"quantity\";i:2;}i:1;a:3:{s:10:\"variant_id\";i:20;s:5:\"price\";i:330000;s:8:\"quantity\";i:2;}i:2;a:3:{s:10:\"variant_id\";i:12;s:5:\"price\";i:350000;s:8:\"quantity\";i:1;}}s:9:\"coupon_id\";N;s:11:\"shipping_id\";i:1;s:10:\"address_id\";i:1;s:10:\"payment_id\";i:1;s:18:\"totalAfterDiscount\";i:990000;}', 1750738190),
('laravel_cache_vnpay_685a1ef48ea60', 'a:7:{s:7:\"user_id\";i:9;s:4:\"cart\";a:2:{i:0;a:3:{s:10:\"variant_id\";i:20;s:5:\"price\";i:330000;s:8:\"quantity\";i:2;}i:1;a:3:{s:10:\"variant_id\";i:11;s:5:\"price\";i:350000;s:8:\"quantity\";i:1;}}s:9:\"coupon_id\";N;s:11:\"shipping_id\";i:1;s:10:\"address_id\";i:1;s:10:\"payment_id\";i:1;s:18:\"totalAfterDiscount\";i:0;}', 1750738428),
('laravel_cache_vnpay_685a21a8e7fe5', 'a:7:{s:7:\"user_id\";i:9;s:4:\"cart\";a:2:{i:0;a:3:{s:10:\"variant_id\";i:20;s:5:\"price\";i:330000;s:8:\"quantity\";i:2;}i:1;a:3:{s:10:\"variant_id\";i:11;s:5:\"price\";i:350000;s:8:\"quantity\";i:1;}}s:9:\"coupon_id\";N;s:11:\"shipping_id\";i:1;s:10:\"address_id\";i:1;s:10:\"payment_id\";i:1;s:18:\"totalAfterDiscount\";i:1010000;}', 1750739120),
('laravel_cache_vnpay_685a224a30962', 'a:7:{s:7:\"user_id\";i:9;s:4:\"cart\";a:1:{i:0;a:3:{s:10:\"variant_id\";i:20;s:5:\"price\";i:330000;s:8:\"quantity\";i:2;}}s:9:\"coupon_id\";N;s:11:\"shipping_id\";i:1;s:10:\"address_id\";i:1;s:10:\"payment_id\";i:1;s:18:\"totalAfterDiscount\";i:660000;}', 1750739282);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `image_url`, `name`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(1, 'sp1.webp', 'Bomber', NULL, '2025-06-16 07:25:22', NULL, 1),
(2, '1750042933_sp2.webp', 'Áo thun', NULL, '2025-06-16 03:02:13', NULL, 1),
(3, 'sp4.webp', 'Quần', NULL, '2025-06-16 07:24:37', NULL, 1),
(4, 'sp3_1.webp', 'Hoodie', NULL, '2025-06-16 07:26:50', NULL, 1),
(7, '1750042979_z6662967725185_6db12d72cf60605ffee92fc1b02abd71.jpg', 'Túi sách', '2025-05-13 20:41:35', '2025-06-16 03:02:59', NULL, 1),
(8, NULL, 'Nhật Vinh', '2025-06-02 02:49:52', '2025-06-02 03:22:53', NULL, 0),
(9, NULL, 'vinh', '2025-06-02 03:04:59', '2025-06-02 03:22:57', NULL, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `discount_value` varchar(255) NOT NULL,
  `expiry_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_value`, `expiry_date`, `created_at`, `updated_at`, `is_public`) VALUES
(6, 'HAHFJA1', '10000', '2025-06-06 00:00:00', '2025-06-05 01:42:29', '2025-06-05 01:45:34', 0),
(7, 'QSSNC1', '10000', '2025-06-06 00:00:00', '2025-06-05 01:45:15', '2025-06-05 01:45:15', 0),
(8, 'HHQ82', '100000', '2025-06-18 00:00:00', '2025-06-16 08:32:08', '2025-06-16 08:32:14', 0),
(9, 'BDAYBAO6917', '100000', '2025-07-05 20:07:56', '2025-06-28 13:07:56', '2025-06-28 13:07:56', 1),
(10, 'PS38735', '100000', '2025-07-09 00:00:00', '2025-06-28 13:19:24', '2025-06-28 13:19:24', 0),
(11, 'BDAYBAO7573', '100000', '2025-07-05 21:25:12', '2025-06-28 14:25:12', '2025-06-28 14:25:12', 1),
(12, 'BDAYSAN6929', '100000', '2025-07-05 21:25:15', '2025-06-28 14:25:15', '2025-06-28 14:25:15', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons_user`
--

CREATE TABLE `coupons_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons_user`
--

INSERT INTO `coupons_user` (`id`, `user_id`, `coupon_id`, `created_at`, `updated_at`) VALUES
(1, 11, 9, '2025-06-28 13:07:56', '2025-06-28 13:07:56'),
(2, 11, 11, '2025-06-28 14:25:12', '2025-06-28 14:25:12'),
(3, 13, 12, '2025-06-28 14:25:15', '2025-06-28 14:25:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `percentage` tinyint(3) UNSIGNED NOT NULL,
  `start_day` date NOT NULL,
  `end_day` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `discounts`
--

INSERT INTO `discounts` (`id`, `name`, `percentage`, `start_day`, `end_day`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'chaomungquockhanh', 29, '2025-09-02', '2025-09-03', '2025-05-15 01:10:57', '2025-06-06 09:16:36', NULL),
(2, 'chucmungsinhnhat', 10, '2025-09-06', '2025-09-09', '2025-05-15 01:13:47', '2025-05-15 01:13:47', NULL),
(3, 'sale25', 25, '2025-06-10', '2025-06-12', '2025-05-15 18:40:48', '2025-06-10 07:46:53', NULL),
(5, 'dreams', 30, '2025-09-02', '2025-09-10', '2025-05-15 18:43:50', '2025-05-15 18:43:50', NULL),
(6, 'Black Friday', 15, '2025-06-06', '2025-06-07', '2025-05-19 20:39:28', '2025-06-06 09:16:58', NULL),
(7, 'TriAnKhachHang', 5, '2025-06-19', '2025-06-20', '2025-06-06 09:36:32', '2025-06-19 09:23:00', NULL),
(8, 'Sale hè', 5, '2025-06-20', '2025-06-25', '2025-06-06 09:39:47', '2025-06-16 08:05:59', NULL),
(9, 'Năm Học Mới', 10, '2025-08-12', '2025-08-15', '2025-06-06 09:42:27', '2025-06-06 09:43:43', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
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
-- Cấu trúc bảng cho bảng `flash_sales`
--

CREATE TABLE `flash_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `flash_sales`
--

INSERT INTO `flash_sales` (`id`, `name`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES
(10, '1/6', '2025-06-05 01:21:00', '2025-06-06 13:21:00', 1, '2025-06-05 06:21:41', '2025-06-05 06:21:41'),
(11, 'Birthday Dreams', '2025-06-16 15:52:00', '2025-06-26 15:52:00', 1, '2025-06-16 08:53:08', '2025-06-16 08:53:08'),
(12, 'SALE SẬP SÀN 7/7', '2025-06-28 20:20:00', '2025-07-12 20:21:00', 1, '2025-06-28 13:21:07', '2025-06-28 13:21:07');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `flash_sale_variants`
--

CREATE TABLE `flash_sale_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `flash_sale_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED NOT NULL,
  `sale_price` int(11) NOT NULL,
  `flash_quantity` int(11) NOT NULL,
  `flash_sold` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `flash_sale_variants`
--

INSERT INTO `flash_sale_variants` (`id`, `flash_sale_id`, `variant_id`, `sale_price`, `flash_quantity`, `flash_sold`, `created_at`, `updated_at`) VALUES
(20, 10, 1, 100000, 12, 0, NULL, '2025-06-05 07:52:53'),
(25, 12, 12, 50000, 1, 0, NULL, NULL),
(26, 12, 41, 2000, 30, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `img`
--

CREATE TABLE `img` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `img`
--

INSERT INTO `img` (`id`, `product_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'sp1.webp', NULL, '2025-05-18 02:02:11'),
(2, 2, 'sp2.webp', NULL, '2025-05-18 02:02:31'),
(3, 3, 'sp3.webp', NULL, '2025-05-18 02:02:42'),
(4, 4, 'sp4.webp', NULL, '2025-05-18 02:02:51'),
(5, 5, 'sp5.webp', NULL, '2025-05-18 02:03:36'),
(6, 6, 'sp6.webp', NULL, '2025-05-18 02:03:43'),
(7, 1, 'sp1_1.webp', NULL, '2025-05-18 02:05:06'),
(8, 1, 'sp1_2.webp', NULL, '2025-05-18 02:05:13'),
(9, 1, 'sp1_3.webp', NULL, '2025-05-18 02:05:21'),
(10, 1, 'sp1_4.webp', NULL, '2025-06-12 06:48:00'),
(11, 2, 'sp2_1.webp', NULL, '2025-05-18 02:06:35'),
(12, 2, 'sp2_2.webp', NULL, '2025-05-18 02:06:42'),
(15, 2, 'sp2_3.webp', NULL, '2025-05-18 02:07:23'),
(16, 2, 'sp2_4.webp', NULL, '2025-05-18 02:07:31'),
(17, 3, 'sp3_1.webp', NULL, '2025-05-18 02:08:46'),
(18, 3, 'sp3_2.webp', NULL, '2025-05-18 02:10:23'),
(19, 3, 'sp3_3.webp', NULL, '2025-05-18 02:10:37'),
(20, 3, 'sp3_4.webp', NULL, '2025-05-18 02:10:45'),
(21, 4, 'sp4_1.webp', NULL, '2025-05-18 02:11:33'),
(22, 4, 'sp4_2.webp', NULL, '2025-05-18 02:11:41'),
(23, 4, 'sp4_3.webp', NULL, '2025-05-18 02:12:36'),
(24, 4, 'sp4_4.webp', NULL, '2025-05-18 02:12:44'),
(25, 5, 'sp5_1.webp', NULL, '2025-05-18 02:12:57'),
(26, 5, 'sp5_2.webp', NULL, '2025-05-18 02:13:10'),
(27, 5, 'sp5_3.webp', NULL, '2025-05-18 02:13:28'),
(28, 5, 'sp5_4.webp', NULL, '2025-05-18 02:13:35'),
(29, 6, 'sp6_1.webp', NULL, '2025-05-18 02:14:26'),
(30, 6, 'sp6_2.webp', NULL, '2025-05-18 02:14:37'),
(31, 6, 'sp6_3.webp', NULL, '2025-05-18 02:14:43'),
(32, 6, 'sp6_4.webp', NULL, '2025-05-18 02:14:48'),
(33, 7, 'sp7.webp', '2025-05-14 19:28:31', '2025-06-12 08:34:41'),
(34, 7, 'sp7_2.webp', '2025-05-14 20:04:58', '2025-05-18 02:15:33'),
(38, 7, '1747645531_toi.jpg', '2025-05-19 02:05:31', '2025-05-19 02:05:31'),
(39, 10, 'z6662967725185_6db12d72cf60605ffee92fc1b02abd71.jpg', '2025-06-06 08:24:40', '2025-06-06 08:24:40'),
(40, 10, 'z6662967738450_36168ae93d404ab2c0a4259f74c02962.jpg', '2025-06-06 08:24:58', '2025-06-06 08:24:58'),
(41, 10, 'z6662967746710_4770cfab0ff9a8361e011ceb4bc18933.jpg', '2025-06-06 08:25:07', '2025-06-06 08:25:07'),
(42, 10, 'z6662967753945_a4bcc2f42d56a440aa62e68c7d736a25.jpg', '2025-06-06 08:25:16', '2025-06-06 08:25:16'),
(43, 10, 'z6662967762499_ee7451a1e1d3babceb712dfebb97d84f.jpg', '2025-06-06 08:25:24', '2025-06-06 08:25:24'),
(44, 11, 'z6697648004779_b26e585f17549dba6001bd492b7aa0c4.jpg', '2025-06-12 07:23:44', '2025-06-12 07:23:44'),
(45, 11, 'z6697648024991_f9781964d84248cec5c5b7173f6eb260.jpg', '2025-06-12 07:23:57', '2025-06-12 07:23:57'),
(46, 11, 'z6697648018258_7ed143dd56705417d2761efb7d86e554.jpg', '2025-06-12 07:24:04', '2025-06-12 07:24:04'),
(47, 11, 'z6697648003114_d7327d4af10da4f101589ec641e8aac2.jpg', '2025-06-12 07:24:19', '2025-06-12 07:24:19'),
(48, 11, 'z6697648014791_38d6eba30b05fd890d6becd26e45b406.jpg', '2025-06-12 07:24:47', '2025-06-12 07:28:30'),
(49, 8, 'sp8.webp', '2025-06-12 08:05:45', '2025-06-12 08:05:45'),
(50, 8, 'sp8_1.webp', '2025-06-12 08:05:52', '2025-06-12 08:05:52'),
(51, 8, 'sp8_2.webp', '2025-06-12 08:05:57', '2025-06-12 08:05:57'),
(52, 8, 'sp8_3.webp', '2025-06-12 08:06:06', '2025-06-12 08:06:06'),
(53, 8, 'sp8_4.webp', '2025-06-12 08:06:16', '2025-06-12 08:06:16'),
(54, 9, 'sp9.webp', '2025-06-12 08:16:52', '2025-06-12 08:16:52'),
(55, 9, 'sp9_1.webp', '2025-06-12 08:16:57', '2025-06-12 08:16:57'),
(56, 9, 'sp9_2.webp', '2025-06-12 08:17:04', '2025-06-12 08:17:04'),
(57, 9, 'sp9_3.webp', '2025-06-12 08:17:15', '2025-06-12 08:17:15'),
(58, 9, 'sp9_4.webp', '2025-06-12 08:17:25', '2025-06-12 08:17:25'),
(59, 7, 'sp7_1.webp', '2025-06-12 08:34:25', '2025-06-12 08:36:21'),
(60, 12, 'sp2.webp', '2025-06-19 07:07:22', '2025-06-25 09:10:15'),
(61, 12, 'sp2_1.webp', '2025-06-19 07:13:47', '2025-06-25 09:10:36'),
(62, 12, 'sp2_3.webp', '2025-06-19 07:15:05', '2025-06-25 09:10:55'),
(63, 13, '1750842339_sp10.webp', '2025-06-25 09:05:39', '2025-06-25 09:05:39'),
(64, 13, '1750842344_sp10_1.webp', '2025-06-25 09:05:44', '2025-06-25 09:05:44'),
(65, 13, '1750842351_sp10_2.webp', '2025-06-25 09:05:51', '2025-06-25 09:05:51'),
(66, 13, '1750842363_sp10_3.webp', '2025-06-25 09:06:03', '2025-06-25 09:06:03'),
(67, 13, '1750842370_sp10_4.webp', '2025-06-25 09:06:10', '2025-06-25 09:06:10'),
(68, 12, '1750842667_sp2_4.webp', '2025-06-25 09:11:07', '2025-06-25 09:11:07'),
(69, 12, '1750842683_sp2_2.webp', '2025-06-25 09:11:23', '2025-06-25 09:11:23');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
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
-- Cấu trúc bảng cho bảng `job_batches`
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
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_05_01_131923_create_discounts_table', 1),
(5, '2025_05_01_132947_create_categories_table', 1),
(6, '2025_05_01_133026_create_payments_table', 1),
(7, '2025_05_01_134443_create_address_table', 1),
(8, '2025_05_01_134843_create_products_table', 1),
(9, '2025_05_01_135148_create_shippings_table', 1),
(10, '2025_05_01_135848_create_notifications', 1),
(11, '2025_05_01_140329_create_reviews_table', 1),
(12, '2025_05_01_140832_create_img_table', 1),
(13, '2025_05_01_141436_create_variant_table', 1),
(14, '2025_05_01_141712_create_coupons_table', 1),
(15, '2025_05_01_142632_create_orders_table', 1),
(16, '2025_05_01_142946_create_order_items_table', 1),
(17, '2025_05_01_144411_create_wishlist_table', 1),
(18, '2025_05_13_063256_create_personal_access_tokens_table', 2),
(19, '2025_05_29_070416_flash__sale', 3),
(20, '2025_05_01_141436_create_variants_table', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `status` enum('read','unread') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `shipping_id` bigint(20) UNSIGNED NOT NULL,
  `discount_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `address_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `total_price` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `vnp_TxnRef` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `order_code`, `user_id`, `shipping_id`, `discount_id`, `payment_id`, `coupon_id`, `address_id`, `status`, `total_price`, `created_at`, `updated_at`, `vnp_TxnRef`) VALUES
(1, NULL, 10, 1, NULL, 2, NULL, 1, 'paid', '1448000', '2025-06-05 08:53:38', '2025-06-13 09:32:24', '68415b1289b3f'),
(2, NULL, 10, 1, NULL, 2, NULL, 1, 'cancelled', '998000', '2025-06-05 08:55:49', '2025-06-10 07:37:12', '68415b9543855'),
(3, NULL, 10, 1, NULL, 2, NULL, 1, 'cancelled', '998000', '2025-06-05 08:57:07', '2025-06-10 02:19:18', '68415be36c61c'),
(4, NULL, 10, 1, NULL, 2, NULL, 1, 'paid', '998000', '2025-06-05 08:57:42', '2025-06-05 08:58:12', '68415c069d83e'),
(5, NULL, 10, 1, NULL, 2, NULL, 1, 'pending', '998000', '2025-06-05 08:58:42', '2025-06-09 06:09:06', '68415c429b3f2'),
(6, NULL, 10, 1, NULL, 2, NULL, 1, 'cancelled', '998000', '2025-06-05 08:59:17', '2025-06-10 02:19:27', '68415c6553506'),
(7, NULL, 10, 1, NULL, 2, NULL, 1, 'cancelled', '499000', '2025-06-05 09:00:50', '2025-06-11 08:25:18', '68415cc2a835b'),
(8, NULL, 10, 1, NULL, 2, NULL, 1, 'paid', '4990000', '2025-06-05 09:28:10', '2025-06-09 06:09:31', '6841632adf687'),
(9, NULL, 10, 1, NULL, 2, NULL, 1, 'paid', '1996000', '2025-06-05 09:31:25', '2025-06-05 09:31:32', '684163ed7d7e6'),
(10, NULL, 10, 1, NULL, 2, NULL, 1, 'cancelled', '3992000', '2025-06-05 09:38:38', '2025-06-11 08:25:43', '6841659e73d1f'),
(13, NULL, 10, 1, NULL, 1, NULL, 1, 'paid', '1497000', '2025-06-06 10:05:27', '2025-06-10 01:47:47', NULL),
(14, NULL, 9, 1, NULL, 2, NULL, 1, 'paid', '976250', '2025-06-10 07:17:31', '2025-06-10 07:18:03', '6847dc0bc0e21'),
(15, NULL, 9, 1, NULL, 2, NULL, 1, 'paid', '1010000', '2025-06-10 07:32:57', '2025-06-10 07:33:18', '6847dfa9160d2'),
(16, NULL, 9, 1, NULL, 2, NULL, 1, 'paid', '499000', '2025-06-10 07:34:42', '2025-06-10 07:34:58', '6847e012522e5'),
(17, NULL, 9, 1, NULL, 2, NULL, 1, 'paid', '620000', '2025-06-11 08:24:30', '2025-06-11 08:24:41', '68493d3ed4a21'),
(18, NULL, 10, 1, NULL, 1, NULL, 1, 'paid', '819000', '2025-06-11 09:56:17', '2025-06-11 09:57:12', '684952c183bad'),
(19, NULL, 10, 1, NULL, 1, NULL, 1, 'paid', '1119000', '2025-06-16 08:30:03', '2025-06-18 04:06:18', '684fd60b8bd25'),
(20, NULL, 10, 1, NULL, 1, NULL, 1, 'pending', '0', '2025-06-19 06:36:24', '2025-06-19 06:36:24', '6853afe82f138'),
(21, NULL, 10, 1, NULL, 1, NULL, 1, 'pending', '0', '2025-06-19 06:36:47', '2025-06-19 06:36:47', '6853afff19784'),
(22, NULL, 10, 1, NULL, 1, NULL, 1, 'pending', '0', '2025-06-19 06:37:38', '2025-06-19 06:37:38', '6853b032110cf'),
(23, NULL, 10, 1, NULL, 1, NULL, 1, 'pending', '0', '2025-06-19 06:39:07', '2025-06-19 06:39:07', '6853b08b8acbf'),
(24, NULL, 10, 1, NULL, 1, NULL, 1, 'pending', '0', '2025-06-19 06:40:01', '2025-06-19 06:40:01', '6853b0c1661ef'),
(25, NULL, 9, 1, NULL, 2, NULL, 7, 'pending', '998000', '2025-06-19 06:45:23', '2025-06-19 06:45:23', '6853b203762fc'),
(26, NULL, 10, 1, NULL, 2, NULL, 7, 'pending', '998000', '2025-06-19 06:46:10', '2025-06-19 06:46:10', '6853b232e12a8'),
(27, NULL, 10, 1, NULL, 2, NULL, 7, 'pending', '998000', '2025-06-19 06:47:09', '2025-06-19 06:47:09', '6853b26d9618f'),
(28, NULL, 10, 1, NULL, 2, NULL, 7, 'paid', '998000', '2025-06-19 06:47:13', '2025-06-19 06:48:21', '6853b271dec7c'),
(29, NULL, 10, 1, NULL, 1, NULL, 1, 'paid', '499000', '2025-06-19 07:24:59', '2025-06-19 07:27:08', '6853bb4b78a88'),
(30, NULL, 10, 1, NULL, 1, NULL, 1, 'cancelled', '499000', '2025-06-19 07:42:18', '2025-06-19 07:43:37', '6853bf5a94c71'),
(31, NULL, 10, 1, NULL, 1, NULL, 1, 'paid', '320000', '2025-06-19 07:45:58', '2025-06-19 07:47:23', '6853c0361117c'),
(32, NULL, 10, 1, NULL, 2, NULL, 7, 'paid', '800000', '2025-06-19 09:01:01', '2025-06-24 07:16:44', '6853d1cd5f687'),
(33, NULL, 10, 1, NULL, 2, NULL, 7, 'pending', '800000', '2025-06-19 09:06:55', '2025-06-19 09:06:55', '6853d32fa1b21'),
(34, NULL, 10, 1, NULL, 2, NULL, 7, 'pending', '800000', '2025-06-19 09:06:57', '2025-06-19 09:06:57', '6853d331505d5'),
(35, NULL, 10, 1, NULL, 2, NULL, 1, 'pending', '400000', '2025-06-19 09:08:11', '2025-06-19 09:08:11', NULL),
(36, NULL, 10, 1, NULL, 1, NULL, 1, 'pending', '400000', '2025-06-19 09:09:08', '2025-06-19 09:09:08', '6853d3b47715a'),
(37, NULL, 10, 1, NULL, 2, NULL, 7, 'pending', '800000', '2025-06-19 09:20:13', '2025-06-19 09:20:13', '6853d64db6861'),
(38, NULL, 10, 1, NULL, 1, NULL, 1, 'pending', '400000', '2025-06-19 09:20:59', '2025-06-19 09:20:59', '6853d67b7ffeb'),
(39, NULL, 10, 1, NULL, 1, NULL, 1, 'pending', '380000', '2025-06-19 09:24:37', '2025-06-19 09:24:37', '6853d755d232e'),
(40, NULL, 10, 1, NULL, 2, NULL, 1, 'cancelled', '1299000', '2025-06-20 03:51:26', '2025-06-20 03:58:50', 'giá trị trả về từ bước 1'),
(41, NULL, 10, 1, NULL, 2, NULL, 1, 'cancelled', '1299000', '2025-06-20 03:55:32', '2025-06-20 03:58:41', NULL),
(42, NULL, 10, 1, NULL, 2, NULL, 7, 'paid', '800000', '2025-06-20 04:17:00', '2025-06-20 06:57:29', '6854e024475f8'),
(43, NULL, 10, 1, NULL, 1, NULL, 1, 'pending', '760000', '2025-06-24 02:00:51', '2025-06-24 02:00:51', '685a064e42d0c'),
(44, NULL, 9, 1, NULL, 2, NULL, 1, 'pending', '640000', '2025-06-24 02:35:30', '2025-06-24 02:35:30', NULL),
(45, NULL, 9, 1, NULL, 1, NULL, 1, 'pending', '640000', '2025-06-24 02:37:08', '2025-06-24 02:37:08', '685a0f2e6da61'),
(46, NULL, 9, 1, NULL, 1, NULL, 1, 'paid', '640000', '2025-06-24 03:06:43', '2025-06-24 07:16:09', '685a1607eb92c'),
(47, NULL, 9, 1, NULL, 2, NULL, 1, 'pending', '640000', '2025-06-24 03:10:10', '2025-06-24 03:10:10', NULL),
(48, NULL, 9, 1, NULL, 2, NULL, 1, 'paid', '1010000', '2025-06-24 03:57:22', '2025-06-24 07:16:53', NULL),
(49, NULL, 9, 1, NULL, 2, NULL, 1, 'pending', '660000', '2025-06-24 03:58:12', '2025-06-24 03:58:12', NULL),
(50, 'COD685A250D1EFC7', 9, 1, NULL, 2, NULL, 1, 'paid', '985000', '2025-06-24 04:09:49', '2025-06-24 07:15:14', NULL),
(51, 'COD685A25B926F7B', 9, 1, NULL, 2, NULL, 1, 'pending', '325000', '2025-06-24 04:12:41', '2025-06-24 04:12:41', NULL),
(52, NULL, 9, 1, NULL, 1, NULL, 1, 'pending', '499000', '2025-06-25 03:10:17', '2025-06-25 03:10:17', '685b687962df9'),
(53, 'COD685B68E37C30F', 9, 1, NULL, 2, NULL, 1, 'paid', '824000', '2025-06-25 03:11:31', '2025-06-25 03:15:36', NULL),
(54, NULL, 9, 1, NULL, 1, NULL, 1, 'paid', '499000', '2025-06-25 03:13:55', '2025-06-25 03:15:29', '685b695a52f17'),
(55, NULL, 10, 1, NULL, 1, NULL, 1, 'pending', '0', '2025-06-26 02:58:11', '2025-06-26 02:58:11', '685cb6fc45ad6'),
(56, NULL, 10, 1, NULL, 1, NULL, 1, 'paid', '320000', '2025-06-26 03:07:48', '2025-06-26 08:26:36', '685cb967393bf'),
(57, NULL, 10, 1, NULL, 1, NULL, 1, 'paid', '330000', '2025-06-26 03:21:06', '2025-06-26 03:38:31', '685cbc8843471'),
(58, 'COD685E10BB2CB75', 10, 1, NULL, 2, NULL, 1, 'paid', '840000', '2025-06-27 03:32:11', '2025-06-27 03:32:51', NULL),
(59, NULL, 10, 1, NULL, 1, NULL, 1, 'paid', '998000', '2025-06-27 04:49:55', '2025-06-27 08:54:20', '685e22b6a3fd0'),
(60, NULL, 13, 1, NULL, 1, NULL, 1, 'pending', '320000', '2025-06-28 13:17:19', '2025-06-28 13:17:19', '685feb3849f55'),
(61, NULL, 13, 1, NULL, 1, 10, 1, 'paid', '2462000', '2025-06-28 14:22:37', '2025-06-28 14:28:14', '685ffa5ce9c66');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `variant_id`, `quantity`, `price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2', '499000', '2025-06-05 08:53:38', '2025-06-05 08:53:38', NULL),
(2, 1, 2, '1', '450000', '2025-06-05 08:53:38', '2025-06-05 08:53:38', NULL),
(3, 2, 4, '2', '499000', '2025-06-05 08:55:49', '2025-06-05 08:55:49', NULL),
(4, 3, 4, '2', '499000', '2025-06-05 08:57:07', '2025-06-05 08:57:07', NULL),
(5, 4, 1, '2', '499000', '2025-06-05 08:57:42', '2025-06-05 08:57:42', NULL),
(6, 5, 1, '2', '499000', '2025-06-05 08:58:42', '2025-06-05 08:58:42', NULL),
(7, 6, 11, '2', '499000', '2025-06-05 08:59:17', '2025-06-05 08:59:17', NULL),
(8, 7, 20, '1', '499000', '2025-06-05 09:00:50', '2025-06-05 09:00:50', NULL),
(9, 8, 20, '10', '499000', '2025-06-05 09:28:10', '2025-06-05 09:28:10', NULL),
(10, 9, 1, '4', '499000', '2025-06-05 09:31:25', '2025-06-05 09:31:25', NULL),
(11, 10, 4, '8', '499000', '2025-06-05 09:38:38', '2025-06-05 09:38:38', NULL),
(12, 13, 1, '2', '499000', '2025-06-06 10:05:27', '2025-06-06 10:05:27', NULL),
(13, 13, 2, '1', '499000', '2025-06-06 10:05:27', '2025-06-06 10:05:27', NULL),
(14, 14, 29, '1', '276250', '2025-06-10 07:17:31', '2025-06-10 07:17:31', NULL),
(15, 14, 11, '2', '350000', '2025-06-10 07:17:31', '2025-06-10 07:17:31', NULL),
(16, 15, 20, '2', '330000', '2025-06-10 07:32:57', '2025-06-10 07:32:57', NULL),
(17, 15, 12, '1', '350000', '2025-06-10 07:32:57', '2025-06-10 07:32:57', NULL),
(18, 16, 3, '1', '499000', '2025-06-10 07:34:42', '2025-06-10 07:34:42', NULL),
(20, 17, 10, '1', '300000', '2025-06-11 08:24:30', '2025-06-11 08:24:30', NULL),
(21, 17, 15, '1', '320000', '2025-06-11 08:24:30', '2025-06-11 08:24:30', NULL),
(22, 18, 1, '1', '499000', '2025-06-11 09:56:17', '2025-06-11 09:56:17', NULL),
(23, 18, 15, '1', '320000', '2025-06-11 09:56:17', '2025-06-11 09:56:17', NULL),
(24, 19, 1, '1', '499000', '2025-06-16 08:30:03', '2025-06-16 08:30:03', NULL),
(25, 19, 15, '1', '320000', '2025-06-16 08:30:03', '2025-06-16 08:30:03', NULL),
(26, 19, 7, '1', '300000', '2025-06-16 08:30:03', '2025-06-16 08:30:03', NULL),
(27, 20, 11, '2', '0', '2025-06-19 06:36:24', '2025-06-19 06:36:24', NULL),
(28, 21, 11, '2', '0', '2025-06-19 06:36:47', '2025-06-19 06:36:47', NULL),
(29, 22, 11, '3', '0', '2025-06-19 06:37:38', '2025-06-19 06:37:38', NULL),
(30, 23, 11, '2', '0', '2025-06-19 06:39:07', '2025-06-19 06:39:07', NULL),
(31, 24, 11, '2', '0', '2025-06-19 06:40:01', '2025-06-19 06:40:01', NULL),
(32, 25, 1, '2', '499000', '2025-06-19 06:45:23', '2025-06-19 06:45:23', NULL),
(34, 26, 1, '2', '499000', '2025-06-19 06:46:10', '2025-06-19 06:46:10', NULL),
(36, 27, 1, '2', '499000', '2025-06-19 06:47:09', '2025-06-19 06:47:09', NULL),
(37, 27, 31, '2', '0', '2025-06-19 06:47:09', '2025-06-19 06:47:09', NULL),
(38, 28, 1, '2', '499000', '2025-06-19 06:47:13', '2025-06-19 06:47:13', NULL),
(39, 28, 31, '2', '0', '2025-06-19 06:47:13', '2025-06-19 06:47:13', NULL),
(40, 29, 1, '1', '499000', '2025-06-19 07:24:59', '2025-06-19 07:24:59', NULL),
(41, 30, 1, '1', '499000', '2025-06-19 07:42:18', '2025-06-19 07:42:18', NULL),
(42, 31, 14, '1', '320000', '2025-06-19 07:45:58', '2025-06-19 07:45:58', NULL),
(43, 37, 1, '2', '400000', '2025-06-19 09:20:13', '2025-06-19 09:20:13', NULL),
(44, 37, 31, '2', '0', '2025-06-19 09:20:13', '2025-06-19 09:20:13', NULL),
(45, 38, 36, '1', '400000', '2025-06-19 09:20:59', '2025-06-19 09:20:59', NULL),
(46, 39, 33, '1', '380000', '2025-06-19 09:24:37', '2025-06-19 09:24:37', NULL),
(47, 40, 1, '2', '400000', '2025-06-20 03:51:26', '2025-06-20 03:51:26', NULL),
(48, 40, 2, '1', '499000', '2025-06-20 03:51:26', '2025-06-20 03:51:26', NULL),
(49, 41, 1, '2', '400000', '2025-06-20 03:55:32', '2025-06-20 03:55:32', NULL),
(50, 41, 2, '1', '499000', '2025-06-20 03:55:32', '2025-06-20 03:55:32', NULL),
(51, 42, 1, '2', '400000', '2025-06-20 04:17:00', '2025-06-20 04:17:00', NULL),
(52, 42, 31, '2', '0', '2025-06-20 04:17:00', '2025-06-20 04:17:00', NULL),
(53, 43, 33, '1', '360000', '2025-06-24 02:00:51', '2025-06-24 02:00:51', NULL),
(54, 43, 36, '1', '400000', '2025-06-24 02:00:51', '2025-06-24 02:00:51', NULL),
(55, 44, 20, '1', '0', '2025-06-24 02:35:30', '2025-06-24 02:35:30', NULL),
(56, 44, 14, '2', '320000', '2025-06-24 02:35:30', '2025-06-24 02:35:30', NULL),
(57, 45, 14, '2', '320000', '2025-06-24 02:37:08', '2025-06-24 02:37:08', NULL),
(58, 45, 20, '1', '0', '2025-06-24 02:37:08', '2025-06-24 02:37:08', NULL),
(59, 46, 14, '2', '320000', '2025-06-24 03:06:43', '2025-06-24 03:06:43', NULL),
(60, 46, 20, '1', '330000', '2025-06-24 03:06:43', '2025-06-24 03:06:43', NULL),
(61, 47, 14, '2', '320000', '2025-06-24 03:10:10', '2025-06-24 03:10:10', NULL),
(62, 47, 20, '1', '0', '2025-06-24 03:10:10', '2025-06-24 03:10:10', NULL),
(63, 48, 20, '2', '330000', '2025-06-24 03:57:22', '2025-06-24 03:57:22', NULL),
(64, 48, 11, '1', '350000', '2025-06-24 03:57:22', '2025-06-24 03:57:22', NULL),
(65, 49, 20, '2', '330000', '2025-06-24 03:58:12', '2025-06-24 03:58:12', NULL),
(66, 50, 20, '2', '330000', '2025-06-24 04:09:49', '2025-06-24 04:09:49', NULL),
(67, 50, 4, '1', '325000', '2025-06-24 04:09:49', '2025-06-24 04:09:49', NULL),
(68, 51, 4, '1', '325000', '2025-06-24 04:12:41', '2025-06-24 04:12:41', NULL),
(69, 52, 1, '1', '499000', '2025-06-25 03:10:17', '2025-06-25 03:10:17', NULL),
(70, 53, 1, '1', '499000', '2025-06-25 03:11:31', '2025-06-25 03:11:31', NULL),
(71, 53, 4, '1', '325000', '2025-06-25 03:11:31', '2025-06-25 03:11:31', NULL),
(72, 54, 1, '1', '499000', '2025-06-25 03:13:55', '2025-06-25 03:13:55', NULL),
(73, 55, 11, '1', '350000', '2025-06-26 02:58:11', '2025-06-26 02:58:11', NULL),
(74, 56, 14, '1', '320000', '2025-06-26 03:07:48', '2025-06-26 03:07:48', NULL),
(75, 57, 21, '1', '330000', '2025-06-26 03:21:06', '2025-06-26 03:21:06', NULL),
(76, 58, 40, '1', '520000', '2025-06-27 03:32:11', '2025-06-27 03:32:11', NULL),
(77, 58, 15, '1', '320000', '2025-06-27 03:32:11', '2025-06-27 03:32:11', NULL),
(78, 59, 2, '1', '499000', '2025-06-27 04:49:55', '2025-06-27 04:49:55', NULL),
(79, 59, 3, '1', '499000', '2025-06-27 04:49:55', '2025-06-27 04:49:55', NULL),
(80, 60, 14, '1', '320000', '2025-06-28 13:17:19', '2025-06-28 13:17:19', NULL),
(81, 61, 14, '8', '320000', '2025-06-28 14:22:37', '2025-06-28 14:22:37', NULL),
(82, 61, 41, '1', '2000', '2025-06-28 14:22:37', '2025-06-28 14:22:37', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('nhatvinh01102000@gmail.com', '1puTecgK', '2025-05-22 20:37:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `payment_method`, `payment_status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Tiền mặt', 'active', NULL, NULL, NULL),
(2, 'VNPAY', 'active', NULL, NULL, NULL),
(3, 'Momo', 'active', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
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
-- Đang đổ dữ liệu cho bảng `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 7, 'admin-token', '7181d4ba560b8bea629460c40fdfda32b09d1d3888c2ce086212957d25a5f053', '[\"*\"]', NULL, NULL, '2025-05-20 02:46:32', '2025-05-20 02:46:32'),
(2, 'App\\Models\\User', 7, 'admin-token', 'e226813ad2b8592cdac832eca0920d1ff1f5fa40db0fd5d5361c44240c597768', '[\"*\"]', NULL, NULL, '2025-05-20 02:47:12', '2025-05-20 02:47:12'),
(3, 'App\\Models\\User', 2, 'admin-token', '2e4df1885cddb73983e4cbd4e3762d76b01b15791f6c4d1bbe50967b78beefdd', '[\"*\"]', NULL, NULL, '2025-05-21 19:12:18', '2025-05-21 19:12:18'),
(4, 'App\\Models\\User', 7, 'admin-token', 'eb516b50eb467a7e0e0152c8b7d126eea4fe979e895d2d26a3c2f1d44009dfe5', '[\"*\"]', NULL, NULL, '2025-05-21 19:12:48', '2025-05-21 19:12:48'),
(5, 'App\\Models\\User', 2, 'admin-token', '95f5bcda6581a282238a2d25152f5c1809d8664fbf2885f10afc0dcb8c919444', '[\"*\"]', NULL, NULL, '2025-05-21 19:16:25', '2025-05-21 19:16:25'),
(6, 'App\\Models\\User', 7, 'admin-token', 'a47733d0ab6d4b983d632ff8c913e7ca2a1b72578a8960bc23161b6b246a9a8b', '[\"*\"]', NULL, NULL, '2025-05-21 19:16:40', '2025-05-21 19:16:40'),
(7, 'App\\Models\\User', 2, 'admin-token', '3145ec0a5531163c5f4a6cddca0ac493c84a346df8812736f54f9d97e44c69ac', '[\"*\"]', NULL, NULL, '2025-05-21 19:44:52', '2025-05-21 19:44:52'),
(8, 'App\\Models\\User', 7, 'admin-token', '66e9ba5c644d6ef5fe82ccbc599760dd8ca343184c5c42b9834417c4c5f859a1', '[\"*\"]', NULL, NULL, '2025-05-22 01:23:57', '2025-05-22 01:23:57'),
(9, 'App\\Models\\User', 7, 'admin-token', 'cbb3eb92a5dd64974ae659989525b97b538b6c8450162321401861fcbff72d1c', '[\"*\"]', NULL, NULL, '2025-05-22 01:48:09', '2025-05-22 01:48:09'),
(10, 'App\\Models\\User', 7, 'admin-token', 'ef95fd65ad7472e4df2223301c7d129cf8ee3fa2aea42742f1958a5812aa6a96', '[\"*\"]', NULL, NULL, '2025-05-22 02:01:31', '2025-05-22 02:01:31'),
(11, 'App\\Models\\User', 7, 'admin-token', '25f54abfcf61f2d61b622a820c020e5fb8c5cdaee8f6bdb1e555156d0aeb5fef', '[\"*\"]', NULL, NULL, '2025-05-22 02:06:33', '2025-05-22 02:06:33'),
(12, 'App\\Models\\User', 7, 'admin-token', 'bcdc3325aa6a69f978dceeb16dcced200002e986be324842b436cca41ec51378', '[\"*\"]', NULL, NULL, '2025-05-22 23:17:22', '2025-05-22 23:17:22'),
(13, 'App\\Models\\User', 7, 'admin-token', 'e92ba76fd7cd684a1a4bd46221976f9181420d7da7ff1e47e667d14c7d468049', '[\"*\"]', NULL, NULL, '2025-05-22 23:22:04', '2025-05-22 23:22:04'),
(14, 'App\\Models\\User', 7, 'admin-token', 'c701262f7298109c0e9bac1e354b3af75a6daf3601867f36ae99200bc002bf18', '[\"*\"]', NULL, NULL, '2025-05-22 23:23:14', '2025-05-22 23:23:14'),
(15, 'App\\Models\\User', 7, 'admin-token', '97c34e45aa240707e1434d3e849165648d6f2ba238eb24cc5e4b4d2563435bb4', '[\"*\"]', NULL, NULL, '2025-05-22 23:25:07', '2025-05-22 23:25:07'),
(16, 'App\\Models\\User', 7, 'admin-token', '3cdffab845e18ed1679305b3b5c34e8c17a36fb929d1a13eb9369b770a7a18be', '[\"*\"]', NULL, NULL, '2025-05-22 23:31:06', '2025-05-22 23:31:06'),
(17, 'App\\Models\\User', 7, 'admin-token', '6ce1ff9b010042215bbd5182ee5776ca3ce32b26fca2ae686387d12b05897482', '[\"*\"]', NULL, NULL, '2025-05-23 19:32:00', '2025-05-23 19:32:00'),
(18, 'App\\Models\\User', 7, 'admin-token', '01b4ea338162ef61f39c7aa51ddcb1bf4c17851d324041ef8ca2ce33a836de95', '[\"*\"]', NULL, NULL, '2025-05-23 19:48:27', '2025-05-23 19:48:27'),
(19, 'App\\Models\\User', 2, 'API Token', '0b6767fc3793ba0c43ede3be248b42f5dc5063556aed1a20a4c79e582ad6b531', '[\"*\"]', '2025-05-29 00:21:14', NULL, '2025-05-29 00:18:34', '2025-05-29 00:21:14'),
(20, 'App\\Models\\User', 2, 'API Token', 'f02756b189b95b09cff48dd883cc9b88dd53101b8fa26bfed1944beff34e1112', '[\"*\"]', '2025-05-29 00:38:46', NULL, '2025-05-29 00:31:43', '2025-05-29 00:38:46'),
(21, 'App\\Models\\User', 7, 'admin-token', 'f0b399dac98fe0b13d1abeeab9ed8b2a7889155b496e8097d6de491bd8913d7b', '[\"*\"]', NULL, NULL, '2025-05-29 23:48:32', '2025-05-29 23:48:32'),
(23, 'App\\Models\\User', 7, 'admin-token', '3471016365b27b018fba4219c9bef230d56ddf1167be73c9da14f2d74102b6bf', '[\"*\"]', NULL, NULL, '2025-05-31 02:19:45', '2025-05-31 02:19:45'),
(24, 'App\\Models\\User', 7, 'admin-token', '308198af52b5b91528a0861e351d7461399ecb3351ee8225803e5e5b2b9be6ed', '[\"*\"]', NULL, NULL, '2025-05-31 02:19:50', '2025-05-31 02:19:50'),
(25, 'App\\Models\\User', 7, 'admin-token', 'f081b0d827218bdee07e5bccb168eb759f0a7dae0763d3f30075a4aaff989cac', '[\"*\"]', NULL, NULL, '2025-06-01 13:20:41', '2025-06-01 13:20:41'),
(26, 'App\\Models\\User', 7, 'admin-token', 'b02d7295ee0208f424ea746177b5d3b58d3d49aab30278aa4c4aad06bc828829', '[\"*\"]', NULL, NULL, '2025-06-01 14:17:36', '2025-06-01 14:17:36'),
(27, 'App\\Models\\User', 2, 'admin-token', '1aa4bdd64a8b71b2c56ba1d11ba2def5ac25158370994641a540a7af758d421b', '[\"*\"]', NULL, NULL, '2025-06-02 00:53:13', '2025-06-02 00:53:13'),
(28, 'App\\Models\\User', 2, 'admin-token', 'ff896f36f4ffcea760c7e89c86d5587c6fddf093cd217058dcf0340d942cb0f7', '[\"*\"]', NULL, NULL, '2025-06-03 01:04:10', '2025-06-03 01:04:10'),
(29, 'App\\Models\\User', 3, 'API Token', '39cb7cc43fa607d487da1d68e05315e5944d4af0175e02e3225b11ca4dd5fa93', '[\"*\"]', '2025-06-03 02:44:41', NULL, '2025-06-03 02:30:13', '2025-06-03 02:44:41'),
(30, 'App\\Models\\User', 2, 'admin-token', 'ff79822e584df693337909ac7554cb1f0b3d861514242910abb59b26023901cb', '[\"*\"]', NULL, NULL, '2025-06-03 03:07:07', '2025-06-03 03:07:07'),
(31, 'App\\Models\\User', 3, 'API Token', '1abab11bb39fcc8f890ce086b92e9518538c1474026272d8387b6278f9f33698', '[\"*\"]', '2025-06-03 04:09:35', NULL, '2025-06-03 03:42:02', '2025-06-03 04:09:35'),
(32, 'App\\Models\\User', 3, 'API Token', 'b4a024b14e29b70d4a5efd0a8decf291e5ae16cef3a26575f4dd81bb8142e6ac', '[\"*\"]', NULL, NULL, '2025-06-03 03:51:47', '2025-06-03 03:51:47'),
(33, 'App\\Models\\User', 3, 'API Token', '2731c22c344c9f48e575fbbb0d03494ba36b853ed6f85b5236db0358b31fd132', '[\"*\"]', NULL, NULL, '2025-06-03 03:54:30', '2025-06-03 03:54:30'),
(34, 'App\\Models\\User', 3, 'API Token', '3dc199d9a2db5034075db69e5c893c9c72d658648b2971009c70483bc818d7f7', '[\"*\"]', NULL, NULL, '2025-06-03 04:04:48', '2025-06-03 04:04:48'),
(35, 'App\\Models\\User', 3, 'API Token', 'dbc6ea26ab29ec7f8808668a4b48b9c61d4b5f7dee2fa4dece059bb594b24940', '[\"*\"]', NULL, NULL, '2025-06-03 04:10:01', '2025-06-03 04:10:01'),
(36, 'App\\Models\\User', 3, 'API Token', '3b7fa55e145a684721461e78a439ca49ef30fc68a12c249d1caeb25eb9d0ca48', '[\"*\"]', NULL, NULL, '2025-06-03 04:10:05', '2025-06-03 04:10:05'),
(37, 'App\\Models\\User', 3, 'API Token', '142faf75444739329d3f88959399b9d1a2c15802db53aaaf62c870fad8860473', '[\"*\"]', NULL, NULL, '2025-06-03 04:10:07', '2025-06-03 04:10:07'),
(38, 'App\\Models\\User', 3, 'API Token', '7c6e3942c9db67c708019dbec45b819e7a178344f35844dd1ff3c1be0548589b', '[\"*\"]', NULL, NULL, '2025-06-03 04:10:07', '2025-06-03 04:10:07'),
(39, 'App\\Models\\User', 3, 'API Token', 'a956b68ce61300b8c33f31a015e1cd1f6a97f650b5877d65879c71755b27549b', '[\"*\"]', NULL, NULL, '2025-06-03 04:10:08', '2025-06-03 04:10:08'),
(40, 'App\\Models\\User', 3, 'API Token', '94b89eb83a4b778c05b497c7ccf8403054d847699dd5ff3031003a734a7a83cb', '[\"*\"]', '2025-06-03 04:25:06', NULL, '2025-06-03 04:10:18', '2025-06-03 04:25:06'),
(41, 'App\\Models\\User', 2, 'admin-token', '48c01b4839110705915f73827cb4e49dc3fe49330cb696127e0843d8ef3a7bc7', '[\"*\"]', NULL, NULL, '2025-06-03 06:20:29', '2025-06-03 06:20:29'),
(42, 'App\\Models\\User', 7, 'admin-token', 'c37fc06887c7208954f9ccd631773bc4743f4cb7a46be5455bbf98a516f994e1', '[\"*\"]', NULL, NULL, '2025-06-03 06:30:13', '2025-06-03 06:30:13'),
(43, 'App\\Models\\User', 10, 'API Token', '82da8ced4a35d7332eb89d32584a342992ca9bf601fd7423cc8eb348ea5f9a05', '[\"*\"]', '2025-06-05 03:51:56', NULL, '2025-06-04 02:21:52', '2025-06-05 03:51:56'),
(44, 'App\\Models\\User', 2, 'admin-token', 'd48ffe79bd1c598c3a0100e43c79c11ee65cb2b7de195477903e4e9faed004ca', '[\"*\"]', NULL, NULL, '2025-06-04 02:47:05', '2025-06-04 02:47:05'),
(45, 'App\\Models\\User', 2, 'admin-token', '4a131f11d4a3a3281e2f1f204e656002205f5aef6c2d694f0d4e6b0a65f21a13', '[\"*\"]', NULL, NULL, '2025-06-04 06:04:27', '2025-06-04 06:04:27'),
(46, 'App\\Models\\User', 2, 'admin-token', '4a57520cd228706f91ae796ddc78ff720372b92edcfdf37a31d2fd6dfa0fcf86', '[\"*\"]', NULL, NULL, '2025-06-05 01:19:11', '2025-06-05 01:19:11'),
(47, 'App\\Models\\User', 2, 'admin-token', 'aa1bdc0150bf3f572f4b7aa3e9139a4f4a9296432ccb2c8dfc82b42517ffae1a', '[\"*\"]', NULL, NULL, '2025-06-05 01:25:38', '2025-06-05 01:25:38'),
(48, 'App\\Models\\User', 2, 'admin-token', '48251e1200aef180ec7498c413d31902ef930c410356e33e0144491c55d5e1ef', '[\"*\"]', NULL, NULL, '2025-06-05 02:06:30', '2025-06-05 02:06:30'),
(49, 'App\\Models\\User', 10, 'API Token', 'b05152d58f4467a433695e895f440725be2a947b8e4bc6ccfabeef5991a13fbb', '[\"*\"]', '2025-06-05 09:38:38', NULL, '2025-06-05 08:52:50', '2025-06-05 09:38:38'),
(50, 'App\\Models\\User', 2, 'admin-token', '0a564411340c6bb73a8eb6e636d218fea720ca435f4e70c0c8c341de67009ac3', '[\"*\"]', NULL, NULL, '2025-06-06 01:20:03', '2025-06-06 01:20:03'),
(51, 'App\\Models\\User', 10, 'API Token', '439772e3bfbf5318f95ab08d05efc661c02fb3ddf28922906f92fa2cccb81d81', '[\"*\"]', NULL, NULL, '2025-06-06 01:52:48', '2025-06-06 01:52:48'),
(52, 'App\\Models\\User', 10, 'API Token', '6c760bbd642d277a4d699185a189783e2fd93aca71055a54639963d1403b7a53', '[\"*\"]', '2025-06-06 02:06:19', NULL, '2025-06-06 01:53:39', '2025-06-06 02:06:19'),
(53, 'App\\Models\\User', 7, 'admin-token', '8cde32e481568f9901106f0baf95af26fc97a3d15163192e8cfa3a81b6f7c130', '[\"*\"]', NULL, NULL, '2025-06-06 08:16:59', '2025-06-06 08:16:59'),
(54, 'App\\Models\\User', 7, 'admin-token', '1c17611ff241fbeb609a7e8125cb31d49d813cbb32a06eda367af890679c92ce', '[\"*\"]', NULL, NULL, '2025-06-06 09:41:58', '2025-06-06 09:41:58'),
(55, 'App\\Models\\User', 10, 'API Token', '5950e13ca8acb21689bb0a94259376e23bfacc03ab19cad80b5f49c1dbb110b8', '[\"*\"]', '2025-06-06 10:05:27', NULL, '2025-06-06 10:03:15', '2025-06-06 10:05:27'),
(56, 'App\\Models\\User', 7, 'admin-token', 'ee83d679b133aab847d1a748acbb28741e5e7aea62a7bdeb1b1a0bad094c615a', '[\"*\"]', NULL, NULL, '2025-06-09 06:08:25', '2025-06-09 06:08:25'),
(57, 'App\\Models\\User', 7, 'admin-token', '3ef5cac83930af236d6f34df73554377eb037d7324bf1478b092800c5248d48c', '[\"*\"]', NULL, NULL, '2025-06-09 10:01:57', '2025-06-09 10:01:57'),
(58, 'App\\Models\\User', 7, 'admin-token', 'd79241970fbb2e5981dbcb1846df342bb5ae4784ce774edbd17004992c11acd0', '[\"*\"]', NULL, NULL, '2025-06-10 01:24:55', '2025-06-10 01:24:55'),
(59, 'App\\Models\\User', 7, 'admin-token', '8418c80093108d3c8b7a2f0c6d1378f063abb756880e89c5d08ee670111fc6e0', '[\"*\"]', NULL, NULL, '2025-06-10 01:25:32', '2025-06-10 01:25:32'),
(60, 'App\\Models\\User', 7, 'admin-token', 'e1221a08e2c40273265ba87f577d4b7a96ed9fce8c87e8a9653a354ecc74ffb0', '[\"*\"]', NULL, NULL, '2025-06-10 06:14:58', '2025-06-10 06:14:58'),
(61, 'App\\Models\\User', 9, 'API Token', '76359c3820b93fbe52e6fe8839a094d3478e195781187a90c221634ced4fc373', '[\"*\"]', '2025-06-19 06:45:23', NULL, '2025-06-10 07:16:05', '2025-06-19 06:45:23'),
(62, 'App\\Models\\User', 7, 'admin-token', '17b088be1056198010acbdcee28f46ab40a0be06445d7976406bfef929f58917', '[\"*\"]', NULL, NULL, '2025-06-11 07:46:28', '2025-06-11 07:46:28'),
(63, 'App\\Models\\User', 10, 'API Token', 'a2f52568f4b5c192fde4e603a8f9b30ca7242a5168d87887cad5b1d686f469a7', '[\"*\"]', '2025-06-16 09:32:26', NULL, '2025-06-11 09:53:31', '2025-06-16 09:32:26'),
(64, 'App\\Models\\User', 7, 'admin-token', '6ddc49cd217f8400719e563f770332f2e97864a51a63ec5f73275252b831cfa3', '[\"*\"]', NULL, NULL, '2025-06-12 02:41:57', '2025-06-12 02:41:57'),
(65, 'App\\Models\\User', 7, 'admin-token', '92e9e0d5a0c26bb429096de31b48ebb735aad7d89bcfabab54776909edac8705', '[\"*\"]', NULL, NULL, '2025-06-12 06:15:10', '2025-06-12 06:15:10'),
(66, 'App\\Models\\User', 7, 'admin-token', 'b7428ca1dc231000f279090a701a088662dd42adb04d482f935d110ef236f14c', '[\"*\"]', NULL, NULL, '2025-06-12 08:39:11', '2025-06-12 08:39:11'),
(67, 'App\\Models\\User', 7, 'admin-token', '183af4ba712141d66ee8e045dd366c11bfc6ac3db63198db77af7b6f33d58f37', '[\"*\"]', NULL, NULL, '2025-06-12 08:42:06', '2025-06-12 08:42:06'),
(68, 'App\\Models\\User', 7, 'admin-token', '55fa5b7ef6a30fcc4618b92184cb048ac5820c54c50ad9483a0ce77b18ebadea', '[\"*\"]', NULL, NULL, '2025-06-12 09:19:08', '2025-06-12 09:19:08'),
(69, 'App\\Models\\User', 7, 'admin-token', '7b222e23bf622b18b8042d3d03df38cfb7361c45ffa9f2e4e7ba931d68cb7a1f', '[\"*\"]', NULL, NULL, '2025-06-12 09:28:21', '2025-06-12 09:28:21'),
(70, 'App\\Models\\User', 7, 'admin-token', '7c99ffc34689d3fa6ca843110b2c04c32fa6cb97c5b5cd8cb71378e11847b88b', '[\"*\"]', NULL, NULL, '2025-06-13 01:29:31', '2025-06-13 01:29:31'),
(71, 'App\\Models\\User', 9, 'API Token', '5b7a6f9b8f48c889952a0ce3c8343d4c525f423ef0341d12217897ab24ce2599', '[\"*\"]', NULL, NULL, '2025-06-13 02:06:54', '2025-06-13 02:06:54'),
(72, 'App\\Models\\User', 9, 'API Token', '050cb971ecd98b2212544274825f97483e31481b79306ae190f0b300dbf911bf', '[\"*\"]', NULL, NULL, '2025-06-13 02:26:24', '2025-06-13 02:26:24'),
(73, 'App\\Models\\User', 9, 'API Token', '2ab9df06581fdb2a47d5d57f49d16dc43bb7198087a72d056932af2e420f40c1', '[\"*\"]', NULL, NULL, '2025-06-13 02:29:36', '2025-06-13 02:29:36'),
(74, 'App\\Models\\User', 9, 'API Token', '475397a3734ea0141701f5da2ad1812cdad645f68e851cdfed41b6fa120bdcd7', '[\"*\"]', '2025-06-13 07:22:52', NULL, '2025-06-13 02:36:25', '2025-06-13 07:22:52'),
(75, 'App\\Models\\User', 7, 'admin-token', 'c46c282a2124e963ef7b7df6228d11f27db6de476dbf32377fb9bc21d85ded20', '[\"*\"]', NULL, NULL, '2025-06-13 06:19:00', '2025-06-13 06:19:00'),
(76, 'App\\Models\\User', 7, 'admin-token', 'e91174a265b05d6cc9fdf30c20b43d2b4850fbd1d9e7159d7877597855b81578', '[\"*\"]', NULL, NULL, '2025-06-13 06:31:21', '2025-06-13 06:31:21'),
(77, 'App\\Models\\User', 9, 'API Token', 'a27c3f50f01edaa81a97138c7300064ca0d4837a7f3e4f3ee0a45bc2cd99bd65', '[\"*\"]', '2025-06-13 08:28:40', NULL, '2025-06-13 07:29:45', '2025-06-13 08:28:40'),
(78, 'App\\Models\\User', 7, 'admin-token', '4500fedbe3a5bea60c3165c83fd797f119a3e5267a0f38c3cf91dd14f0d5ea0c', '[\"*\"]', NULL, NULL, '2025-06-16 02:04:06', '2025-06-16 02:04:06'),
(79, 'App\\Models\\User', 7, 'admin-token', 'e8da95479dd7d8e26ebcac02eb0dae17a2a1450ebfb9c413925197b3014ec3d2', '[\"*\"]', NULL, NULL, '2025-06-16 06:52:43', '2025-06-16 06:52:43'),
(80, 'App\\Models\\User', 7, 'admin-token', '5ced254009ce55cc3fdd5a6562f62e644bb9c774cbcbbd4a530b3df275152b00', '[\"*\"]', NULL, NULL, '2025-06-17 01:38:20', '2025-06-17 01:38:20'),
(81, 'App\\Models\\User', 7, 'admin-token', '6e7c8b3c31e59a3779efdb38513b5a2d8d91239c036f1a8a1c9799084c0ac1bf', '[\"*\"]', NULL, NULL, '2025-06-17 01:40:53', '2025-06-17 01:40:53'),
(82, 'App\\Models\\User', 7, 'admin-token', '4987076b03870275220ba0c878af98a0ea3352405e11eb0726937f874db385b9', '[\"*\"]', NULL, NULL, '2025-06-17 08:27:53', '2025-06-17 08:27:53'),
(83, 'App\\Models\\User', 7, 'admin-token', '69ca95a8512bf25d4d4de99cbb1156f5c8518a0705dcd71db53e162103658f7b', '[\"*\"]', NULL, NULL, '2025-06-18 01:55:42', '2025-06-18 01:55:42'),
(84, 'App\\Models\\User', 7, 'admin-token', '08d33cdc2911009e5fb5e6ce71ab9e50f6159fb5bb13534c8bdd44f3af2df618', '[\"*\"]', NULL, NULL, '2025-06-18 06:35:41', '2025-06-18 06:35:41'),
(85, 'App\\Models\\User', 7, 'admin-token', 'f5df281395c674409731e4cd9bf568162016f41afc69809da60213f9974adfb1', '[\"*\"]', NULL, NULL, '2025-06-19 01:49:38', '2025-06-19 01:49:38'),
(86, 'App\\Models\\User', 7, 'admin-token', 'e505f3be4f56116287f4b5daffb9270f3f000f0b83cc445d4eb9a0e243dfa744', '[\"*\"]', NULL, NULL, '2025-06-19 03:13:26', '2025-06-19 03:13:26'),
(87, 'App\\Models\\User', 7, 'admin-token', 'd1c32cf6f3e04d0f9e0ba42f93b2c55cd3135995898525f4d5afb0b66f3b9902', '[\"*\"]', NULL, NULL, '2025-06-19 06:07:42', '2025-06-19 06:07:42'),
(88, 'App\\Models\\User', 10, 'API Token', '11a01709c7828fdeae84544ed9968438817e21a81d44471534640d4e51adfe42', '[\"*\"]', '2025-06-19 06:39:27', NULL, '2025-06-19 06:33:34', '2025-06-19 06:39:27'),
(89, 'App\\Models\\User', 10, 'API Token', 'b77678d05f162ac232a2c90b3d4ddc1db69dfbbbb8d85fe0c9046dab0e563f46', '[\"*\"]', '2025-06-19 08:25:34', NULL, '2025-06-19 06:39:39', '2025-06-19 08:25:34'),
(90, 'App\\Models\\User', 10, 'API Token', 'c909a7cf4c8d91d268ec38a7ef47e67f31254146aead578b29d8ebe8253e66c9', '[\"*\"]', '2025-06-19 06:47:13', NULL, '2025-06-19 06:45:57', '2025-06-19 06:47:13'),
(91, 'App\\Models\\User', 7, 'admin-token', '3aa7db369e2db1206334544a6b642706a8b669343b952c5511f3d0dd94b9993e', '[\"*\"]', NULL, NULL, '2025-06-19 08:26:38', '2025-06-19 08:26:38'),
(92, 'App\\Models\\User', 10, 'API Token', 'e8af2cccee4e7698aadc72e4863c4ac0181cfc71170817a12f60bc44aed791cf', '[\"*\"]', '2025-06-24 02:34:19', NULL, '2025-06-19 08:27:05', '2025-06-24 02:34:19'),
(93, 'App\\Models\\User', 10, 'API Token', '1c0173c6d2a988ce441da33527ed251a1729b4c93af93bcfb65f66403d14fff2', '[\"*\"]', '2025-06-19 09:20:13', NULL, '2025-06-19 08:30:29', '2025-06-19 09:20:13'),
(94, 'App\\Models\\User', 7, 'admin-token', 'f9f7b0d104a66264612548eb51b625a34d5de0bd12d8439ffa01413d91c7b098', '[\"*\"]', NULL, NULL, '2025-06-20 01:54:11', '2025-06-20 01:54:11'),
(95, 'App\\Models\\User', 10, 'API Token', 'c474c6dd9828fe153bb0e0456c94a18610d7819bf1722562c3f1cc085156af0b', '[\"*\"]', '2025-06-20 04:17:00', NULL, '2025-06-20 03:36:06', '2025-06-20 04:17:00'),
(96, 'App\\Models\\User', 7, 'admin-token', 'a1ea74e027163a7b920f048e57b4b0996f7bcf85e52182ff8397b4f57d36ca6e', '[\"*\"]', NULL, NULL, '2025-06-20 03:52:00', '2025-06-20 03:52:00'),
(97, 'App\\Models\\User', 7, 'admin-token', '649d69f77bf7463e3c24ed207951ec55d634af8c1d79e54cc6f26224e98f6747', '[\"*\"]', NULL, NULL, '2025-06-20 06:21:31', '2025-06-20 06:21:31'),
(98, 'App\\Models\\User', 10, 'API Token', 'aab5c530b366c4f3ce8159cc66a403bd3ff6f4fc279cd56778382d7f351fff6b', '[\"*\"]', '2025-06-20 08:37:20', NULL, '2025-06-20 08:05:55', '2025-06-20 08:37:20'),
(99, 'App\\Models\\User', 9, 'API Token', '014da4045a8c692dc893cdc46304971b85c18525bc521458aaf0074fd8db6d8e', '[\"*\"]', '2025-06-20 08:38:24', NULL, '2025-06-20 08:37:31', '2025-06-20 08:38:24'),
(100, 'App\\Models\\User', 7, 'admin-token', '403288fe70a7fc38df8bb685e8ef48910471f843fd2150c594c05beae6180412', '[\"*\"]', NULL, NULL, '2025-06-23 07:13:59', '2025-06-23 07:13:59'),
(101, 'App\\Models\\User', 7, 'admin-token', '9ca7605825aad1baf6e4c09b293d0446c9805364cb148a9aaea708bbf49de1ea', '[\"*\"]', NULL, NULL, '2025-06-24 02:01:44', '2025-06-24 02:01:44'),
(102, 'App\\Models\\User', 9, 'API Token', '39fe680904e88db6dc175895250a2c5736cd6ff193454d21d215b549dd567ece', '[\"*\"]', '2025-06-26 02:56:12', NULL, '2025-06-24 02:34:28', '2025-06-26 02:56:12'),
(103, 'App\\Models\\User', 7, 'admin-token', '66d9d0be70c62bcfd2116ac302f6766e141662f1591140fd7e5bcd4a887a0bcd', '[\"*\"]', NULL, NULL, '2025-06-24 06:41:20', '2025-06-24 06:41:20'),
(104, 'App\\Models\\User', 7, 'admin-token', '676cc63b8fc3668ccd0589106cb7d3071919ecdece42f872d5f1f4f008c74d43', '[\"*\"]', NULL, NULL, '2025-06-24 08:59:09', '2025-06-24 08:59:09'),
(105, 'App\\Models\\User', 7, 'admin-token', 'e5d77b5d3fb84b23cb998fa09eb4ca836706b623089ba827d267c567bf3b8229', '[\"*\"]', NULL, NULL, '2025-06-24 09:05:29', '2025-06-24 09:05:29'),
(106, 'App\\Models\\User', 7, 'admin-token', 'f9b7d291d2169f641d3c711df32f116d4a7903908985365d6a1883099f33788c', '[\"*\"]', NULL, NULL, '2025-06-25 03:15:15', '2025-06-25 03:15:15'),
(107, 'App\\Models\\User', 7, 'admin-token', '85d56723236fe16ce67f1e54dfb75005395f06fa74d8f32982f6a3d7c320c5d8', '[\"*\"]', NULL, NULL, '2025-06-25 08:53:41', '2025-06-25 08:53:41'),
(108, 'App\\Models\\User', 7, 'admin-token', 'd7029d8e286fa6760f867ea81fc0d16d8ade2bb7615bdebf2e0c172a433f1d84', '[\"*\"]', NULL, NULL, '2025-06-26 02:11:28', '2025-06-26 02:11:28'),
(109, 'App\\Models\\User', 10, 'API Token', '22305ff5abf53d7752e8f584a99a4c0cb401beac4d8abc3397d5b0cd05d00019', '[\"*\"]', '2025-06-27 04:50:12', NULL, '2025-06-26 02:56:21', '2025-06-27 04:50:12'),
(110, 'App\\Models\\User', 7, 'admin-token', '4be3b8b28852762c1b2b612c50cca378ec4a837caa8426b4ab206fc58667972d', '[\"*\"]', NULL, NULL, '2025-06-26 07:45:03', '2025-06-26 07:45:03'),
(111, 'App\\Models\\User', 7, 'admin-token', 'bc79f8597a33680b0f2b771a9e628e87779b686deeed9c1e93f19414e74aa52a', '[\"*\"]', NULL, NULL, '2025-06-27 03:16:25', '2025-06-27 03:16:25'),
(112, 'App\\Models\\User', 7, 'admin-token', '31039cd65e49a2cc8a3a80bda5feb42bec0264e3513ef1dca66eab43911a76ed', '[\"*\"]', NULL, NULL, '2025-06-27 07:20:10', '2025-06-27 07:20:10'),
(113, 'App\\Models\\User', 7, 'admin-token', '3e7767aabe4617d8a6ad7b5abc966407aec734199e50ce66bfb7705ca8a50e1c', '[\"*\"]', NULL, NULL, '2025-06-27 09:43:40', '2025-06-27 09:43:40'),
(114, 'App\\Models\\User', 11, 'API Token', 'dd20df8d3bf4029ad3163f2727610b6133074aa24c986ef11705eb837a7e9b90', '[\"*\"]', '2025-06-28 13:07:46', NULL, '2025-06-28 13:07:21', '2025-06-28 13:07:46'),
(115, 'App\\Models\\User', 12, 'google_token', 'e0242f66d19c419e414f56772f0ecb2c1d76d05088b0fbf7e6209138aa12b90b', '[\"*\"]', NULL, NULL, '2025-06-28 13:09:27', '2025-06-28 13:09:27'),
(116, 'App\\Models\\User', 13, 'API Token', '3d02b6b7ba4dbcbdbb8487ea73721dbfc3bfc24c84f0783d1af1c7e09afb2779', '[\"*\"]', '2025-06-28 14:34:45', NULL, '2025-06-28 13:16:25', '2025-06-28 14:34:45'),
(117, 'App\\Models\\User', 7, 'admin-token', '194f7c7ae305b523d5b5cab14d6c75d8082b4a769670afc59dd5f3bb663af61b', '[\"*\"]', NULL, NULL, '2025-06-28 13:19:04', '2025-06-28 13:19:04'),
(118, 'App\\Models\\User', 13, 'API Token', '18e9a3a38dff0edf7c446a8e5f73b50a4b4ef64e891eb50001e9b5c20028c10b', '[\"*\"]', '2025-06-28 14:38:29', NULL, '2025-06-28 14:36:54', '2025-06-28 14:38:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `style_tags` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `discount_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `view` varchar(255) DEFAULT NULL,
  `hot` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `active` enum('on','off') DEFAULT 'on'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `style_tags`, `category_id`, `discount_id`, `description`, `status`, `view`, `hot`, `created_at`, `updated_at`, `deleted_at`, `active`) VALUES
(1, 'Bomber Overlock Jacket', NULL, 1, NULL, 'Bomber Overlock Jacket, thiết kế dày dặn mang cảm giác mạnh mẽ, siêu hack dáng', 'còn hàng', NULL, '29', NULL, '2025-06-27 08:54:20', NULL, 'on'),
(2, 'Love Viet Nam Boxy T-Shirt', NULL, 2, NULL, 'Love Viet Nam Boxy T-Shirt, form rộng, thoải mái, chất vải thấm hút mồ hôi', 'còn hàng', NULL, '17', NULL, '2025-06-25 03:15:36', NULL, 'on'),
(3, 'Line Wave Jacket', 'unisex', 1, 9, 'Line Wave Jacket, sản phẩm mới nhất và được săn đón nhất hiện nay, phù hợp mặc cho cả đông lẫn hè, đa năng trong mọi lúc', 'còn hàng', NULL, '7', NULL, '2025-06-24 07:16:53', NULL, 'on'),
(4, 'Parachute Cargo Pants', NULL, 3, NULL, 'Parachute Cargo Pants, phong cách bụi bặm, chất nhất cho mùa hè này', 'còn hàng', NULL, '14', NULL, '2025-06-28 14:28:14', NULL, 'on'),
(5, 'Parachute Cargo Pants Ver 2', NULL, 3, 9, 'Parachute Cargo Pants Ver 2, một phiên bản chiến hơn. Nếu bạn là tín đồ của thời trang đường phố thì chiếc Parachute Cargo Pants Ver 2 là dành cho bạn', 'còn hàng', NULL, '31', NULL, '2025-06-26 03:38:31', NULL, 'on'),
(6, 'Overlock Hoodie', NULL, 4, NULL, 'Overlock Hoodie, một chiếc áo quốc dân, phong cách, dễ mặc, dễ phối đồ. Overlock Hoodie luôn là lựa chọn hàng đầu cho các tín đồ thời trang', 'còn hàng', '1', NULL, NULL, '2025-06-24 07:04:49', NULL, 'on'),
(7, 'Origin Hoodie', NULL, 4, NULL, 'Origin Hoodie, với một tone màu trầm cùng tính chất dễ phối đồ, Origin Hoodie phù hợp với mọi loại style của bạn', 'còn hàng', NULL, '1', '2025-05-13 01:16:29', '2025-06-24 03:37:02', NULL, 'on'),
(8, 'Overlock Taupe Hoodie', NULL, 4, NULL, 'Overlock Taupe Hoodie, form dày dặn, dễ phối đồ', 'còn hàng', NULL, NULL, '2025-05-13 01:23:42', '2025-06-24 07:04:07', NULL, 'on'),
(9, 'Blank Boxy T-Shirt', NULL, 2, 9, 'Blank Boxy T-Shirt, với 2 màu trắng và đen, mặt áo trơ, cực dễ phối đồ, chất vải thoáng mát, thấm mồ hôi. Nếu bạn là người thích sự thoải mái mà vẫn giữ được cái chất và dễ mặc đồ thì đây là chiếc áo dành cho bạn', 'còn hàng', NULL, NULL, '2025-05-14 23:23:50', '2025-06-24 07:54:08', NULL, 'on'),
(10, 'Shiba Puffer Bag', 'unisex,basic', 7, 9, 'Kích thước: 28cm x 18cm x 8cm, đựng vừa iphone 15promax, ví và nhiều phụ kiện cơ bản…', 'còn hàng', NULL, '1', '2025-06-06 08:21:28', '2025-06-24 07:54:08', NULL, 'on'),
(11, 'Bomber Pilot Jacket', NULL, 1, NULL, 'Áo Khoác Bomber Pilot – Phong Cách Phi Công Đậm Chất Cổ Điển. Mang đậm tinh thần phi công cổ điển, áo khoác Bomber Pilot là biểu tượng của sự mạnh mẽ, nam tính và đầy cá tính. Với thiết kế chuẩn form bomber truyền thống.', 'còn hàng', NULL, '4', '2025-06-12 07:23:02', '2025-06-20 06:57:29', NULL, 'on'),
(12, 'Champions Unleashed', NULL, 4, NULL, 'Champions Unleashed Hoodie mang phong cách cá tính, giữ ấm tốt với chất liệu nỉ cao cấp. Hình in nổi bật, form unisex dễ phối, phù hợp cho ngày thường lẫn thời tiết se lạnh.', 'còn hàng', NULL, '2', '2025-06-19 07:07:05', '2025-06-28 14:28:14', NULL, 'on'),
(13, 'Angry Mood T-Shirt', NULL, 2, NULL, 'Angry Mood T-Shirt là mẫu áo thun in hình biểu cảm giận dữ cá tính, dành cho những ai yêu thích phong cách nổi bật. Chất liệu cotton mềm mại, thoáng mát, form unisex dễ phối đồ hằng ngày.', 'còn hàng', NULL, NULL, '2025-06-25 09:04:23', '2025-06-25 09:04:23', NULL, 'on');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 0,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 9, 2, 5, 'Đẹp quá iem', '2025-06-13 02:54:00', '2025-06-13 02:54:00'),
(2, 9, 2, 5, 'Đẹp quá iem', '2025-06-13 03:05:42', '2025-06-13 03:05:42'),
(3, 10, 4, 5, 'nets quas shop oi', '2025-06-16 08:41:56', '2025-06-16 08:41:56'),
(4, 10, 4, 5, 'ngon', '2025-06-16 08:42:08', '2025-06-16 08:42:08'),
(5, 10, 4, 5, 'nét', '2025-06-16 09:26:52', '2025-06-16 09:26:52'),
(6, 10, 1, 5, 'Đẹp quá shop', '2025-06-19 07:27:58', '2025-06-19 07:27:58'),
(7, 13, 4, 3, 'ĐẸP', '2025-06-28 14:29:57', '2025-06-28 14:29:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `shippings`
--

CREATE TABLE `shippings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipping_status` varchar(255) NOT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `shippings`
--

INSERT INTO `shippings` (`id`, `shipping_status`, `tracking_number`, `created_at`, `updated_at`) VALUES
(1, 'Giao hàng tiêu chuẩn', 'STD123456', '2025-06-03 07:55:12', '2025-06-03 07:55:12'),
(2, 'Giao hàng nhanh', 'FAST654321', '2025-06-03 07:55:12', '2025-06-03 07:55:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `day_of_birth` date DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `is_active` enum('on','off') NOT NULL DEFAULT 'on',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `google_id`, `email`, `password`, `phone`, `day_of_birth`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'vinh', NULL, 'vinh@gmail.com', '$2y$12$CH4nbf7vJqL/XBmg7to2pecsbspdMpgJTIBpeDVYWM7W9Ec0DFTny', '123123', NULL, 'admin', 'on', NULL, '2025-05-13 00:01:50', '2025-06-03 06:31:08'),
(3, 'baogia', NULL, 'baogia@gmail.com', '$2y$12$FOzRZYv3muZV2qXw8ZxMjuMBXefQ50fKNRvBl8fD9/r9CySW4.2cC', '0123456789', NULL, 'user', 'on', NULL, '2025-05-13 00:38:12', '2025-06-03 06:33:59'),
(4, 'Van Sang', NULL, 'VanSang@gmail.com', '$2y$12$79mijuodcdx31SorXmyzcehzEINNkraYbLGmmWlScWrloyy2Ypi2C', '19001009', NULL, 'user', 'on', NULL, '2025-05-13 01:54:38', '2025-05-13 19:22:43'),
(7, 'Hứa Quyền', NULL, 'quyenhhps38740@gmail.com', '$2y$12$jyV6ZAq8qcS9b.jEC9GrJuL63oaAv05alOEehSIw/QpDdbQ2Tyoe6', '19001009', NULL, 'admin', 'on', NULL, '2025-05-15 20:33:02', '2025-05-23 20:12:55'),
(8, 'nhat vinh', NULL, 'nhatvinh01102000@gmail.com', '$2y$12$Nea01BuwHdXViS9BcBE4Dun3j8kjqzqQx5scpsfonXRyQ1vORAzdu', '0123456789', NULL, 'admin', 'on', NULL, '2025-05-22 19:09:42', '2025-06-02 00:57:56'),
(9, 'Quyền', NULL, 'huaq2961@gmail.com', '$2y$12$QIS/li2XpS0IjFQLKBqx7O7ii7gdAzHooK.SHZePAJP.FJvNYK95G', '0898388767', '2005-07-03', 'user', 'on', NULL, '2025-05-22 19:10:52', '2025-06-20 08:38:24'),
(10, 'NgocHan', NULL, 'Han@gmail.com', '$2y$12$5VIi4K/ndRYfLlkfLx7eeOog7dSqD1FKL./nPBzXfqejItYBZTL3i', '0905751907', '2025-07-20', 'user', 'on', NULL, '2025-06-04 02:21:24', '2025-06-24 02:07:41'),
(11, 'bao nhu', NULL, 'nhun4073@gmail.com', '$2y$12$ozpSRw1LQNQXrGzewxMWkuKLzFtvpSfmBSHzUoWmzcPnmlWQ4KST.', '0392179948', '2025-06-28', 'user', 'on', NULL, '2025-06-28 13:07:10', '2025-06-28 13:07:46'),
(13, 'sang sang', NULL, 'sanggamer1042005@gmail.com', '$2y$12$jrhFb8mSxT.BvC8t68qeLus3bEpwV9/KjqgxNGEA6395g7qdniMC2', '0392179948', '2025-06-28', 'user', 'on', NULL, '2025-06-28 13:16:14', '2025-06-28 14:36:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `variant`
--

CREATE TABLE `variant` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `img_id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(255) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `sale_price` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` enum('on','off') DEFAULT 'on'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `variant`
--

INSERT INTO `variant` (`id`, `product_id`, `img_id`, `size`, `stock_quantity`, `price`, `sale_price`, `status`, `created_at`, `updated_at`, `active`) VALUES
(1, 1, 1, 'S', 93, 499000, NULL, 'còn hàng', NULL, '2025-06-25 03:15:36', 'on'),
(2, 1, 1, 'M', 99, 499000, NULL, 'còn hàng', NULL, '2025-06-27 08:54:20', 'on'),
(3, 1, 1, 'L', 99, 499000, NULL, 'còn hàng', NULL, '2025-06-27 08:54:20', 'on'),
(4, 2, 2, 'S', 98, 325000, NULL, 'còn hàng', NULL, '2025-06-25 03:15:36', 'on'),
(7, 2, 2, 'M', 100, 325000, 300000, 'còn hàng', NULL, '2025-05-16 01:29:28', 'on'),
(8, 2, 2, 'L', 100, 325000, 300000, 'còn hàng', NULL, '2025-05-16 01:29:48', 'on'),
(10, 2, 2, 'XL', 0, 325000, 300000, 'Đang cập nhật', '2025-05-14 00:10:40', '2025-05-16 01:30:35', 'on'),
(11, 3, 3, 'S', 99, 350000, NULL, 'còn hàng', '2025-05-14 00:57:45', '2025-06-24 07:16:53', 'on'),
(12, 3, 3, 'M', 100, 350000, NULL, 'còn hàng', '2025-05-16 01:41:48', '2025-05-16 01:41:48', 'on'),
(13, 3, 3, 'L', 100, 350000, NULL, 'còn hàng', '2025-05-16 01:42:20', '2025-05-16 01:42:20', 'on'),
(14, 4, 4, 'S', 88, 320000, NULL, 'còn hàng', '2025-05-16 01:51:03', '2025-06-28 14:28:14', 'on'),
(15, 4, 4, 'M', 99, 320000, NULL, 'còn hàng', '2025-05-16 01:55:29', '2025-06-27 03:32:51', 'on'),
(16, 4, 4, 'L', 100, 320000, NULL, 'còn hàng', '2025-05-16 01:55:34', '2025-05-16 01:55:34', 'on'),
(20, 5, 5, 'S', 145, 330000, NULL, 'còn hàng', '2025-05-16 02:28:28', '2025-06-24 07:16:53', 'on'),
(21, 5, 5, 'M', 99, 330000, NULL, 'còn hàng', '2025-05-16 02:28:36', '2025-06-26 03:38:31', 'on'),
(22, 5, 5, 'L', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:28:39', '2025-05-16 02:28:39', 'on'),
(29, 10, 39, 'S', 20, 325000, NULL, 'còn hàng', '2025-06-06 08:50:56', '2025-06-19 04:18:55', 'on'),
(30, 11, 17, 'S', 50, 325000, NULL, 'còn hàng', '2025-06-12 07:25:26', '2025-06-13 06:27:15', 'on'),
(31, 11, 17, 'M', 76, 325000, NULL, 'còn hàng', '2025-06-12 07:29:55', '2025-06-20 06:57:29', 'on'),
(32, 11, 17, 'L', 40, 325000, NULL, 'còn hàng', '2025-06-12 07:30:32', '2025-06-13 06:20:54', 'on'),
(33, 7, 7, 'S', 30, 400000, NULL, 'còn hàng', '2025-06-12 08:40:26', '2025-06-24 03:37:02', 'on'),
(34, 7, 7, 'M', 200, 425000, NULL, 'còn hàng', '2025-06-12 08:40:56', '2025-06-24 03:37:02', 'on'),
(35, 7, 7, 'L', 150, 425000, NULL, 'còn hàng', '2025-06-12 08:42:46', '2025-06-24 03:37:02', 'on'),
(36, 6, 6, 'S', 150, 340000, NULL, 'còn hàng', '2025-06-12 08:59:13', '2025-06-24 07:04:49', 'on'),
(37, 9, 9, 'S', 0, 300000, NULL, 'hết hàng', '2025-06-19 02:15:58', '2025-06-19 04:19:14', 'off'),
(38, 13, 10, 'S', 200, 250000, NULL, 'còn hàng', '2025-06-25 09:05:08', '2025-06-25 09:05:08', 'on'),
(39, 13, 11, 'S', 200, 520000, NULL, 'còn hàng', '2025-06-25 09:12:11', '2025-06-25 09:12:11', 'on'),
(40, 12, 11, 'S', 199, 520000, NULL, 'còn hàng', '2025-06-25 09:12:57', '2025-06-27 03:32:51', 'on'),
(41, 12, 12, 'M', 99, 520000, NULL, 'còn hàng', '2025-06-26 08:44:32', '2025-06-28 14:28:14', 'on');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlist`
--

CREATE TABLE `wishlist` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `address_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `coupons_user`
--
ALTER TABLE `coupons_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_coupons_user_user` (`user_id`),
  ADD KEY `fk_coupons_user_coupon` (`coupon_id`);

--
-- Chỉ mục cho bảng `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `flash_sales`
--
ALTER TABLE `flash_sales`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `flash_sale_variants`
--
ALTER TABLE `flash_sale_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flash_sale_variants_flash_sale_id_foreign` (`flash_sale_id`);

--
-- Chỉ mục cho bảng `img`
--
ALTER TABLE `img`
  ADD PRIMARY KEY (`id`),
  ADD KEY `img_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vnp_TxnRef` (`vnp_TxnRef`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_shipping_id_foreign` (`shipping_id`),
  ADD KEY `orders_discount_id_foreign` (`discount_id`),
  ADD KEY `orders_payment_id_foreign` (`payment_id`),
  ADD KEY `orders_coupon_id_foreign` (`coupon_id`),
  ADD KEY `orders_address_id_foreign` (`address_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_variant_id_foreign` (`variant_id`);

--
-- Chỉ mục cho bảng `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `email` (`email`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `fk_products_discount` (`discount_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `shippings`
--
ALTER TABLE `shippings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `variant`
--
ALTER TABLE `variant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variant_product_id_foreign` (`product_id`),
  ADD KEY `variant_img_id_foreign` (`img_id`);

--
-- Chỉ mục cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlist_user_id_foreign` (`user_id`),
  ADD KEY `wishlist_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `address`
--
ALTER TABLE `address`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `coupons_user`
--
ALTER TABLE `coupons_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `flash_sales`
--
ALTER TABLE `flash_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `flash_sale_variants`
--
ALTER TABLE `flash_sale_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `img`
--
ALTER TABLE `img`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `shippings`
--
ALTER TABLE `shippings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `variant`
--
ALTER TABLE `variant`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `coupons_user`
--
ALTER TABLE `coupons_user`
  ADD CONSTRAINT `fk_coupons_user_coupon` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_coupons_user_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `flash_sale_variants`
--
ALTER TABLE `flash_sale_variants`
  ADD CONSTRAINT `flash_sale_variants_flash_sale_id_foreign` FOREIGN KEY (`flash_sale_id`) REFERENCES `flash_sales` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `img`
--
ALTER TABLE `img`
  ADD CONSTRAINT `img_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_shipping_id_foreign` FOREIGN KEY (`shipping_id`) REFERENCES `shippings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `variant` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_discount` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `variant`
--
ALTER TABLE `variant`
  ADD CONSTRAINT `variant_img_id_foreign` FOREIGN KEY (`img_id`) REFERENCES `img` (`id`),
  ADD CONSTRAINT `variant_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `wishlist_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
