-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2023 at 02:02 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `themoviebook`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admins`
--

CREATE TABLE `tbl_admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `verification_code` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_admins`
--

INSERT INTO `tbl_admins` (`admin_id`, `username`, `password`, `first_name`, `last_name`, `email`, `mobile`, `verification_code`) VALUES
(7, 'admin', '14ff00b04c017ecf49498a0a1a161806', 'Divakar', 'Singh', 'test@gmail.com', '9999999999', 1234);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking`
--

CREATE TABLE `tbl_booking` (
  `ticket_id` int(200) NOT NULL,
  `timestamp` datetime NOT NULL,
  `user_id` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `movie_id` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `theatre_id` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `show_id` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `seat_cat` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `seats` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `screen` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `showdate` date NOT NULL,
  `showtime` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `amount` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `payment_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_booking`
--

INSERT INTO `tbl_booking` (`ticket_id`, `timestamp`, `user_id`, `movie_id`, `theatre_id`, `show_id`, `seat_cat`, `seats`, `screen`, `showdate`, `showtime`, `amount`, `payment_status`) VALUES
(1, '2023-07-20 17:20:46', '3', '5', '4', '8', 'Recliners', 'A3', '2', '2023-07-22', '10:00 AM', '429.5', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_booking_temp`
--

CREATE TABLE `tbl_booking_temp` (
  `temp_ticket_id` int(200) NOT NULL,
  `timestamp` datetime NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `movie_id` varchar(200) NOT NULL,
  `theatre_id` varchar(200) NOT NULL,
  `show_id` varchar(200) NOT NULL,
  `seat_cat` varchar(200) NOT NULL,
  `seats` varchar(200) NOT NULL,
  `screen` varchar(200) NOT NULL,
  `showdate` date NOT NULL,
  `showtime` varchar(200) NOT NULL,
  `amount` varchar(200) NOT NULL,
  `payment_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_booking_temp`
--

INSERT INTO `tbl_booking_temp` (`temp_ticket_id`, `timestamp`, `user_id`, `movie_id`, `theatre_id`, `show_id`, `seat_cat`, `seats`, `screen`, `showdate`, `showtime`, `amount`, `payment_status`) VALUES
(18, '2023-07-20 17:20:43', '3', '5', '4', '8', 'Recliners', 'A3', '2', '2023-07-22', '10:00 AM', '429.5', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_carousel`
--

CREATE TABLE `tbl_carousel` (
  `id` int(10) NOT NULL,
  `movie_id` varchar(11) NOT NULL,
  `carousel_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_carousel`
--

INSERT INTO `tbl_carousel` (`id`, `movie_id`, `carousel_image`) VALUES
(4, '5', 'https://image.tmdb.org/t/p/original/rktDFPbfHfUbArZ6OOOKsXcv0Bm.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_common_seat_categories`
--

CREATE TABLE `tbl_common_seat_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_common_seat_categories`
--

INSERT INTO `tbl_common_seat_categories` (`category_id`, `category_name`) VALUES
(5, 'Recliners'),
(6, 'Diamond'),
(7, 'Gold');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_us`
--

CREATE TABLE `tbl_contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `phone` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `message` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_movies`
--

CREATE TABLE `tbl_movies` (
  `movie_id` int(10) NOT NULL,
  `movie_name` varchar(100) NOT NULL,
  `year` year(4) NOT NULL,
  `category` varchar(200) NOT NULL,
  `running_time` varchar(200) NOT NULL,
  `release_date` date NOT NULL,
  `language` varchar(200) NOT NULL,
  `director` varchar(100) NOT NULL,
  `synopsis` varchar(1000) NOT NULL,
  `casts` varchar(500) NOT NULL,
  `poster` text NOT NULL,
  `banner` text NOT NULL,
  `wallpaper` longblob NOT NULL,
  `trailer_url` varchar(1000) NOT NULL,
  `status` int(1) NOT NULL,
  `starting_date` date NOT NULL,
  `ending_date` date NOT NULL,
  `avg_ratings` float NOT NULL,
  `total_ratings` float NOT NULL,
  `num_of_ratings` int(11) NOT NULL,
  `user_ip_addresses` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_movies`
--

INSERT INTO `tbl_movies` (`movie_id`, `movie_name`, `year`, `category`, `running_time`, `release_date`, `language`, `director`, `synopsis`, `casts`, `poster`, `banner`, `wallpaper`, `trailer_url`, `status`, `starting_date`, `ending_date`, `avg_ratings`, `total_ratings`, `num_of_ratings`, `user_ip_addresses`) VALUES
(5, 'The Flash', '2023', 'Science Fiction, Adventure, Action', '144 Minutes', '2023-06-13', 'P??????, Español, English', 'Andy Muschietti', 'When his attempt to save his family inadvertently alters the future, Barry Allen becomes trapped in a reality in which General Zod has returned and there are no Super Heroes to turn to. In order to save the world that he is in and return to the future that he knows, Barry\'s only hope is to race for his life. But will making the ultimate sacrifice be enough to reset the universe?', 'Ezra Miller, Sasha Calle, Michael Keaton, Michael Shannon', 'https://image.tmdb.org/t/p/w185_and_h278_bestv2/rktDFPbfHfUbArZ6OOOKsXcv0Bm.jpg', 'https://image.tmdb.org/t/p/original/rktDFPbfHfUbArZ6OOOKsXcv0Bm.jpg', '', 'https://www.youtube.com/watch?v=hebWYacbdvc', 1, '2023-07-12', '2023-07-31', 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seat_maps`
--

CREATE TABLE `tbl_seat_maps` (
  `seat_id` int(200) NOT NULL,
  `seat_category_id` int(11) NOT NULL,
  `seat_number` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_seat_maps`
--

INSERT INTO `tbl_seat_maps` (`seat_id`, `seat_category_id`, `seat_number`) VALUES
(8, 8, '[[\"A1,A2,A3,A4,A5,A6,A7,A8,A9,A10\"],[\"B1,B2,B3,B4,B5,B6,B7,B8\",\"C1,C2,C3,C4,C5,C6,C7,C8\",\"D1,D2,D3,D4,D5,D6,D7,D8\",\"E1,E2,E3,E4,E5,E6,E7,E8\"],[\"F1,F2,F3,F4,F5,F6,F7,F8\",\"G1,G2,G3,G4,G5,G6,G7,G8\",\"H1,H2,H3,H4,H5,H6,H7,H8\",\"I1,I2,I3,I4,I5,I6,I7,I8\",\"J1,J2,J3,J4,J5,J6,J7,J8\",\"K1,K2,K3,K4,K5,K6,K7,K8\"]]'),
(9, 9, '[[\"A1,A2,A3,A4,A5\"],[\"B1,B2,B3,B4,B5,B6,B7\",\"C1,C2,C3,C4,C5,C6,C7\",\"D1,D2,D3,D4,D5,D6,D7\",\"E1,E2,E3,E4,E5,E6,E7\",\"F1,F2,F3,F4,F5,F6,F7\",\"G1,G2,G3,G4,G5,G6,G7\"]]');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shows`
--

CREATE TABLE `tbl_shows` (
  `show_id` int(2) NOT NULL,
  `theatre_id` int(10) NOT NULL,
  `movie_id` int(10) NOT NULL,
  `starting_date` date NOT NULL,
  `ending_date` date NOT NULL,
  `screen` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_shows`
--

INSERT INTO `tbl_shows` (`show_id`, `theatre_id`, `movie_id`, `starting_date`, `ending_date`, `screen`) VALUES
(7, 4, 5, '2023-07-31', '2023-12-31', '1'),
(8, 4, 5, '2023-07-21', '2023-12-31', '2');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_showtimes`
--

CREATE TABLE `tbl_showtimes` (
  `showtime_id` int(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `starting_time` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_showtimes`
--

INSERT INTO `tbl_showtimes` (`showtime_id`, `show_id`, `starting_time`) VALUES
(12, 8, '[\"10:00\",\"15:00\"]'),
(13, 7, '[\"18:00\"]');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_show_ticket_rates`
--

CREATE TABLE `tbl_show_ticket_rates` (
  `ticket_rate_id` int(10) NOT NULL,
  `show_id` int(10) NOT NULL,
  `ticket_category_id` int(11) NOT NULL,
  `category` varchar(200) NOT NULL,
  `ticket_rate` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_show_ticket_rates`
--

INSERT INTO `tbl_show_ticket_rates` (`ticket_rate_id`, `show_id`, `ticket_category_id`, `category`, `ticket_rate`) VALUES
(11, 8, 9, '[\"5\",\"6\"]', '[\"400\",\"250\"]'),
(12, 7, 8, '[\"5\",\"6\",\"7\"]', '[\"400\",\"250\",\"150\"]');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_theatres`
--

CREATE TABLE `tbl_theatres` (
  `theatre_id` int(10) NOT NULL,
  `theatre_name` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `telephone` int(10) NOT NULL,
  `website` varchar(100) NOT NULL,
  `image` longtext NOT NULL,
  `status` int(11) NOT NULL,
  `screens` int(10) NOT NULL,
  `avg_ratings` float NOT NULL,
  `total_ratings` float NOT NULL,
  `num_of_ratings` int(11) NOT NULL,
  `user_ip_addresses` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_theatres`
--

INSERT INTO `tbl_theatres` (`theatre_id`, `theatre_name`, `city`, `address`, `telephone`, `website`, `image`, `status`, `screens`, `avg_ratings`, `total_ratings`, `num_of_ratings`, `user_ip_addresses`) VALUES
(4, 'The Grand Venice', 'Greater Noida', 'Greater Noida, Surajpur Site 4, Gautam Buddha Nagar', 2147483647, 'http://veniceindia.com', 'https://filminformation.com/wp-content/uploads/2020/05/cinemaschembakassery-cinemas-irinjalakuda-thrissur-multiplex-cinema-halls-j8dtanz7ve.jpg', 1, 2, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_theatre_seat_categories`
--

CREATE TABLE `tbl_theatre_seat_categories` (
  `seat_category_id` int(10) NOT NULL,
  `theatre_id` int(10) NOT NULL,
  `category_name` varchar(200) NOT NULL,
  `num_of_rows` varchar(200) NOT NULL,
  `num_of_columns` varchar(200) NOT NULL,
  `num_of_seats` varchar(200) NOT NULL,
  `screen` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_theatre_seat_categories`
--

INSERT INTO `tbl_theatre_seat_categories` (`seat_category_id`, `theatre_id`, `category_name`, `num_of_rows`, `num_of_columns`, `num_of_seats`, `screen`) VALUES
(8, 4, '[\"5\",\"6\",\"7\"]', '[\"1\",\"4\",\"6\"]', '[\"10\",\"8\",\"8\"]', '[10,32,48]', '1'),
(9, 4, '[\"5\",\"6\"]', '[\"1\",\"6\"]', '[\"5\",\"7\"]', '[5,42]', '2');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `mobile` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `username`, `password`, `first_name`, `last_name`, `email`, `mobile`) VALUES
(3, 'user1', '1e1e6545e9124fe0a1a4c5e745c01713', 'Divakar', 'Singh', 'test@gmail.com', '9999999999');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admins`
--
ALTER TABLE `tbl_admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `tbl_booking_temp`
--
ALTER TABLE `tbl_booking_temp`
  ADD PRIMARY KEY (`temp_ticket_id`);

--
-- Indexes for table `tbl_carousel`
--
ALTER TABLE `tbl_carousel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_common_seat_categories`
--
ALTER TABLE `tbl_common_seat_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_contact_us`
--
ALTER TABLE `tbl_contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_movies`
--
ALTER TABLE `tbl_movies`
  ADD PRIMARY KEY (`movie_id`),
  ADD UNIQUE KEY `movie_name` (`movie_name`);

--
-- Indexes for table `tbl_seat_maps`
--
ALTER TABLE `tbl_seat_maps`
  ADD PRIMARY KEY (`seat_id`);

--
-- Indexes for table `tbl_shows`
--
ALTER TABLE `tbl_shows`
  ADD PRIMARY KEY (`show_id`);

--
-- Indexes for table `tbl_showtimes`
--
ALTER TABLE `tbl_showtimes`
  ADD PRIMARY KEY (`showtime_id`);

--
-- Indexes for table `tbl_show_ticket_rates`
--
ALTER TABLE `tbl_show_ticket_rates`
  ADD PRIMARY KEY (`ticket_rate_id`);

--
-- Indexes for table `tbl_theatres`
--
ALTER TABLE `tbl_theatres`
  ADD PRIMARY KEY (`theatre_id`),
  ADD UNIQUE KEY `theatre_name` (`theatre_name`);

--
-- Indexes for table `tbl_theatre_seat_categories`
--
ALTER TABLE `tbl_theatre_seat_categories`
  ADD PRIMARY KEY (`seat_category_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admins`
--
ALTER TABLE `tbl_admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_booking`
--
ALTER TABLE `tbl_booking`
  MODIFY `ticket_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_booking_temp`
--
ALTER TABLE `tbl_booking_temp`
  MODIFY `temp_ticket_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_carousel`
--
ALTER TABLE `tbl_carousel`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_common_seat_categories`
--
ALTER TABLE `tbl_common_seat_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_contact_us`
--
ALTER TABLE `tbl_contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_movies`
--
ALTER TABLE `tbl_movies`
  MODIFY `movie_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_seat_maps`
--
ALTER TABLE `tbl_seat_maps`
  MODIFY `seat_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_shows`
--
ALTER TABLE `tbl_shows`
  MODIFY `show_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_showtimes`
--
ALTER TABLE `tbl_showtimes`
  MODIFY `showtime_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_show_ticket_rates`
--
ALTER TABLE `tbl_show_ticket_rates`
  MODIFY `ticket_rate_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_theatres`
--
ALTER TABLE `tbl_theatres`
  MODIFY `theatre_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_theatre_seat_categories`
--
ALTER TABLE `tbl_theatre_seat_categories`
  MODIFY `seat_category_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
