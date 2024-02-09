-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2024 at 04:59 PM
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
-- Database: `union_fashion_mall`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Women Clothing', '2024-01-24 13:08:51', NULL),
(2, 'Men Clothing', '2024-01-24 13:08:51', NULL),
(3, 'Women Shoes & Sandals', '2024-01-24 13:09:39', NULL),
(4, 'Men Shoes & Sandals', '2024-01-24 13:09:39', NULL),
(5, 'Back Bags', '2024-01-24 13:11:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_no` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `detailed_message` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `name`, `email`, `phone_no`, `subject`, `detailed_message`, `created_at`, `updated_at`) VALUES
(1, 'Lomon', 'lomon@gmail.com', '0912345678', 'This is feedback one.', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.', '2024-02-01 18:10:37', NULL),
(2, 'Becky', 'becky@gmail.com', '0912345678', 'This is feedback two.', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.', '2024-02-01 18:10:37', NULL),
(3, 'Sue', 'sue@gmail.com', '0912345678', 'This is feedback three.', 'Li Europan lingues es membres del sam familie. Lor separat existentie es un myth. Por scientie, musica, sport etc, litot Europa usa li sam vocabular. Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules.', '2024-02-01 18:10:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `shipping_information` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `cart` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `shipping_information`, `payment_method`, `cart`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(3, '{\"first_name\":\"Kristen\",\"last_name\":\"St.\",\"email\":\"kristen@gmail.com\",\"phone_no\":\"0912345678\",\"address\":\"somewhere\",\"city\":\"somewhere\",\"region\":\"somewhere\",\"postal_code\":\"111\"}', '{\"card_number\":\"111\",\"nameoncard\":\"Kristen St.\",\"mmyy\":\"11\\/11\",\"cvv\":\"11\"}', '{\"4\":{\"id\":4,\"code\":\"WC4\",\"image\":\"WC4.jpg\",\"name\":\"Lady Jean L\\/Pants\",\"details\":\"Barcode: 100000027488\",\"price\":28000,\"stock\":2,\"category_id\":1,\"qty\":1},\"8\":{\"id\":8,\"code\":\"WC8\",\"image\":\"WC8.jpg\",\"name\":\"Seed Zad Lady Teddy Bear Tee CropTop\",\"details\":\"Barcode: 100000026482\",\"price\":12000,\"stock\":5,\"category_id\":1,\"qty\":\"2\"}}', 1, 1, '2024-01-31 00:26:15', '2024-02-04 00:13:08'),
(7, '{\"first_name\":\"Kristen\",\"last_name\":\"St.\",\"email\":\"kristen@gmail.com\",\"phone_no\":\"0912345678\",\"address\":\"somewhere\",\"city\":\"somewhere\",\"region\":\"somewhere\",\"postal_code\":\"111\"}', '{\"card_number\":\"111\",\"nameoncard\":\"Kristen St.\",\"mmyy\":\"1111\",\"cvv\":\"111\"}', '{\"1\":{\"id\":1,\"code\":\"WC1\",\"image\":\"WC1.jpg\",\"name\":\"Lady Blouse (Cotton Print)\",\"details\":\"Design: Design 1|Color: Red|Barcode: 100000024868_brown_design1\",\"price\":17000,\"stock\":3,\"category_id\":1,\"qty\":2},\"2\":{\"id\":2,\"code\":\"WC2\",\"image\":\"WC2.jpg\",\"name\":\"Coco Cotton Long Pants\",\"details\":\"Size: XL|Color: Black\",\"price\":20500,\"stock\":2,\"category_id\":1,\"qty\":\"2\"}}', 1, 0, '2024-02-01 21:55:52', '2024-02-04 00:13:16'),
(8, '{\"first_name\":\"Henry\",\"last_name\":\"C.\",\"email\":\"henry@gmail.com\",\"phone_no\":\"0912345678\",\"address\":\"somewhere\",\"city\":\"somewhere\",\"region\":\"somewhere\",\"postal_code\":\"111\"}', '{\"card_number\":\"453\",\"nameoncard\":\"Henry C.\",\"mmyy\":\"345\",\"cvv\":\"3453\"}', '{\"31\":{\"id\":31,\"code\":\"MS1\",\"image\":\"MS1.jpg\",\"name\":\"Reform Men Slipper\",\"details\":\"Size: 42|Color: Black\",\"price\":40000,\"stock\":2,\"category_id\":4,\"qty\":\"2\"}}', 4, 0, '2024-02-01 22:06:50', '2024-02-08 16:07:13'),
(9, '{\"first_name\":\"Mingyuk\",\"last_name\":\"L.\",\"email\":\"mingyuk@gmail.com\",\"phone_no\":\"0912345678\",\"address\":\"somewhere\",\"city\":\"somewhere\",\"region\":\"somewhere\",\"postal_code\":\"111\"}', '{\"card_number\":\"1111\",\"nameoncard\":\"Mingyuk L.\",\"mmyy\":\"111\",\"cvv\":\"111\"}', '{\"11\":{\"id\":11,\"code\":\"MC1\",\"image\":\"MC1.jpg\",\"name\":\"August Men Shirt Long Sleeve (L)\",\"details\":\"Design: Design 1|Color:Light Blue|Barcode: 8830000141920\",\"price\":29000,\"stock\":4,\"category_id\":2,\"qty\":4}}', 5, 1, '2024-02-08 08:25:49', '2024-02-08 16:07:08');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `code`, `image`, `name`, `details`, `price`, `stock`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'WC1', 'WC1.jpg', 'Lady Blouse (Cotton Print)', 'Design: Design 1|Color: Red|Barcode: 100000024868_brown_design1', 17000, 1, 1, '2024-01-26 02:57:13', '2024-02-09 14:50:55'),
(2, 'WC2', 'WC2.jpg', 'Coco Cotton Long Pants', 'Size: XL|Color: Black', 20500, 0, 1, '2024-01-26 02:57:13', '2024-02-03 22:58:24'),
(3, 'WC3', 'WC3.jpg', 'Lady Warchi Pikepanhtozar Set', 'Color: Brown|Barcode: 100000026980_brown', 18000, 3, 1, '2024-01-26 02:57:13', '2024-02-03 23:03:18'),
(4, 'WC4', 'WC4.jpg', 'Lady Jean L/Pants', 'Barcode: 100000027488', 28000, 2, 1, '2024-01-26 02:57:13', NULL),
(5, 'WC5', 'WC5.jpg', 'Lady Cylon Cardigan & 1String Dress L/S', 'Barcode: 100000027581', 22500, 2, 1, '2024-01-26 02:57:13', NULL),
(6, 'WC6', 'WC6.jpg', 'Lady Cylon Solid Fancy Top L/S', 'Barcode: 100000027562', 16500, 1, 1, '2024-01-26 02:57:13', NULL),
(7, 'WC7', 'WC7.jpg', 'Lady Sweater Solid Dress L/S', 'Barcode: 100000027474', 18000, 2, 1, '2024-01-26 02:57:13', NULL),
(8, 'WC8', 'WC8.jpg', 'Seed Zad Lady Teddy Bear Tee CropTop', 'Barcode: 100000026482', 12000, 5, 1, '2024-01-26 02:57:13', NULL),
(9, 'WC9', 'WC9.jpg', 'Lady Hmanzar Upperwear Cardigan', 'Size: Free Size|Color:Black|Barcode: 100000024963_black', 17000, 1, 1, '2024-01-26 02:57:13', NULL),
(10, 'WC10', 'WC10.jpg', 'Lady Chiffon Solid BL-2160(8C)', 'Size: Free Size|Color:Pink|Barcode: 100000020737', 17000, 2, 1, '2024-01-26 02:57:13', NULL),
(11, 'MC1', 'MC1.jpg', 'August Men Shirt Long Sleeve (L)', 'Design: Design 1|Color:Light Blue|Barcode: 8830000141920', 29000, 0, 2, '2024-01-26 02:57:13', '2024-02-08 08:25:49'),
(12, 'MC2', 'MC2.jpg', 'August Stripe Men Shirt Short Sleeve (L)', 'Design: Design 1|Color: Black|Barcode: 8830000141890', 28000, 3, 2, '2024-01-26 02:57:13', NULL),
(13, 'MC3', 'MC3.jpg', 'Men Sweater', 'Size: L|Color: Blue|Barcode: 100000018162', 17000, 2, 2, '2024-01-26 02:57:13', NULL),
(14, 'MC4', 'MC4.jpg', 'Jin Yida Men Jean Pant_2321/29-38/Blue', 'Size: 29|Barcode: 100000024374', 32000, 3, 2, '2024-01-26 02:57:13', NULL),
(15, 'MC5', 'MC5.jpg', 'Fufei Men Jean Pant _729', 'Size: 31|Barcode: 100000024369', 32000, 4, 2, '2024-01-26 02:57:13', NULL),
(16, 'MC6', 'MC6.jpg', 'U Gyan Mahar New Poe Longyi', 'Color: Purple|Barcode: 6140026', 31300, 2, 2, '2024-01-26 02:57:13', NULL),
(17, 'MC7', 'MC7.jpg', 'Oasis Men Woven Shirt S/S (XL)', 'Barcode: 8856161245192', 32500, 4, 2, '2024-01-26 02:57:13', NULL),
(18, 'MC8', 'MC8.jpg', 'U Gyan (Poe Twel Gyi)', 'Color: Blue|Barcode: 6140024', 29500, 2, 2, '2024-01-26 02:57:13', NULL),
(19, 'MC9', 'MC9.jpg', 'Kiddo Trouser', 'Size: 30|Color: Black|Barcode: 5550012440752', 35000, 4, 2, '2024-01-26 02:57:13', NULL),
(20, 'MC10', 'MC10.jpg', 'Oasis Short Pant Size(32)_Brown', 'Barcode: 8856161230945', 35000, 1, 2, '2024-01-26 02:57:13', NULL),
(21, 'WS1', 'WS1.jpg', 'FaRa Lady Shoe FGLC-ZDB01-12', 'Size: 39|Color: Brown|Barcode: 8856161439812', 35000, 2, 3, '2024-01-26 02:57:13', NULL),
(22, 'WS2', 'WS2.png', 'Lady Sport Shoe_2169', 'Size: 38|Barcode: 120000008246', 30000, 2, 3, '2024-01-26 02:57:13', NULL),
(23, 'WS3', 'WS3.png', 'Lady Sport Shoe-2219', 'Size: 37|Barcode: 120000008242_36', 29500, 1, 3, '2024-01-26 02:57:13', NULL),
(24, 'WS4', 'WS4.png', 'Lady Casual Shoe', 'Size: 38|Color: Grey|Barcode: 120000008458', 11500, 3, 3, '2024-01-26 02:57:13', NULL),
(25, 'WS5', 'WS5.png', 'Lady Rain Slipper_2021-1', 'Size: 38|Color: Purple', 5500, 4, 3, '2024-01-26 02:57:13', NULL),
(26, 'WS6', 'WS6.png', 'Twist Design Lady Highheel', 'Size: 36|Barcode: 120000007457', 18000, 1, 3, '2024-01-26 02:57:13', NULL),
(27, 'WS7', 'WS7.jpg', 'Fa Ra Lady Shoe FGLC-A3693-2', 'Size: 38|Barcode: 8856161436743', 29500, 3, 3, '2024-01-26 02:57:13', NULL),
(28, 'WS8', 'WS8.jpg', 'Fa Ra Lady Shoe FGLC-1798-156', 'Size: 38|Barcode: 8856161436804', 35000, 2, 3, '2024-01-26 02:57:13', NULL),
(29, 'WS9', 'WS9.jpg', 'Youyunrhuo Lady Business Shoes', 'Barcode: 120000006661', 15000, 2, 3, '2024-01-26 02:57:13', NULL),
(30, 'WS10', 'WS10.jpg', 'Lady Sneaker Shoes', 'Size: 38|Barcode: 120000006953', 30000, 4, 3, '2024-01-26 02:57:13', NULL),
(31, 'MS1', 'MS1.jpg', 'Reform Men Slipper', 'Size: 42|Color: Black', 40000, 0, 4, '2024-01-26 02:57:13', '2024-02-01 22:06:50'),
(32, 'MS2', 'MS2.jpg', 'Reform Men Business Shoe-RGZC-2104', 'Size: 40|Barcode: 8856161436958', 38000, 3, 4, '2024-01-26 02:57:13', NULL),
(33, 'MS3', 'MS3.jpg', 'Reform Men Slipper', 'Size: 41|Color: Coffee|Barcode: 8856161438501_coffee40', 40000, 2, 4, '2024-01-26 02:57:13', NULL),
(34, 'MS4', 'MS4.png', 'Men Casual Shoe', 'Size: 43|Color: Black|Barcode: 120000008540', 15000, 4, 4, '2024-01-26 02:57:13', NULL),
(35, 'MS5', 'MS5.png', 'Men Sport Shoe-2270', 'Size: 41|Barcode: 120000007201', 35000, 1, 4, '2024-01-26 02:57:13', NULL),
(36, 'MS6', 'MS6.jpg', 'Reform Men Business Shoe_RGZC-2106', 'Size: 42|Barcode: 8856161436972', 38000, 3, 4, '2024-01-26 02:57:13', NULL),
(37, 'MS7', 'MS7.jpg', 'Reform Men Business Shoe_RGZC-2107', 'Size: 44|Barcode: 8856161436989', 40000, 1, 4, '2024-01-26 02:57:13', NULL),
(38, 'MS8', 'MS8.png', 'Men Casual Shoe', 'Size: 40|Color: Brown', 15000, 1, 4, '2024-01-26 02:57:13', NULL),
(39, 'MS9', 'MS9.png', 'Men Sport Shoe-2239', 'Size: 41|Barcode: 120000006970', 31000, 2, 4, '2024-01-26 02:57:13', NULL),
(40, 'MS10', 'MS10.png', 'Men Sport Shoe-FB2166', 'Size: 41|Barcode: 120000005343', 24000, 3, 4, '2024-01-26 02:57:13', NULL),
(41, 'BB1', 'BB1.png', 'BackPack 18\"', 'Barcode: 120000008214', 25000, 2, 5, '2024-01-26 02:57:13', NULL),
(42, 'BB2', 'BB2.png', 'BackPack 18\"', 'Barcode: 120000008213', 23000, 2, 5, '2024-01-26 02:57:13', NULL),
(43, 'BB3', 'BB3.jpg', 'Sport Backpack (18\")', 'Barcode: 120000006095', 25000, 3, 5, '2024-01-26 02:57:13', NULL),
(44, 'BB4', 'BB4.jpg', 'Sport Backpack (18\")', 'Barcode: 120000006089', 23000, 1, 5, '2024-01-26 02:57:13', NULL),
(45, 'BB5', 'BB5.jpg', 'Back Pack (17\")', 'Barcode: 120000005975', 19500, 2, 5, '2024-01-26 02:57:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `profile`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'meow1.jpg', 'Kristen', 'kristen@gmail.com', '$2y$10$b/PsjydyDz6.INdX2fNju.c8ULUsvRrevFNYm5XDSaNHWoli5LVAK', '2024-01-27 11:47:48', '2024-02-05 08:23:01'),
(2, 'meow2.jpg', 'Freen', 'freen@gmail.com', '$2y$10$HW2zrYMkE2bSBzZSxEvRseaMX9X1nPX2qHFSs/WIdjsrTsWCke63a', '2024-01-29 09:47:24', '2024-02-09 22:03:40'),
(3, 'meow3.jpg', 'Emma', 'emma@gmail.com', '$2y$10$sxFCJ6GiXX9rTlu0wvKFIOm9if9ZqHy/Jl1Cmx35LprxPxqtfH5Lq', '2024-01-29 09:51:07', '2024-02-09 22:04:31'),
(4, 'default_profile.jpg', 'Henry', 'henry@gmail.com', '$2y$10$TI6.6SCLGCfjPjGDSXK8.eUEvONEESamd/qqj8KwtVLiMWtUSHdBG', '2024-01-29 10:29:01', NULL),
(5, 'meow4.jpg', 'Mingyuk', 'mingyuk@gmail.com', '$2y$10$OmhWN81daogtIEdKKv1Dxe8pWZirznjxaP/Ll34asaYYC6YyoERhK', '2024-02-02 01:09:26', '2024-02-09 22:05:33');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `status`, `created_at`, `updated_at`) VALUES
(165, 1, 28, 1, '2024-02-09 22:24:25', NULL),
(166, 1, 30, 1, '2024-02-09 22:24:28', NULL),
(167, 2, 7, 1, '2024-02-09 22:25:04', NULL),
(168, 2, 4, 1, '2024-02-09 22:25:11', NULL),
(169, 3, 42, 1, '2024-02-09 22:25:35', '2024-02-09 22:28:12'),
(170, 4, 37, 1, '2024-02-09 22:26:02', '2024-02-09 22:26:06'),
(171, 4, 41, 1, '2024-02-09 22:26:16', NULL),
(172, 5, 20, 1, '2024-02-09 22:26:41', NULL),
(173, 5, 40, 1, '2024-02-09 22:26:50', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `wishlists_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
