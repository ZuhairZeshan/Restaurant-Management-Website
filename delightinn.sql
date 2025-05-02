-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2025 at 11:15 AM
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
-- Database: `delightinn`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Category_id` int(11) NOT NULL,
  `Category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Category_id`, `Category_name`) VALUES
(1, 'Starter'),
(2, 'Burgers'),
(3, 'Pizzas'),
(4, 'Sandwiches'),
(5, 'Continental'),
(6, 'Beverages');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('unread','read') NOT NULL DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `created_at`, `status`) VALUES
(1, 'Hamiz Siddiqui', 'hamizsiddiqui2003@gmail.com', 'ssdsdsdsd', '2024-12-04 01:48:30', 'read'),
(2, 'Hamiz Siddiqui', 'emily.davis@example.com', 'adsdsdsdsd', '2024-12-04 01:49:30', 'read'),
(3, 'Hamiz Siddiqui', 'emily.davis@example.com', 'adsdsdsdsd', '2024-12-04 01:49:59', 'read'),
(4, 'Zuhair Zeshan', 'zuhairzeshan@hotmail.com', 'dionsandaiosdkasdksamkdmasmdasoidasoidioasndosamdoasnduasdasdjas', '2024-12-04 03:59:05', 'unread'),
(5, 'Hamiz Siddiqui', 'hamizsiddiqui2003@gmail.com', 'Hi sample ms', '2024-12-05 10:23:59', 'read'),
(6, 'Hamiz Siddiqui', 'hamizsiddiqui2003@gmail.com', 'Hi how u', '2024-12-05 18:00:47', 'read'),
(7, 'Hamiz Siddiqui', 'hamizsiddiqui2003@gmail.com', 'iuasiusifu', '2024-12-05 18:11:18', 'read');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `emp_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `shift_time` varchar(50) NOT NULL,
  `hire_date` date NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`emp_id`, `name`, `role`, `salary`, `shift_time`, `hire_date`, `email`, `phone_number`, `address`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Michael Johnson', 'Manager', 4500.00, 'Morning', '2022-11-05', 'michael.johnson@example.com', '345-678-9012', '789 Oak St, Villageburg, ST 11223', 'active', '2024-12-03 11:18:30', '2024-12-03 11:18:30'),
