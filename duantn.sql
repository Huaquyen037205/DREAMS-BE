-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 05, 2025 lúc 05:13 AM
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
-- Cơ sở dữ liệu: `duantn`
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
(7, '123456789 Đường Lê Lợi, Quận 1, TP.HCM', 10, 0, '2025-06-04 02:22:14', '2025-06-04 02:28:12'),
(8, '113 Đường Lê Lợi, Quận 9, TP.HCM', 10, 1, '2025-06-04 02:23:31', '2025-06-04 02:28:12'),
(9, '1465413 Đường Lê Lợi, Quận 7, TP.HCM', 10, 0, '2025-06-04 02:23:39', '2025-06-04 02:28:12'),
(10, '1465413 Đường Lê Lợi, Quận 12, TP.HCM', 10, 0, '2025-06-04 02:23:46', '2025-06-04 02:28:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`, `status`) VALUES
(1, 'Bomber', NULL, '2025-06-02 03:23:57', NULL, 1),
(2, 'Áo thun', NULL, '2025-06-02 03:22:46', NULL, 1),
(3, 'Quần', NULL, NULL, NULL, 1),
(4, 'Hoodie', NULL, '2025-06-02 03:22:50', NULL, 1),
(7, 'Túi sách', '2025-05-13 20:41:35', '2025-05-13 20:46:55', NULL, 1),
(8, 'Nhật Vinh', '2025-06-02 02:49:52', '2025-06-02 03:22:53', NULL, 0),
(9, 'vinh', '2025-06-02 03:04:59', '2025-06-02 03:22:57', NULL, 0);

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_value`, `expiry_date`, `created_at`, `updated_at`) VALUES
(6, 'HAHFJA1', '10000', '2025-06-06 00:00:00', '2025-06-05 01:42:29', '2025-06-05 01:45:34'),
(7, 'QSSNC1', '10000', '2025-06-06 00:00:00', '2025-06-05 01:45:15', '2025-06-05 01:45:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discounts`
--

CREATE TABLE `discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
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

INSERT INTO `discounts` (`id`, `code`, `percentage`, `start_day`, `end_day`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'chaomungquockhanh', 29, '2025-09-01', '2025-09-03', '2025-05-15 01:10:57', '2025-05-15 01:10:57', NULL),
(2, 'chucmungsinhnhat', 10, '2025-09-06', '2025-09-09', '2025-05-15 01:13:47', '2025-05-15 01:13:47', NULL),
(3, 'sale25', 25, '2025-10-06', '2025-10-06', '2025-05-15 18:40:48', '2025-05-15 18:40:48', NULL),
(5, 'dreams', 30, '2025-09-02', '2025-09-10', '2025-05-15 18:43:50', '2025-05-15 18:43:50', NULL),
(6, 'team', 30, '2025-05-20', '2025-05-21', '2025-05-19 20:39:28', '2025-05-19 20:39:28', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discount_user`
--

CREATE TABLE `discount_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `discount_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(10, 1, '1748921313_3f4e22f8-d88d-47fe-bba9-d256fa289289.jpg', NULL, '2025-06-03 03:28:33'),
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
(33, 7, 'sp7_1.webp', '2025-05-14 19:28:31', '2025-05-18 02:15:01'),
(34, 7, 'sp7_2.webp', '2025-05-14 20:04:58', '2025-05-18 02:15:33'),
(38, 7, '1747645531_toi.jpg', '2025-05-19 02:05:31', '2025-05-19 02:05:31');

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
(43, 'App\\Models\\User', 10, 'API Token', '82da8ced4a35d7332eb89d32584a342992ca9bf601fd7423cc8eb348ea5f9a05', '[\"*\"]', '2025-06-04 02:33:24', NULL, '2025-06-04 02:21:52', '2025-06-04 02:33:24'),
(44, 'App\\Models\\User', 2, 'admin-token', 'd48ffe79bd1c598c3a0100e43c79c11ee65cb2b7de195477903e4e9faed004ca', '[\"*\"]', NULL, NULL, '2025-06-04 02:47:05', '2025-06-04 02:47:05'),
(45, 'App\\Models\\User', 2, 'admin-token', '4a131f11d4a3a3281e2f1f204e656002205f5aef6c2d694f0d4e6b0a65f21a13', '[\"*\"]', NULL, NULL, '2025-06-04 06:04:27', '2025-06-04 06:04:27'),
(46, 'App\\Models\\User', 2, 'admin-token', '4a57520cd228706f91ae796ddc78ff720372b92edcfdf37a31d2fd6dfa0fcf86', '[\"*\"]', NULL, NULL, '2025-06-05 01:19:11', '2025-06-05 01:19:11'),
(47, 'App\\Models\\User', 2, 'admin-token', 'aa1bdc0150bf3f572f4b7aa3e9139a4f4a9296432ccb2c8dfc82b42517ffae1a', '[\"*\"]', NULL, NULL, '2025-06-05 01:25:38', '2025-06-05 01:25:38'),
(48, 'App\\Models\\User', 2, 'admin-token', '48251e1200aef180ec7498c413d31902ef930c410356e33e0144491c55d5e1ef', '[\"*\"]', NULL, NULL, '2025-06-05 02:06:30', '2025-06-05 02:06:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `products` (`id`, `name`, `category_id`, `description`, `status`, `view`, `hot`, `created_at`, `updated_at`, `deleted_at`, `active`) VALUES
(1, 'Bomber Overlock Jacket', 1, 'Bomber Overlock Jacket, thiết kế dày dặn mang cảm giác mạnh mẽ, siêu hack dáng', 'còn hàng', NULL, NULL, NULL, '2025-06-04 03:12:19', NULL, 'on'),
(2, 'Love Viet Nam Boxy T-Shirt', 2, 'Love Viet Nam Boxy T-Shirt, form rộng, thoải mái, chất vải thấm hút mồ hôi', 'còn hàng', NULL, '1', NULL, '2025-05-16 00:11:05', NULL, 'on'),
(3, 'Line Wave Jacket', 1, 'Line Wave Jacket, sản phẩm mới nhất và được săn đón nhất hiện nay, phù hợp mặc cho cả đông lẫn hè, đa năng trong mọi lúc', 'còn hàng', NULL, '1', NULL, '2025-05-16 00:18:29', NULL, 'on'),
(4, 'Parachute Cargo Pants', 3, 'Parachute Cargo Pants, phong cách bụi bặm, chất nhất cho mùa hè này', 'còn hàng', '1', NULL, NULL, '2025-05-16 00:20:42', NULL, 'on'),
(5, 'Parachute Cargo Pants Ver 2', 3, 'Parachute Cargo Pants Ver 2, một phiên bản chiến hơn. Nếu bạn là tín đồ của thời trang đường phố thì chiếc Parachute Cargo Pants Ver 2 là dành cho bạn', 'còn hàng', NULL, '1', NULL, '2025-05-16 00:32:39', NULL, 'on'),
(6, 'Overlock Hoodie', 4, 'Overlock Hoodie, một chiếc áo quốc dân, phong cách, dễ mặc, dễ phối đồ. Overlock Hoodie luôn là lựa chọn hàng đầu cho các tín đồ thời trang', 'còn hàng', '1', NULL, NULL, '2025-05-16 00:35:40', NULL, 'on'),
(7, 'Origin Hoodie', 4, 'Origin Hoodie, với một tone màu trầm cùng tính chất dễ phối đồ, Origin Hoodie phù hợp với mọi loại style của bạn', 'còn hàng', NULL, '1', '2025-05-13 01:16:29', '2025-05-16 00:41:44', NULL, 'on'),
(8, 'Overlock Taupe Hoodie', 4, 'Overlock Taupe Hoodie, form dày dặn, dễ phối đồ', 'còn hàng', NULL, NULL, '2025-05-13 01:23:42', '2025-05-16 00:45:09', NULL, 'on'),
(9, 'Blank Boxy T-Shirt', 2, 'Blank Boxy T-Shirt, với 2 màu trắng và đen, mặt áo trơ, cực dễ phối đồ, chất vải thoáng mát, thấm mồ hôi. Nếu bạn là người thích sự thoải mái mà vẫn giữ được cái chất và dễ mặc đồ thì đây là chiếc áo dành cho bạn', 'hết hàng', '1', NULL, '2025-05-14 23:23:50', '2025-05-23 00:10:39', NULL, 'on');

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
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `is_active` enum('on','off') NOT NULL DEFAULT 'on',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'vinh', 'vinh@gmail.com', '$2y$12$CH4nbf7vJqL/XBmg7to2pecsbspdMpgJTIBpeDVYWM7W9Ec0DFTny', '123123', 'admin', 'on', NULL, '2025-05-13 00:01:50', '2025-06-03 06:31:08'),
(3, 'baogia', 'baogia@gmail.com', '$2y$12$FOzRZYv3muZV2qXw8ZxMjuMBXefQ50fKNRvBl8fD9/r9CySW4.2cC', '0123456789', 'user', 'on', NULL, '2025-05-13 00:38:12', '2025-06-03 06:33:59'),
(4, 'Van Sang', 'VanSang@gmail.com', '$2y$12$79mijuodcdx31SorXmyzcehzEINNkraYbLGmmWlScWrloyy2Ypi2C', '19001009', 'user', 'on', NULL, '2025-05-13 01:54:38', '2025-05-13 19:22:43'),
(7, 'Hứa Quyền', 'quyenhhps38740@gmail.com', '$2y$12$jyV6ZAq8qcS9b.jEC9GrJuL63oaAv05alOEehSIw/QpDdbQ2Tyoe6', '19001009', 'admin', 'on', NULL, '2025-05-15 20:33:02', '2025-05-23 20:12:55'),
(8, 'nhat vinh', 'nhatvinh01102000@gmail.com', '$2y$12$Nea01BuwHdXViS9BcBE4Dun3j8kjqzqQx5scpsfonXRyQ1vORAzdu', '0123456789', 'admin', 'on', NULL, '2025-05-22 19:09:42', '2025-06-02 00:57:56'),
(9, 'Hẹ hẹ hẹ', 'huaq2961@gmail.com', '$2y$12$QIS/li2XpS0IjFQLKBqx7O7ii7gdAzHooK.SHZePAJP.FJvNYK95G', '0898388767', 'user', 'on', NULL, '2025-05-22 19:10:52', '2025-06-04 06:08:41'),
(10, 'dat09', 'dat@gmail.com', '$2y$12$5VIi4K/ndRYfLlkfLx7eeOog7dSqD1FKL./nPBzXfqejItYBZTL3i', '0123456789', 'user', 'on', NULL, '2025-06-04 02:21:24', '2025-06-04 03:12:01');

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
(1, 1, 1, 'S', 100, 499000, NULL, 'còn hàng', NULL, '2025-05-16 01:01:18', 'on'),
(2, 1, 1, 'M', 100, 499000, NULL, 'còn hàng', NULL, '2025-05-16 01:17:01', 'on'),
(3, 1, 1, 'L', 100, 499000, NULL, 'còn hàng', NULL, '2025-05-16 01:16:48', 'on'),
(4, 2, 2, 'S', 100, 325000, 300000, 'còn hàng', NULL, '2025-05-16 01:25:06', 'on'),
(7, 2, 2, 'M', 100, 325000, 300000, 'còn hàng', NULL, '2025-05-16 01:29:28', 'on'),
(8, 2, 2, 'L', 100, 325000, 300000, 'còn hàng', NULL, '2025-05-16 01:29:48', 'on'),
(10, 2, 2, 'XL', 0, 325000, 300000, 'Đang cập nhật', '2025-05-14 00:10:40', '2025-05-16 01:30:35', 'on'),
(11, 3, 3, 'S', 100, 350000, NULL, 'Còn hàng', '2025-05-14 00:57:45', '2025-05-16 01:36:08', 'on'),
(12, 3, 3, 'M', 100, 350000, NULL, 'còn hàng', '2025-05-16 01:41:48', '2025-05-16 01:41:48', 'on'),
(13, 3, 3, 'L', 100, 350000, NULL, 'còn hàng', '2025-05-16 01:42:20', '2025-05-16 01:42:20', 'on'),
(14, 4, 4, 'S', 100, 320000, NULL, 'còn hàng', '2025-05-16 01:51:03', '2025-05-16 01:51:03', 'on'),
(15, 4, 4, 'M', 100, 320000, NULL, 'còn hàng', '2025-05-16 01:55:29', '2025-05-16 01:55:29', 'on'),
(16, 4, 4, 'L', 100, 320000, NULL, 'còn hàng', '2025-05-16 01:55:34', '2025-05-16 01:55:34', 'on'),
(17, 4, 4, 'S', 100, 320000, NULL, 'còn hàng', '2025-05-16 01:56:09', '2025-05-16 01:56:09', 'on'),
(18, 4, 4, 'M', 100, 320000, NULL, 'còn hàng', '2025-05-16 01:56:14', '2025-05-16 01:56:14', 'on'),
(19, 4, 4, 'L', 100, 320000, NULL, 'còn hàng', '2025-05-16 01:56:17', '2025-05-16 01:56:17', 'on'),
(20, 5, 5, 'S', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:28:28', '2025-05-16 02:28:28', 'on'),
(21, 5, 5, 'M', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:28:36', '2025-05-16 02:28:36', 'on'),
(22, 5, 5, 'L', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:28:39', '2025-05-16 02:28:39', 'on'),
(23, 5, 5, 'S', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:28:50', '2025-05-16 02:28:50', 'on'),
(24, 5, 5, 'M', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:28:53', '2025-05-16 02:28:53', 'on'),
(25, 5, 5, 'L', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:28:56', '2025-05-16 02:28:56', 'on'),
(26, 5, 5, 'S', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:29:28', '2025-05-16 02:29:28', 'on'),
(27, 5, 5, 'M', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:29:31', '2025-05-16 02:29:31', 'on'),
(28, 5, 5, 'L', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:29:34', '2025-05-16 02:29:34', 'on');

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
-- Chỉ mục cho bảng `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `discount_user`
--
ALTER TABLE `discount_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_discount_unique` (`user_id`,`discount_id`),
  ADD KEY `discount_user_discount_id_foreign` (`discount_id`);

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
  ADD KEY `products_category_id_foreign` (`category_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `discount_user`
--
ALTER TABLE `discount_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `flash_sales`
--
ALTER TABLE `flash_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `flash_sale_variants`
--
ALTER TABLE `flash_sale_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `img`
--
ALTER TABLE `img`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `shippings`
--
ALTER TABLE `shippings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `variant`
--
ALTER TABLE `variant`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `discount_user`
--
ALTER TABLE `discount_user`
  ADD CONSTRAINT `discount_user_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discount_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
