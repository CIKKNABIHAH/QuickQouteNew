-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2024 at 06:26 AM
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
-- Database: `quickquote`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`admin_id`, `username`, `email`, `password`, `created_at`, `last_login`) VALUES
(1, 'nabihah', 'nabihah@gmail.com', '12345678', '2024-11-09 05:36:35', NULL),
(2, 'bibi', 'bibi@gmail.com', '12345', '2024-11-09 05:55:59', NULL),
(3, 'bibi123', 'bibi123@gmail.com', '$2y$10$2PwvnBh4jhxTxlIWg2aSS.ZqkihlW6xcqF8iAkFywzjA28BEmhqyu', '2024-11-09 06:07:08', '2024-11-09 06:07:37'),
(4, 'admin12', 'admin1@gmail.com', '$2y$10$kCYIYObFDigz5o6sq5O7MevYdxK2D9o9Hl3k.ZLQ9pwfjmsvJ8fda', '2024-11-09 07:01:32', NULL),
(5, 'admin2', 'admin2@gmail.com', '$2y$10$HmK8LmwXkXHQFTgDcj9Taun89Yh/IepxoQlNSzDWc6VMk5eTpnV5G', '2024-11-11 00:28:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `username`, `email`, `phone`, `password`) VALUES
(1, 'Alice Johnson', 'alicej', 'alice@example.com', '123-456-7890', 'alice123'),
(2, 'Bob Smith', 'bobsmith', 'bob@example.com', '987-654-3210', 'bob456'),
(8, 'Nur Fatihah', 'teha cute', 'teha@gmail.com', '0163750953', '$2y$10$ZctTnjOWxVoM0rTZYMu3NOfTEUU9n9juJQMwwoUIqIMtv8Ven70aW'),
(9, 'Nabihah', 'BIBI', 'bibi@gmail.com', '0163750953', '$2y$10$ZuATxT6Z9T1atMwq7yWCDOJ9UjDLKSvj30g4n08vFtl5DUaNaOeLK'),
(11, 'Nabihah', 'bibi123', 'nabihah@gmail.com', '0163750953', '$2y$10$9QuN0njZajXsc5rBjQgRFeTgPmA8Rv.EVn.vPLTzax8RPJN5R3K0e'),
(12, 'mawar', 'mawareee', 'mawar@gmail.com', ' 011 6815 5175', '$2y$10$C3wJtNjFrkxzDoHKYxjmjeaep47vyZWuc8T1a1aJH3b5IO.jbvbGO'),
(13, 'casa', 'casaa', 'casa@gmail.com', '0123456789', '$2y$10$nhC5Jx/OS/sjG.hnSdzLYehSW5ZCXiXJiwp.4veU3stUP./MpawqK'),
(14, 'ali', 'ali1234', 'aliboy2@gmail.com', ' 011 6815 5175', '$2y$10$Mn03VfmWOTwDa7d2M/pQgeD9WC0Mtg/hTMnrOppd/DxuOqneaktju'),
(16, 'Nur Fatihah', 'teha134', 'teha134@gmail.com', ' 011 6815 5175', '$2y$10$tzMiEKW0u6hwLlYCANmpD.ODGqeja4GQ6upmKs.OHR/mdmOx1zSu2'),
(17, 'Abu', 'Abuu', 'abu@gmail.com', '0163750953', '$2y$10$khvkdmc1ZOi57Gj5ownlUO5W3TPdZyJP7Rgc3MG0V3mKMlyE6PMwK'),
(18, 'Ahmad', 'Ahmaddd', 'ahmad@gmail.com', '0137825698', '$2y$10$TGTXj1GMcvxfhQVYHKEkieXiuQYdkQ9Gsetk2A3W6vCDFnHU7tCPW');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `request_date` datetime DEFAULT current_timestamp(),
  `ceremony_venue` varchar(255) DEFAULT NULL,
  `ceremony_date` date DEFAULT NULL,
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `package_id`, `request_date`, `ceremony_venue`, `ceremony_date`, `details`) VALUES
(7, 8, 13, '2024-11-09 13:00:48', 'hhahahaha', '2024-11-21', NULL),
(10, 8, 3, '2024-11-10 14:38:15', 'dewan rakyat', '2024-11-21', 'testingg'),
(11, 11, 15, '2024-11-10 17:31:23', 'The Sky Residensi', '2024-11-28', 'Kek aiskrim, tema frozen. 2 tingkat  '),
(12, 8, 4, '2024-11-10 17:55:34', 'The Sky Residensi', '2024-11-22', 'ytudyid'),
(13, 11, 3, '2024-11-11 02:49:42', 'The Sky Residensi', '2024-11-21', 'cubaannn'),
(14, 9, 11, '2024-11-11 03:38:08', 'dewan rakyat', '2024-11-22', 'testingg'),
(15, 13, 61, '2024-11-20 11:50:11', 'uptm', '2025-05-25', ''),
(16, 13, 9, '2024-11-20 11:51:55', 'uptm', '2024-11-21', ''),
(17, 13, 21, '2024-11-20 11:52:23', 'uptm', '2024-11-21', ''),
(18, 14, 13, '2024-11-20 12:14:50', 'Taman Jalan Zebra, Kuala Lumpur', '2024-12-10', 'Perisa pandan coklat '),
(19, 16, 5, '2024-11-20 12:17:20', 'The Sky Residensi', '2024-11-28', ''),
(20, 17, 34, '2024-11-20 13:57:06', 'Green wedding hall, shah alam ', '2024-11-29', 'add 200 pcs.'),
(21, 18, 7, '2024-11-20 14:11:41', 'Jalan Ampang, cheras kuala lumpur', '2025-01-01', 'add-on 2 hours.'),
(22, 11, 3, '2024-11-21 04:29:27', 'The Sky Residensi', '2024-11-22', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_status_updates`
--

CREATE TABLE `order_status_updates` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_status_updates`
--

INSERT INTO `order_status_updates` (`id`, `order_id`, `status`, `updated_at`) VALUES
(4, 9, 'Quotation Process', '2024-11-10 10:54:50'),
(5, 10, 'Quotation Process', '2024-11-10 14:37:15'),
(6, 10, 'Quotation Process', '2024-11-10 14:38:19'),
(7, 10, 'Quotation Process', '2024-11-10 15:41:57'),
(8, 10, 'Quotation Process', '2024-11-10 15:50:18'),
(9, 10, 'Order Processed', '2024-11-10 16:01:44'),
(10, 13, 'Order Processed', '2024-11-11 02:13:01'),
(11, 13, 'Quotation Process', '2024-11-11 02:20:47'),
(12, 13, 'Quotation Process', '2024-11-11 02:20:53'),
(13, 13, 'View Quotation', '2024-11-11 02:22:40'),
(14, 19, 'View Quotation', '2024-11-20 12:47:47'),
(15, 18, 'View Quotation', '2024-11-20 12:47:52'),
(16, 17, 'View Quotation', '2024-11-20 12:47:59'),
(17, 16, 'View Quotation', '2024-11-20 12:48:06'),
(18, 15, 'View Quotation', '2024-11-20 12:48:11'),
(19, 14, 'View Quotation', '2024-11-20 12:48:19'),
(20, 15, 'View Quotation', '2024-11-20 12:48:28'),
(21, 15, 'Order Prepare', '2024-11-20 12:48:39'),
(22, 7, 'Get invoices', '2024-11-20 12:48:47'),
(23, 12, 'Quotation Process', '2024-11-20 12:49:22'),
(24, 12, 'View Quotation', '2024-11-20 12:49:29'),
(25, 19, 'Get invoices', '2024-11-20 12:49:32'),
(26, 19, 'Order Prepare', '2024-11-20 12:49:37'),
(27, 19, 'Payment', '2024-11-20 12:49:40'),
(28, 19, 'Payment', '2024-11-20 12:49:44'),
(29, 7, 'Get invoices', '2024-11-20 12:50:26'),
(30, 19, 'Order Prepare', '2024-11-20 12:50:30'),
(31, 19, 'Payment', '2024-11-20 12:50:34'),
(32, 19, 'Payment', '2024-11-20 12:50:38'),
(33, 18, 'Get invoices', '2024-11-20 12:52:39'),
(34, 18, 'Order Prepare', '2024-11-20 12:53:48'),
(35, 20, 'Quotation Process', '2024-11-20 12:58:09'),
(36, 20, 'View Quotation', '2024-11-20 12:58:51'),
(37, 20, 'Get invoices', '2024-11-20 12:59:02'),
(38, 20, 'Get Invoices', '2024-11-20 13:02:52'),
(39, 20, 'Order Prepare', '2024-11-20 13:03:33'),
(40, 21, 'Quotation Process', '2024-11-20 13:13:22'),
(41, 21, 'View Quotation', '2024-11-20 13:13:26'),
(42, 20, 'Get Invoices', '2024-11-20 13:15:53'),
(43, 21, 'Get Invoices', '2024-11-20 13:16:10');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `package_id` int(11) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `package_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`package_id`, `service_id`, `package_name`, `description`, `price`, `image_url`, `created_at`) VALUES
(3, 1, 'Basic Malaysian Catering Package', 'Traditional Malaysian dishes such as Nasi Minyak, Ayam Masak Merah, and Daging Rendang for 100 guests.', 2000.00, 'uploads/images/7663173dd3dc0f04c630a1f5fd9d2b4f.png', '2024-11-06 15:05:30'),
(4, 2, 'Basic Photography Package', 'Includes up to 3 hours of coverage with edited digital photos.', 800.00, 'uploads/images/23fe6a883fcbc704bdca5e3f7950685d.jpg', '2024-11-06 15:05:30'),
(5, 2, 'Standard Photography Package', 'Includes 5 hours of coverage, edited digital photos, and an online gallery.', 1500.00, 'uploads/images/f3783a386ad97d28b00b153a965b8432.jpg', '2024-11-06 15:05:30'),
(6, 2, 'Premium Photography Package', 'Full day coverage, edited digital photos, online gallery, and a printed album.', 2500.00, 'uploads/images/1978f0c1155dc135c8c510127bb15085.jpg', '2024-11-06 15:05:30'),
(7, 3, 'Basic DJ Package', 'Includes DJ services for up to 4 hours with basic sound system.', 700.00, 'uploads/images/6f4f9bdebe959988da99e7c1730c9eee.jpeg', '2024-11-06 15:05:30'),
(8, 3, 'Standard DJ Package', 'Includes DJ services for up to 6 hours with professional sound system and lighting.', 1200.00, 'uploads/images/a70222b4a0f2e47a52b5e9e4a2653648.jpeg', '2024-11-06 15:05:30'),
(9, 3, 'Premium DJ Package', 'Full day DJ services, sound system, lighting, and live MC.', 2000.00, 'uploads/images/c979a6421e4664162afce8be134ba713.jpeg', '2024-11-06 15:05:30'),
(10, 7, 'Basic Makeup Package', 'Professional makeup artist for 3 hours. Includes natural makeup look and touch-ups.', 500.00, 'uploads/images/12f222384fc5fa05008f8f8c4121de34.jpg', '2024-11-06 15:05:30'),
(11, 7, 'Standard Makeup Package', 'Makeup artist for 5 hours with additional glamour options.', 1000.00, 'uploads/images/3483a55adb824d8bace57aae12df8af1.jpg', '2024-11-06 15:05:30'),
(12, 7, 'Premium Makeup Package', 'Full day makeup artist services with touch-ups, includes trial session.', 1500.00, 'uploads/images/a7e439567053ccef2ed20c15af9e230b.jpg', '2024-11-06 15:05:30'),
(13, 8, 'Basic Cake Package', 'One-tier wedding cake with simple decorations.', 300.00, 'uploads/images/2ba16039e75301e7903a0c1a9082f0f9.jpg', '2024-11-06 15:05:30'),
(14, 8, 'Standard Cake Package', 'Two-tier wedding cake with floral and edible decorations.', 700.00, 'uploads/images/6c9498a840e1706f99851208e0a7cb3b.jpg', '2024-11-06 15:05:30'),
(15, 8, 'Premium Cake Package', 'Three-tier wedding cake with intricate designs, customizable.', 1200.00, 'uploads/images/3e488637445f8fbeab7a41f134f5b53c.jpg', '2024-11-06 15:05:30'),
(16, 5, 'Classic Wedding Theme', 'Elegant and traditional theme with floral decorations.', 2000.00, 'uploads/images/e07c0492639873169910074b90a2a780.jpeg', '2024-11-06 15:05:30'),
(17, 5, 'Rustic Wedding Theme', 'Rustic theme with natural wood elements and earthy tones.', 2500.00, 'uploads/images/86b492e140f38779317ee4c0b6b3a56f.jpg', '2024-11-06 15:05:30'),
(18, 5, 'Luxury Wedding Theme', 'Luxurious theme with premium decorations and lighting.', 5000.00, 'uploads/images/d9c158eb62b3dfef09f07502c1547465.jpg', '2024-11-06 15:05:30'),
(19, 4, 'Basic Transportation Package', 'Includes sedan for the bride and groom.', 300.00, 'uploads/images/1173bada046aacbedb7b46aacf0df399.jpg', '2024-11-06 15:05:30'),
(20, 4, 'Standard Transportation Package', 'Includes sedan and one additional car for family.', 600.00, 'uploads/images/a0de17a296eee12fa96bab23a1da0fe9.jpg', '2024-11-06 15:05:30'),
(21, 4, 'Premium Transportation Package', 'Luxury car for bride and groom, plus SUV for family.', 1000.00, 'uploads/images/568bd776a4b86572f9128f060f01af3b.jpg', '2024-11-06 15:05:30'),
(22, 5, 'Basic Decoration Package', 'Essential decorations for the ceremony.', 800.00, 'uploads/images/c196392010cfc4424ea27aff9cf449ff.jpg', '2024-11-06 15:05:30'),
(24, 5, 'Premium Decoration Package', 'Full decoration package with custom setups and lighting.', 20000.00, 'uploads/images/3693170946c2c83ad05603b5128fb44c.jpg', '2024-11-06 15:05:30'),
(28, 9, 'Eco-Friendly Wedding Goodies Package', 'Environmentally friendly and sustainable wedding favors that charm and delight.', 1800.00, 'uploads/images/92e233a7682d396bbf55370d6c498b69.jpg', '2024-11-07 11:08:38'),
(34, 9, 'Premium Wedding Favors', 'Elegant goodies such as locally-made chocolates or bahulu in custom-designed boxes.', 2400.00, 'uploads/images/2a72669ae88bee6fffc63f164b72293f.png', '2024-11-07 11:20:08'),
(35, 9, 'Exclusive Wedding Favors', 'Personalized favors such as engraved keychains or mini glass jars of local honey.', 3200.00, 'uploads/images/c41b339924cc2979aa205ee5602e0b6f.jpg', '2024-11-07 11:20:08'),
(37, 10, 'Bohemian Wedding Dress Package', 'Boho-chic wedding dresses and suits featuring flowy fabrics, intricate lace, and relaxed silhouettes, perfect for a rustic setting.', 3900.00, 'uploads/images/e371b4edc3968bf6f5815234b0ba4cd4.jpg', '2024-11-07 11:20:08'),
(38, 10, 'Black-Tie Wedding Attire Package', 'Formal black-tie wedding attire for the ultimate in elegance and sophistication at your upscale event.', 5500.00, 'uploads/images/076de7cecdf690e02bf0b515b3edf17a.jpg', '2024-11-07 11:20:08'),
(39, 10, 'Beach Wedding Attire Package', 'Casually elegant beach wedding attire for the bride, groom, and bridal party, perfect for seaside ceremonies.', 4200.00, 'uploads/images/92ead63084e24cc66ad7e6b053207276.jpg', '2024-11-07 11:20:08'),
(58, 1, 'Elegant Wedding Package', 'Elegant 4-course meal for up to 150 guests, including a champagne toast and custom wedding cake.', 5000.00, 'uploads/images/cfea1b91977f163d73c8bff819ea857b.png', '2024-11-17 05:11:40'),
(59, 1, 'Royal Wedding Package', 'Luxurious 6-course meal featuring gourmet dishes for up to 250 guests, with live cooking stations and a dessert bar.', 10000.00, 'uploads/images/630904aa5b60b19d92302e521b103422.png', '2024-11-17 05:11:40'),
(60, 1, 'Garden Wedding Package', 'Fresh, locally-sourced 3-course meal perfect for outdoor settings, up to 100 guests. Includes eco-friendly tableware.', 3000.00, 'uploads/images/3cd771d19ca9ee68c6c5bdb9c785ed2e.png', '2024-11-17 05:11:40'),
(61, 1, 'Intimate Wedding Package', 'Specially designed for small, intimate weddings, this package offers a 5-course gourmet meal for up to 50 guests.', 2000.00, 'uploads/images/0c6a36eaf8a3c60dcd7ebacc06bf892f.png', '2024-11-17 05:11:40'),
(62, 1, 'Standard Malaysian Catering Package', 'Includes a wider variety of Malaysian dishes like Satay, Laksa, and Kuih-Muih for 150 guests, with beverage stations.', 4000.00, 'uploads/images/Catering.png', '2024-11-20 09:36:28'),
(63, 10, 'Traditional Malay Wedding Attire Package', 'Includes Baju Pengantin in royal songket with matching accessories for the bride and groom.', 1500.00, 'uploads/images/acdf416ee031328113adf58de6c32079.png', '2024-11-20 10:27:32');

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `quotation_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`quotation_id`, `order_id`, `customer_id`, `file_path`, `created_at`) VALUES
(3, 10, 8, 'uploads/quotations/2024-10-20T23-27-34-752.jpg', '2024-11-10 13:59:17'),
(4, 11, 11, 'uploads/quotations/2024-09-24T22-44-28-651.jpg', '2024-11-10 17:10:26'),
(5, 7, 8, 'uploads/quotations/CV - Nurul Nabihah Binti Abu Bakar.pdf', '2024-11-10 17:29:15'),
(6, 10, 8, 'uploads/quotations/SUKA HTI SAYA (1).png', '2024-11-10 17:31:42'),
(7, 13, 11, 'uploads/quotations/CV - Nurul Nabihah Binti Abu Bakar.pdf', '2024-11-11 02:22:24'),
(8, 19, 16, 'uploads/quotations/2.png', '2024-11-20 12:40:31'),
(9, 18, 14, 'uploads/quotations/1.png', '2024-11-20 12:40:39'),
(10, 17, 13, 'uploads/quotations/2.png', '2024-11-20 12:40:49'),
(11, 16, 13, 'uploads/quotations/3.png', '2024-11-20 12:41:01'),
(12, 15, 13, 'uploads/quotations/4.png', '2024-11-20 12:41:16'),
(13, 14, 9, 'uploads/quotations/2.png', '2024-11-20 12:41:29'),
(14, 13, 11, 'uploads/quotations/2.png', '2024-11-20 12:41:38'),
(15, 12, 8, 'uploads/quotations/3.png', '2024-11-20 12:41:48'),
(16, 11, 11, 'uploads/quotations/1.png', '2024-11-20 12:42:01'),
(17, 10, 8, 'uploads/quotations/1.png', '2024-11-20 12:42:16'),
(18, 7, 8, 'uploads/quotations/3.png', '2024-11-20 12:42:25'),
(19, 20, 17, 'uploads/quotations/4.png', '2024-11-20 12:58:01'),
(20, 21, 18, 'uploads/quotations/2.png', '2024-11-20 13:13:12');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `name`, `description`) VALUES
(1, 'Catering', 'Find the best catering services for your wedding.'),
(2, 'Photography', 'Hire the best photographers for your special day.'),
(3, 'Music & Entertainment', 'Discover top music and entertainment options.'),
(4, 'Transportation', 'Arrange transportation for your wedding day.'),
(5, 'Wedding Themes', 'Explore various wedding themes to make your day special.'),
(7, 'Makeup Services', 'Professional wedding makeup services'),
(8, 'Cake Services', 'Custom wedding cakes'),
(9, 'Wedding Goodies', 'Customized goodies for wedding guests'),
(10, 'Dress/Suit Services', 'Tailored wedding dresses and suits for the bridal party');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `order_status_updates`
--
ALTER TABLE `order_status_updates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`package_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`quotation_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `order_status_updates`
--
ALTER TABLE `order_status_updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `quotation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `packages` (`package_id`) ON DELETE CASCADE;

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`) ON DELETE CASCADE;

--
-- Constraints for table `quotations`
--
ALTER TABLE `quotations`
  ADD CONSTRAINT `quotations_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quotations_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