(4, 'Emily Davis', 'Waiter', 3000.00, 'Evening', '2023-03-10', 'emily.davis@example.com', '456-789-0123', '101 Pine St, Hamlet, ST 44556', 'active', '2024-12-03 11:18:30', '2024-12-03 23:10:35'),
(6, 'MUHAMMAD SIDDDIQUI', 'Waitress', 2000.00, 'Morning', '0000-00-00', 'hamizsiddiqui2003@gmail.com', NULL, NULL, 'active', '2024-12-03 12:26:23', '2024-12-03 12:26:23'),
(7, 'Hamiz', 'Waiter', 30000.00, 'Night', '0000-00-00', 'zuhairzeshan@hotmail.com', NULL, NULL, 'active', '2024-12-03 12:37:52', '2024-12-05 10:31:03');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_name`, `quantity`, `price`, `description`) VALUES
(1, 'Product 1', 5, 19.00, 'This is product 1'),
(2, 'Product 2', 17, 29.00, 'This is product 2'),
(3, 'Product 3', 20, 9.00, 'This is product 3');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_id` int(11) NOT NULL,
  `Item_image` varchar(800) NOT NULL,
  `Item_name` varchar(50) NOT NULL,
  `Item_description` varchar(500) NOT NULL,
  `Price` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_id`, `Item_image`, `Item_name`, `Item_description`, `Price`, `cat_id`) VALUES
(1, 'https://images.pexels.com/photos/1893555/pexels-photo-1893555.jpeg?auto=compress&cs=tinysrgb&w=600', 'French Fries', 'A snack typically made from deep-fried potatoes that have been cut in thin strips', 520, 1),
(2, 'https://t4.ftcdn.net/jpg/05/67/61/35/240_F_567613541_rABRpKAjdD3Hyo3e3ebVEx7VHBiF5kHI.jpg', 'Zinger Burger', 'Delicious pieces of juicy chicken thigh with Desi Spicy Zinger Recipe, cheese, fresh lettuce in a fresh round bun sure but Mightier to suit your major hunger needs.', 750, 2),
(3, 'https://pizza.cafeela.pk/wp-content/uploads/2021/05/Chicken-Supreme-Pizza.jpg', 'Supreme Pizza', 'A supreme pizza typically includes a base of pizza dough, tomato sauce, and mozzarella cheese. Common meat toppings are pepperoni, Italian sausage, and sometimes ham or bacon. Vegetables like bell peppers, onions, mushrooms, and black olives add flavor. Optional extras include jalapeños, spinach, or pineapple for a personalized touch.', 1799, 3),
(4, 'https://thumbs.dreamstime.com/z/top-view-half-pepperoni-pizza-wooden-round-board-background-decorative-elements-horizontal-side-176425579.jpg', 'Pepperoni', 'dkfndjksfsdgfsdbfhsbdhfbsdhfbdshbdshbfhdsfds', 1799, 3),
(5, 'https://images.pexels.com/photos/14537698/pexels-photo-14537698.jpeg?auto=compress&cs=tinysrgb&w=600', 'Crispy Chicken Tenders ', 'Thin strips of boneless, skinless chicken breast that are typically breaded and fried. They are often served with dipping sauces, such as ketchup, barbecue or buffalo sauce, or honey mustard. Chicken tenders are usually tender and juicy, making them popular with both adults and kids.', 599, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `Order_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `Order_date` date NOT NULL DEFAULT current_timestamp(),
  `Total_amount` int(20) NOT NULL,
  `Order_type` varchar(255) NOT NULL,
  `Order_status` enum('pending','approved','completed','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`Order_id`, `User_id`, `Order_date`, `Total_amount`, `Order_type`, `Order_status`) VALUES
(6, 1, '2024-11-24', 2389, 'pickup', 'completed'),
(7, 1, '2024-11-24', 1718, 'pickup', 'rejected'),
(8, 2, '2024-11-24', 1040, 'pickup', 'completed'),
(9, 1, '2024-11-27', 1639, 'delivery', 'rejected'),
(10, 2, '2024-11-27', 0, 'pickup', 'completed'),
(11, 1, '2024-12-03', 1718, 'pickup', 'completed'),
(12, 2, '2024-12-03', 1718, 'pickup', 'rejected'),
(13, 1, '2024-12-03', 1718, 'pickup', 'completed'),
(14, 1, '2024-12-03', 1718, 'pickup', 'completed'),
(15, 1, '2024-12-03', 4348, 'delivery', 'completed'),
(16, 1, '2024-12-04', 1718, 'delivery', 'rejected'),
(17, 2, '2024-12-04', 1718, 'delivery', 'completed'),
(18, 2, '2024-12-04', 1718, 'delivery', 'completed'),
(19, 2, '2024-12-04', 1718, 'delivery', 'completed'),
(20, 2, '2024-12-04', 1718, 'delivery', 'completed'),
(21, 2, '2024-12-04', 1718, 'delivery', 'pending'),
(22, 1, '2024-12-04', 1718, 'delivery', 'completed'),
(23, 1, '2024-12-04', 1718, 'delivery', 'rejected'),
(24, 1, '2024-12-05', 1718, 'delivery', 'completed'),
(25, 1, '2024-12-05', 1119, 'delivery', 'approved'),
(26, 1, '2024-12-05', 1119, 'pickup', 'rejected'),
(27, 1, '2024-12-06', 2549, 'delivery', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `card_number` varchar(20) NOT NULL,
  `expiry_date` varchar(7) NOT NULL,
  `cvv` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `card_number`, `expiry_date`, `cvv`) VALUES
(22, '123456789', '07/25', '256');

-- --------------------------------------------------------

--
-- Table structure for table `quantities`
--

CREATE TABLE `quantities` (
  `Id` int(11) NOT NULL,
  `Order_id` int(11) NOT NULL,
  `Item_id` int(11) NOT NULL,
  `Quantity` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quantities`
--

INSERT INTO `quantities` (`Id`, `Order_id`, `Item_id`, `Quantity`) VALUES
(1, 6, 1, 2),
(2, 6, 2, 1),
(3, 6, 5, 1),
(4, 7, 1, 1),
(5, 7, 5, 2),
(6, 8, 1, 2),
(7, 9, 1, 2),
(8, 9, 5, 1),
(9, 11, 1, 1),
(10, 11, 5, 2),
(11, 12, 1, 1),
(12, 12, 5, 2),
(13, 13, 1, 1),
(14, 13, 5, 2),
(15, 14, 1, 1),
(16, 14, 5, 2),
(17, 15, 2, 1),
(18, 15, 3, 1),
(19, 15, 4, 1),
(20, 16, 1, 1),
(21, 16, 5, 2),
(22, 17, 1, 1),
(23, 17, 5, 2),
(24, 18, 1, 1),
(25, 18, 5, 2),
(26, 19, 1, 1),
(27, 19, 5, 2),
(28, 20, 1, 1),
(29, 20, 5, 2),
(30, 21, 1, 1),
(31, 21, 5, 2),
(32, 22, 1, 1),
(33, 22, 5, 2),
(34, 23, 1, 1),
(35, 23, 5, 2),
(36, 24, 1, 1),
(37, 24, 5, 2),
(38, 25, 1, 1),
(39, 25, 5, 1),
(40, 26, 1, 1),
(41, 26, 5, 1),
(42, 27, 2, 1),
(43, 27, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `User_id` int(11) NOT NULL,
  `reservation_time` datetime DEFAULT NULL,
  `status` enum('pending','approved','rejected','completed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `customer_name`, `customer_email`, `table_id`, `User_id`, `reservation_time`, `status`) VALUES
(5, 'Zuhair Zeshan', 'hamiz_siddi@email.com', 1, 1, '2024-12-02 22:41:00', 'completed'),
(6, 'Zuhair Zeshan', 'hamiz_siddi2@email.com', 2, 2, '2024-12-02 02:49:00', 'completed'),
(8, 'hamiz siddiqui', 'hamiziddi@email.com', 2, 2, '2024-12-02 22:58:00', 'rejected'),
(9, 'Zuhair Zeshan', 'hiziddi@email.com', 1, 2, '2024-12-02 22:59:00', 'completed'),
(10, 'Zuhair Zeshan', 'hiziddisddsds@email.com', 1, 1, '2024-12-02 16:10:00', 'rejected'),
(11, 'hamiz siddiqui', 'hizidsdsddi@email.com', 1, 2, '2024-12-02 23:09:00', 'completed'),
(12, 'hamiz siddiqui', 'hiziddisjkbjddsds@email.com', 2, 2, '2025-01-02 14:12:00', 'completed'),
(13, 'Zuhair Zeshan', 'hamiz_suiiiddi3@email.com', 1, 2, '2024-12-28 14:17:00', 'rejected'),
(14, 'Zuhair Zeshan', 'hiziddisddsds@email.com', 1, 1, '2024-12-02 23:24:00', 'completed'),
(15, 'Affan Ahmed', 'affanahmed@hotmail.com', 1, 1, '2024-12-02 23:31:00', 'rejected'),
(16, 'hamiz siddiqui', 'hamizsiddiqui2003@gmail.com', 1, 2, '2024-12-03 23:36:00', 'rejected'),
(17, 'Affan Ahmed', 'zuhairzeshan@hotmail.com', 1, 1, '2024-12-04 15:10:00', 'completed'),
(18, 'Zuhair Zeshan', 'zuhairzeshan@hotmail.com', 2, 1, '2024-12-11 00:21:00', 'rejected'),
(19, 'Zuhair Zeshan', 'hamiz_siddi@email.com', 2, 1, '2024-12-03 10:37:00', 'rejected'),
(20, 'Affan Ahmed', 'zuhairzeshan@hotmail.com', 3, 1, '2024-12-19 01:45:00', 'completed'),
(21, 'Hamiz', 'hamiz_siddi@email.com', 1, 1, '2024-12-18 18:24:00', 'approved'),
(22, 'hamiz siddiqui', 'hamiz_siddi@email.com', 2, 1, '2024-12-16 02:12:00', 'approved'),
(23, 'Zuhair Zeshan', 'zuhairzeshan@hotmail.com', 3, 1, '2024-12-06 09:37:00', 'rejected');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `Id` int(11) NOT NULL,
  `Table_no` int(11) NOT NULL,
  `seats` int(11) NOT NULL,
  `is_occupied` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`Id`, `Table_no`, `seats`, `is_occupied`) VALUES
(1, 1, 2, 1),
(2, 2, 4, 1),
(3, 3, 2, 0),
(4, 4, 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_id` int(11) NOT NULL,
  `User_name` varchar(50) NOT NULL,
  `User_email` varchar(50) NOT NULL,
  `User_pass` varchar(100) NOT NULL,
  `Contact_info` int(11) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_id`, `User_name`, `User_email`, `User_pass`, `Contact_info`, `Address`, `Time`) VALUES
(1, 'Zuhair Zeshan', 'zuhairzeshan7895@gmail.com', '$2y$10$f3gcWWEKTdrkNR3TGjl4Ku0MTr7/sGmvDyqc/IFFbi3U4wcYLi1Sm', 2147483647, 'Gulshan-e-iqbal, block-1', '2024-11-16 15:20:00'),
(2, 'Hamiz SIddiqui', 'hamiz@gmail.com', '$2y$10$vG2UMmaG0Wg9rDpJlmZLc.iLWZd9MgYuuDqYwsr5.HRZKROnUzqcC', 2147483647, 'A-60,Street 8, Block 7, Gulistan e Jauhar', '2024-12-04 03:54:55'),
(3, 'affan ahmed', 'hamiz58858@gmail.com', '$2y$10$UYpmiD5ymgniBXxNM/QFve3y9Ry9Zp.65EX.Ni34K8ris71sMkidi', 2147483647, 'A-155, Sindh Baloch Co-operative Housing Society Block 12', '2024-12-05 10:19:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Category_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`emp_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`Order_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `quantities`
--
ALTER TABLE `quantities`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `table_id` (`table_id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `Order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `quantities`
--
ALTER TABLE `quantities`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`table_id`) REFERENCES `tables` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
