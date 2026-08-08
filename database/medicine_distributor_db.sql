-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2026 at 07:44 AM
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
-- Database: `medicine_distributor_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `full_name`, `email`, `password`) VALUES
(1, 'ihsan ullah', 'pak32641@gmail.com', '$2y$10$zVTgIPTaSfasb7hD9QGX/uuvvxfJmBWI9V9xfYP8LIRO5aXgUR6Oa');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `image`) VALUES
(40, 'Syrups', 'Syrup.jpg'),
(41, 'Injections', 'Injection.jpg'),
(42, 'Creams', 'Cream.jpg'),
(43, 'Tablets', 'Teble.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contact_info`
--

CREATE TABLE `contact_info` (
  `contact_id` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `company_name` varchar(255) DEFAULT NULL,
  `owners` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `working_hours` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_info`
--

INSERT INTO `contact_info` (`contact_id`, `phone`, `email`, `address`, `updated_at`, `company_name`, `owners`, `whatsapp`, `working_hours`) VALUES
(1, '03015341769', 'pak32641@gmail.com', 'Main Bazaar,Timergara,Dir Lower,KPK,Pakistan', '2025-12-27 09:29:21', 'IA Medicine Distributor', 'Ihsan Ullah & Adnan Khan', '03000944006', 'Mon - Sat  |  9:00 AM - 8:00 PM');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `user_id`, `created_at`, `name`, `email`, `remarks`) VALUES
(23, 46, '2026-05-17 06:23:24', 'Ihsan Ullah', 'pak32642@gmail.com', 'Your services is outstanding.'),
(24, 46, '2026-05-17 06:24:10', 'Ihsan Ullah', 'pak32642@gmail.com', 'Outstanding'),
(25, 47, '2026-05-17 06:25:23', 'Sajjad', 'pak32645@gmail.com', 'Mashallah');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('Pending','Completed','Cancelled') DEFAULT 'Pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_type` varchar(20) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `user_deleted` tinyint(1) DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_name`, `total_amount`, `status`, `order_date`, `payment_type`, `address`, `zip`, `user_deleted`, `user_id`, `email`, `phone`) VALUES
(186, 'adnan', 35950.00, 'Completed', '2026-05-28 04:22:05', 'Cash on Delivery', 'timergara', '18300', 0, 49, 'pak32647@gmail.com', '03015341769'),
(187, 'Zia', 16250.00, 'Completed', '2026-05-28 04:29:05', 'Cash on Delivery', 'Islamabad', '18100', 0, 48, 'pak32641@gmail.com', '03015634678'),
(188, 'Ihsan ullah', 14000.00, 'Completed', '2026-05-28 04:32:22', 'Cash on Delivery', 'Lower dir Munda', '18500', 0, 46, 'pak32642@gmail.com', '03015341769'),
(189, 'Sajjad ihsas', 24750.00, 'Pending', '2026-05-28 04:36:42', 'Cash on Delivery', 'Lahore', '18000', 0, 47, 'pak32645@gmail.com', '03000944006');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(150) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`) VALUES
(259, 186, 63, 'Zyrtec', 380.00, 5),
(260, 186, 65, 'Ambroxol', 270.00, 10),
(261, 186, 75, 'Eczema Relief Cream', 550.00, 10),
(262, 186, 74, 'Skin Aqua Cream', 600.00, 20),
(263, 186, 71, 'Dermovate', 500.00, 20),
(264, 186, 73, 'Neomycin', 350.00, 11),
(265, 187, 73, 'Neomycin', 350.00, 10),
(266, 187, 75, 'Eczema Relief Cream', 550.00, 15),
(267, 187, 67, 'Vitamin B12 ', 750.00, 6),
(268, 188, 65, 'Ambroxol', 270.00, 10),
(269, 188, 63, 'Zyrtec', 380.00, 10),
(270, 188, 67, 'Vitamin B12 ', 750.00, 10),
(271, 189, 69, 'Ketorolac', 620.00, 15),
(272, 189, 70, 'Calcijex', 850.00, 15),
(273, 189, 65, 'Ambroxol', 270.00, 10);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product_name`, `description`, `price`, `quantity`, `image`, `created_at`) VALUES
(62, 40, 'Benadryl', 'Effective for cold, allergy, and cough relief', 400.00, 6923, 'benadryl-cough-syrup-500x500.webp', '2025-12-23 10:41:33'),
(63, 40, 'Zyrtec', 'Relieves allergy, sneezing, and runny nose', 380.00, 3975, '16029142479524901_360x@2x.png', '2025-12-23 10:43:35'),
(64, 40, 'Mucosolvan', 'Clears cough and chest congestion quickly', 310.00, 4989, '3664798024142_fbd920dd-4722-4ab2-8e4b-049cdb45cd54.jpg', '2025-12-23 10:45:57'),
(65, 40, 'Ambroxol', 'Loosens mucus for easier breathing', 270.00, 4314, 'f5a1e443205a1cd4aad0200c8996f8f3.jpg', '2025-12-23 10:49:10'),
(66, 41, 'Insulin', 'Used to control blood sugar levels in diabetes patients', 950.00, 1, '1800x1200_how_insulin_works_bigbead.jpg', '2025-12-23 10:51:21'),
(67, 41, 'Vitamin B12 ', 'Used for treating vitamin B12 deficiency and nerve issues', 750.00, 3889, 'Vitamin-B12-online-doctor-sa-south-africa-1.jpg', '2025-12-23 10:52:43'),
(68, 41, 'Penicillin', 'Antibiotic used for infection treatment.', 490.00, 98, 'penicillin-bottle-with-a-needle-and-syringe.jpg', '2025-12-23 10:56:46'),
(69, 41, 'Ketorolac', 'Pain reliever for short-term management of moderate pain', 620.00, 89976, 'Ketrolac-Injection.jpg', '2025-12-23 10:58:38'),
(70, 41, 'Calcijex', 'For calcium and vitamin D supplementation', 850.00, 1984, 'calcijex-1-mcg-ml-iv-1-mlx-25-ampul-kutu-2132.jpg', '2025-12-23 11:01:52'),
(71, 42, 'Dermovate', 'Used for eczema, psoriasis, and skin irritation.', 500.00, 600239, 'dermovate-cream-50g-min.jpg', '2025-12-23 11:03:05'),
(72, 42, 'Fucidin', 'Antibacterial cream for skin infections', 420.00, 15, 'FucidinHCream15g_600x600.jpg', '2025-12-23 11:04:19'),
(73, 42, 'Neomycin', 'Helps prevent infection in minor cuts and burns', 350.00, 4971, 'neomycin-sulfate-cream.jpg', '2025-12-23 11:05:39'),
(74, 42, 'Skin Aqua Cream', 'Moisturizing and sun protection for sensitive skin', 600.00, 69964, 'skin-aqua-sunblock.webp', '2025-12-23 11:06:56'),
(75, 42, 'Eczema Relief Cream', 'Soothes dryness and itching for eczema-prone', 550.00, 29965, '8.jpg', '2025-12-23 11:09:08');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`purchase_id`, `product_id`, `vendor_id`, `purchase_price`, `quantity`, `image`, `created_at`) VALUES
(3, 62, 1, 40.00, 700, 'paracetamol.jpg', '2026-04-26 07:06:27'),
(4, 62, 1, 55.00, 900, 'paracetamol.jpg', '2026-04-26 08:57:47'),
(32, 75, 2, 550.00, 29999, '8.jpg', '2026-05-01 04:06:05'),
(33, 74, 2, 800.00, 69999, 'skin-aqua-sunblock.webp', '2026-05-01 04:33:50'),
(34, 73, 3, 250.00, 4997, 'neomycin-sulfate-cream.jpg', '2026-05-01 04:34:21'),
(35, 74, 2, 400.00, 69999, 'skin-aqua-sunblock.webp', '2026-05-01 04:34:35'),
(36, 72, 3, 300.00, 20, 'FucidinHCream15g_600x600.jpg', '2026-05-01 04:35:01'),
(37, 71, 1, 347.00, 600259, 'dermovate-cream-50g-min.jpg', '2026-05-01 04:35:17'),
(38, 70, 2, 580.00, 2000, 'calcijex-1-mcg-ml-iv-1-mlx-25-ampul-kutu-2132.jpg', '2026-05-01 04:35:30'),
(39, 70, 2, 580.00, 2000, 'calcijex-1-mcg-ml-iv-1-mlx-25-ampul-kutu-2132.jpg', '2026-05-01 04:35:42'),
(40, 69, 3, 500.00, 90000, 'Ketrolac-Injection.jpg', '2026-05-01 04:35:57'),
(41, 68, 3, 298.00, 100, 'penicillin-bottle-with-a-needle-and-syringe.jpg', '2026-05-01 04:36:09'),
(42, 67, 2, 579.00, 3985, 'Vitamin-B12-online-doctor-sa-south-africa-1.jpg', '2026-05-01 04:36:22'),
(43, 66, 2, 681.00, 14, '1800x1200_how_insulin_works_bigbead.jpg', '2026-05-01 04:36:34'),
(44, 65, 3, 130.00, 4344, 'f5a1e443205a1cd4aad0200c8996f8f3.jpg', '2026-05-01 04:36:54'),
(45, 64, 2, 232.00, 4999, '3664798024142_fbd920dd-4722-4ab2-8e4b-049cdb45cd54.jpg', '2026-05-01 04:37:07'),
(46, 63, 2, 300.00, 4000, '16029142479524901_360x@2x.png', '2026-05-01 04:37:20'),
(48, 75, 2, 400.00, 29999, '8.jpg', '2026-05-01 04:38:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `phone`, `created_at`, `password`) VALUES
(46, 'Ihsan Ullah', 'pak32642@gmail.com', '03015341769', '2026-05-06 11:21:34', '$2y$10$vrYTz1OnY/n0.4oZkHLMKufr6khdrsr.eqITBTy4XpdvMu05uUffW'),
(47, 'Sajjad', 'pak32645@gmail.com', '03279157424', '2026-05-17 06:24:52', '$2y$10$kug/4nmPoO5fpWQ271OeUepWN9a7tXJgDZfT5ILum58kVK8Qealp2'),
(48, 'Adnan', 'pak32641@gmail.com', '03000944006', '2026-05-18 02:19:10', '$2y$10$cl3PPtBEZ7Myp5SgWwUo/Ol8iBhFXaJIUnTxNqn7QiDZnL6sc/2aO'),
(49, 'adnan', 'pak32647@gmail.com', '03018702629', '2026-05-21 06:55:04', '$2y$10$.dFFZWde/U2i5zMhtT1XauPUBuidH7d1Ll8m/27mYwa9bnuc37D6C');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `vendor_id` int(11) NOT NULL,
  `vendor_name` varchar(100) NOT NULL,
  `vendor_address` varchar(255) NOT NULL,
  `vendor_phone` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`vendor_id`, `vendor_name`, `vendor_address`, `vendor_phone`, `created_at`) VALUES
(1, 'ali', 'zdfsd', '23423534645', '2026-04-26 07:02:45'),
(2, 'ihsan', 'zdfsed', '23423534645', '2026-04-26 07:04:01'),
(3, 'sajjad', 'gyi,ghm', '657896', '2026-04-26 12:10:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `contact_info`
--
ALTER TABLE `contact_info`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_orders_users` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `contact_info`
--
ALTER TABLE `contact_info`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`vendor_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
