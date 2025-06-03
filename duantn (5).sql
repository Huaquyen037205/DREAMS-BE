-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 05:13 AM
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
-- Database: `duantn`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `adress` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Bomber', NULL, NULL, NULL),
(2, 'Áo thun', NULL, NULL, NULL),
(3, 'Quần', NULL, NULL, NULL),
(4, 'Hoodie', NULL, NULL, NULL),
(7, 'Túi sách', '2025-05-13 20:41:35', '2025-05-13 20:46:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `discount_value` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `expiry_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
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
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `code`, `percentage`, `start_day`, `end_day`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'chaomungquockhanh', 29, '2025-09-01', '2025-09-03', '2025-05-15 01:10:57', '2025-05-15 01:10:57', NULL),
(2, 'chucmungsinhnhat', 10, '2025-09-06', '2025-09-09', '2025-05-15 01:13:47', '2025-05-15 01:13:47', NULL),
(3, 'sale25', 25, '2025-10-06', '2025-10-06', '2025-05-15 18:40:48', '2025-05-15 18:40:48', NULL),
(5, 'dreams', 30, '2025-09-02', '2025-09-10', '2025-05-15 18:43:50', '2025-05-15 18:43:50', NULL),
(6, 'team', 30, '2025-05-20', '2025-05-21', '2025-05-19 20:39:28', '2025-05-19 20:39:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `discount_user`
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
-- Table structure for table `img`
--

CREATE TABLE `img` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `img`
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
(10, 1, 'sp1_4.webp', NULL, '2025-05-18 02:05:27'),
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
-- Table structure for table `jobs`
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
(18, '2025_05_13_063256_create_personal_access_tokens_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
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
-- Table structure for table `orders`
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
  `order_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
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
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('nhatvinh01102000@gmail.com', '1puTecgK', '2025-05-22 20:37:57');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
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
(18, 'App\\Models\\User', 7, 'admin-token', '01b4ea338162ef61f39c7aa51ddcb1bf4c17851d324041ef8ca2ce33a836de95', '[\"*\"]', NULL, NULL, '2025-05-23 19:48:27', '2025-05-23 19:48:27');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_day` timestamp NULL DEFAULT NULL,
  `view` varchar(255) DEFAULT NULL,
  `hot` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `description`, `status`, `created_day`, `view`, `hot`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Bomber Overlock Jacket', 1, 'Bomber Overlock Jacket, thiết kế dày dặn mang cảm giác mạnh mẽ, siêu hack dáng', 'còn hàng', '0000-00-00 00:00:00', '1', NULL, NULL, '2025-05-16 00:07:35', NULL),
(2, 'Love Viet Nam Boxy T-Shirt', 2, 'Love Viet Nam Boxy T-Shirt, form rộng, thoải mái, chất vải thấm hút mồ hôi', 'còn hàng', '0000-00-00 00:00:00', NULL, '1', NULL, '2025-05-16 00:11:05', NULL),
(3, 'Line Wave Jacket', 1, 'Line Wave Jacket, sản phẩm mới nhất và được săn đón nhất hiện nay, phù hợp mặc cho cả đông lẫn hè, đa năng trong mọi lúc', 'còn hàng', '0000-00-00 00:00:00', NULL, '1', NULL, '2025-05-16 00:18:29', NULL),
(4, 'Parachute Cargo Pants', 3, 'Parachute Cargo Pants, phong cách bụi bặm, chất nhất cho mùa hè này', 'còn hàng', '0000-00-00 00:00:00', '1', NULL, NULL, '2025-05-16 00:20:42', NULL),
(5, 'Parachute Cargo Pants Ver 2', 3, 'Parachute Cargo Pants Ver 2, một phiên bản chiến hơn. Nếu bạn là tín đồ của thời trang đường phố thì chiếc Parachute Cargo Pants Ver 2 là dành cho bạn', 'còn hàng', '0000-00-00 00:00:00', NULL, '1', NULL, '2025-05-16 00:32:39', NULL),
(6, 'Overlock Hoodie', 4, 'Overlock Hoodie, một chiếc áo quốc dân, phong cách, dễ mặc, dễ phối đồ. Overlock Hoodie luôn là lựa chọn hàng đầu cho các tín đồ thời trang', 'còn hàng', '0000-00-00 00:00:00', '1', NULL, NULL, '2025-05-16 00:35:40', NULL),
(7, 'Origin Hoodie', 4, 'Origin Hoodie, với một tone màu trầm cùng tính chất dễ phối đồ, Origin Hoodie phù hợp với mọi loại style của bạn', 'còn hàng', '2025-05-08 17:00:00', NULL, '1', '2025-05-13 01:16:29', '2025-05-16 00:41:44', NULL),
(8, 'Overlock Taupe Hoodie', 4, 'Overlock Taupe Hoodie, form dày dặn, dễ phối đồ', 'còn hàng', NULL, NULL, NULL, '2025-05-13 01:23:42', '2025-05-16 00:45:09', NULL),
(9, 'Blank Boxy T-Shirt', 2, 'Blank Boxy T-Shirt, với 2 màu trắng và đen, mặt áo trơ, cực dễ phối đồ, chất vải thoáng mát, thấm mồ hôi. Nếu bạn là người thích sự thoải mái mà vẫn giữ được cái chất và dễ mặc đồ thì đây là chiếc áo dành cho bạn', 'hết hàng', NULL, '1', NULL, '2025-05-14 23:23:50', '2025-05-23 00:10:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
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
-- Table structure for table `shippings`
--

CREATE TABLE `shippings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shipping_status` varchar(255) NOT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `role`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'vinh', 'vinh@gmail.com', '$2y$12$CH4nbf7vJqL/XBmg7to2pecsbspdMpgJTIBpeDVYWM7W9Ec0DFTny', '123123', 'admin', 'on', NULL, '2025-05-13 00:01:50', '2025-05-13 00:01:50'),
(3, 'GiaBảo', 'LeGiaBun@gmail.com', '$2y$12$FOzRZYv3muZV2qXw8ZxMjuMBXefQ50fKNRvBl8fD9/r9CySW4.2cC', '0818605175', 'user', 'on', NULL, '2025-05-13 00:38:12', '2025-05-13 00:38:12'),
(4, 'Van Sang', 'VanSang@gmail.com', '$2y$12$79mijuodcdx31SorXmyzcehzEINNkraYbLGmmWlScWrloyy2Ypi2C', '19001009', 'user', 'on', NULL, '2025-05-13 01:54:38', '2025-05-13 19:22:43'),
(7, 'Hứa Quyền', 'quyenhhps38740@gmail.com', '$2y$12$jyV6ZAq8qcS9b.jEC9GrJuL63oaAv05alOEehSIw/QpDdbQ2Tyoe6', '19001009', 'admin', 'on', NULL, '2025-05-15 20:33:02', '2025-05-23 20:12:55'),
(8, 'nhat vinh', 'nhatvinh01102000@gmail.com', '$2y$12$Nea01BuwHdXViS9BcBE4Dun3j8kjqzqQx5scpsfonXRyQ1vORAzdu', '0123456789', 'user', 'on', NULL, '2025-05-22 19:09:42', '2025-05-22 19:09:42'),
(9, 'Hẹ hẹ hẹ', 'huaq2961@gmail.com', '$2y$12$QIS/li2XpS0IjFQLKBqx7O7ii7gdAzHooK.SHZePAJP.FJvNYK95G', '0898388767', 'user', 'off', NULL, '2025-05-22 19:10:52', '2025-05-22 19:59:41');

-- --------------------------------------------------------

--
-- Table structure for table `variant`
--

CREATE TABLE `variant` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `img_id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `sale_price` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variant`
--

INSERT INTO `variant` (`id`, `product_id`, `img_id`, `size`, `color`, `stock_quantity`, `price`, `sale_price`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'S', 'Black', 100, 499000, NULL, 'còn hàng', NULL, '2025-05-16 01:01:18'),
(2, 1, 1, 'M', 'Black', 100, 499000, NULL, 'còn hàng', NULL, '2025-05-16 01:17:01'),
(3, 1, 1, 'L', 'Black', 100, 499000, NULL, 'còn hàng', NULL, '2025-05-16 01:16:48'),
(4, 2, 2, 'S', 'White', 100, 325000, 300000, 'còn hàng', NULL, '2025-05-16 01:25:06'),
(7, 2, 2, 'M', 'White', 100, 325000, 300000, 'còn hàng', NULL, '2025-05-16 01:29:28'),
(8, 2, 2, 'L', 'White', 100, 325000, 300000, 'còn hàng', NULL, '2025-05-16 01:29:48'),
(10, 2, 2, 'XL', 'White', 0, 325000, 300000, 'Đang cập nhật', '2025-05-14 00:10:40', '2025-05-16 01:30:35'),
(11, 3, 3, 'S', 'Olive', 100, 350000, NULL, 'Còn hàng', '2025-05-14 00:57:45', '2025-05-16 01:36:08'),
(12, 3, 3, 'M', 'Olive', 100, 350000, NULL, 'còn hàng', '2025-05-16 01:41:48', '2025-05-16 01:41:48'),
(13, 3, 3, 'L', 'Olive', 100, 350000, NULL, 'còn hàng', '2025-05-16 01:42:20', '2025-05-16 01:42:20'),
(14, 4, 4, 'S', 'Black', 100, 320000, NULL, 'còn hàng', '2025-05-16 01:51:03', '2025-05-16 01:51:03'),
(15, 4, 4, 'M', 'Black', 100, 320000, NULL, 'còn hàng', '2025-05-16 01:55:29', '2025-05-16 01:55:29'),
(16, 4, 4, 'L', 'Black', 100, 320000, NULL, 'còn hàng', '2025-05-16 01:55:34', '2025-05-16 01:55:34'),
(17, 4, 4, 'S', 'Gray', 100, 320000, NULL, 'còn hàng', '2025-05-16 01:56:09', '2025-05-16 01:56:09'),
(18, 4, 4, 'M', 'Gray', 100, 320000, NULL, 'còn hàng', '2025-05-16 01:56:14', '2025-05-16 01:56:14'),
(19, 4, 4, 'L', 'Gray', 100, 320000, NULL, 'còn hàng', '2025-05-16 01:56:17', '2025-05-16 01:56:17'),
(20, 5, 5, 'S', 'Gray', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:28:28', '2025-05-16 02:28:28'),
(21, 5, 5, 'M', 'Gray', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:28:36', '2025-05-16 02:28:36'),
(22, 5, 5, 'L', 'Gray', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:28:39', '2025-05-16 02:28:39'),
(23, 5, 5, 'S', 'Black', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:28:50', '2025-05-16 02:28:50'),
(24, 5, 5, 'M', 'Black', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:28:53', '2025-05-16 02:28:53'),
(25, 5, 5, 'L', 'Black', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:28:56', '2025-05-16 02:28:56'),
(26, 5, 5, 'S', 'Olive', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:29:28', '2025-05-16 02:29:28'),
(27, 5, 5, 'M', 'Olive', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:29:31', '2025-05-16 02:29:31'),
(28, 5, 5, 'L', 'Olive', 100, 330000, NULL, 'còn hàng', '2025-05-16 02:29:34', '2025-05-16 02:29:34');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `address_user_id_foreign` (`user_id`);

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount_user`
--
ALTER TABLE `discount_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_discount_unique` (`user_id`,`discount_id`),
  ADD KEY `discount_user_discount_id_foreign` (`discount_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `img`
--
ALTER TABLE `img`
  ADD PRIMARY KEY (`id`),
  ADD KEY `img_product_id_foreign` (`product_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_shipping_id_foreign` (`shipping_id`),
  ADD KEY `orders_discount_id_foreign` (`discount_id`),
  ADD KEY `orders_payment_id_foreign` (`payment_id`),
  ADD KEY `orders_coupon_id_foreign` (`coupon_id`),
  ADD KEY `orders_address_id_foreign` (`address_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_variant_id_foreign` (`variant_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `email` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Indexes for table `shippings`
--
ALTER TABLE `shippings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `variant`
--
ALTER TABLE `variant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variant_product_id_foreign` (`product_id`),
  ADD KEY `variant_img_id_foreign` (`img_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlist_user_id_foreign` (`user_id`),
  ADD KEY `wishlist_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `discount_user`
--
ALTER TABLE `discount_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `img`
--
ALTER TABLE `img`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shippings`
--
ALTER TABLE `shippings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `variant`
--
ALTER TABLE `variant`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `discount_user`
--
ALTER TABLE `discount_user`
  ADD CONSTRAINT `discount_user_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discount_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `img`
--
ALTER TABLE `img`
  ADD CONSTRAINT `img_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_discount_id_foreign` FOREIGN KEY (`discount_id`) REFERENCES `discounts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_shipping_id_foreign` FOREIGN KEY (`shipping_id`) REFERENCES `shippings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `variant` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `variant`
--
ALTER TABLE `variant`
  ADD CONSTRAINT `variant_img_id_foreign` FOREIGN KEY (`img_id`) REFERENCES `img` (`id`),
  ADD CONSTRAINT `variant_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `wishlist_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
