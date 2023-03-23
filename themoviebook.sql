-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2023 at 12:16 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 5.6.39

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admins`
--

INSERT INTO `tbl_admins` (`admin_id`, `username`, `password`, `first_name`, `last_name`, `email`, `mobile`, `verification_code`) VALUES
(6, 'admin', 'bb458a8b43c56677c5d1f338ab0021cb', 'Divakar', 'Singh', 'ds299555@gmail.com', '8279356365', 1234);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_booking_temp`
--

INSERT INTO `tbl_booking_temp` (`temp_ticket_id`, `timestamp`, `user_id`, `movie_id`, `theatre_id`, `show_id`, `seat_cat`, `seats`, `screen`, `showdate`, `showtime`, `amount`, `payment_status`) VALUES
(7, '2022-12-31 20:29:13', '1', '2', '2', '4', 'Recliner', 'A1', '1', '2023-01-02', '09:00 AM', '349.5', 0),
(8, '2022-12-31 20:29:40', '1', '2', '2', '4', 'Recliner', 'A2', '1', '2023-01-02', '09:00 AM', '349.5', 0),
(9, '2023-01-03 15:09:23', '1', '2', '1', '1', 'Recliner', 'A3', '1', '2023-01-03', '05:00 PM', '329.5', 0),
(10, '2023-01-24 22:41:58', '1', '2', '1', '1', 'Diamond', 'C2', '1', '2023-01-26', '11:00 AM', '279.5', 0),
(11, '2023-01-24 22:56:44', '1', '3', '1', '2', 'Gold', 'E4', '2', '2023-01-26', '09:00 AM', '209.5', 0),
(12, '2023-01-24 23:01:09', '1', '3', '1', '2', 'Gold', 'G5', '2', '2023-01-25', '09:00 AM', '209.5', 0),
(13, '2023-01-24 23:25:15', '1', '3', '1', '2', 'Diamond', 'D5', '2', '2023-01-26', '09:00 AM', '229.5', 0),
(14, '2023-01-24 23:27:11', '1', '3', '1', '2', 'Gold', 'G6', '2', '2023-01-26', '09:00 AM', '209.5', 0),
(15, '2023-01-24 23:27:22', '1', '3', '1', '2', 'Gold', 'E4', '2', '2023-01-28', '12:00 PM', '209.5', 0),
(16, '2023-01-24 23:27:35', '1', '2', '1', '1', 'Diamond', 'C2,C3', '1', '2023-01-27', '05:00 PM', '559', 0),
(17, '2023-01-25 09:39:28', '1', '3', '3', '6', 'Diamond', 'C3', '1', '2023-01-28', '05:00 PM', '279.5', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_carousel`
--

CREATE TABLE `tbl_carousel` (
  `id` int(10) NOT NULL,
  `movie_id` varchar(11) NOT NULL,
  `carousel_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_carousel`
--

INSERT INTO `tbl_carousel` (`id`, `movie_id`, `carousel_image`) VALUES
(1, '2', 'https://image.tmdb.org/t/p/original/94xxm5701CzOdJdUEdIuwqZaowx.jpg'),
(2, '3', 'https://image.tmdb.org/t/p/original/yJNNwHQuKYNeHFbsxSFR6yK9Dda.jpg'),
(3, '4', 'https://image.tmdb.org/t/p/original/8ETdXcKad8kRRiCupDTjXrYzUv5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_common_seat_categories`
--

CREATE TABLE `tbl_common_seat_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_common_seat_categories`
--

INSERT INTO `tbl_common_seat_categories` (`category_id`, `category_name`) VALUES
(1, 'Recliner'),
(2, 'Diamond'),
(3, 'Gold'),
(4, 'Silver');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_movies`
--

INSERT INTO `tbl_movies` (`movie_id`, `movie_name`, `year`, `category`, `running_time`, `release_date`, `language`, `director`, `synopsis`, `casts`, `poster`, `banner`, `wallpaper`, `trailer_url`, `status`, `starting_date`, `ending_date`, `avg_ratings`, `total_ratings`, `num_of_ratings`, `user_ip_addresses`) VALUES
(2, 'Avatar: The Way of Water', 2022, 'Adventure, Action, Science Fiction', '192 Minutes', '2022-12-14', 'English', 'James Cameron', 'Set more than a decade after the events of the first film, learn the story of the Sully family (Jake, Neytiri, and their kids), the trouble that follows them, the lengths they go to keep each other safe, the battles they fight to stay alive, and the tragedies they endure.', 'Sam Worthington, Zoe SaldaÃ±a, Sigourney Weaver, Stephen Lang', 'https://image.tmdb.org/t/p/w185_and_h278_bestv2/94xxm5701CzOdJdUEdIuwqZaowx.jpg', 'https://image.tmdb.org/t/p/original/94xxm5701CzOdJdUEdIuwqZaowx.jpg', '', 'https://www.youtube.com/watch?v=a8Gx8wiNbs8', 1, '2022-12-17', '2023-02-28', 0, 0, 0, ''),
(3, 'Drishyam 2', 2022, 'Mystery, Drama, Thriller, Crime', '142 Minutes', '2022-11-18', 'Hindi', 'Abhishek Pathak', '7 years after the case related to Vijay Salgaonkar and his family was closed, a series of unexpected events bring truth to light that threatens to change everything for the Salgaonkars. Can Vijay save his family this time?', 'Ajay Devgn, Akshaye Khanna, Tabu, Shriya Saran', 'https://image.tmdb.org/t/p/w185_and_h278_bestv2/yJNNwHQuKYNeHFbsxSFR6yK9Dda.jpg', 'https://image.tmdb.org/t/p/original/yJNNwHQuKYNeHFbsxSFR6yK9Dda.jpg', '', 'https://www.youtube.com/watch?v=cxA2y9Tgl7o', 1, '2022-12-17', '2023-02-28', 0, 0, 0, ''),
(4, 'Bhediya', 2022, 'Horror, Comedy', '156 Minutes', '2022-11-25', 'Hindi', 'Amar Kaushik', 'Inspired by legendary folklore rooted in Arunachal Pradesh, Bhediya tells the story of Bhaskar, a man who gets bitten by a mythical wolf and begins to transform into the creature himself. As Bhaskar and his ragtag buddies try to find answers, he is worried that the monster in him will wipe out human existence in the local town.', 'Varun Dhawan, Kriti Sanon, Deepak Dobriyal, Abhishek Banerjee', 'https://image.tmdb.org/t/p/w185_and_h278_bestv2/8ETdXcKad8kRRiCupDTjXrYzUv5.jpg', 'https://image.tmdb.org/t/p/original/8ETdXcKad8kRRiCupDTjXrYzUv5.jpg', '', '', 1, '2022-12-17', '2023-02-28', 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seat_maps`
--

CREATE TABLE `tbl_seat_maps` (
  `seat_id` int(200) NOT NULL,
  `seat_category_id` int(11) NOT NULL,
  `seat_number` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_seat_maps`
--

INSERT INTO `tbl_seat_maps` (`seat_id`, `seat_category_id`, `seat_number`) VALUES
(2, 2, '[[\"A1,A2,A3,A4,A5,A6,A7\",\"B1,B2,B3,B4,B5,B6,B7\",\"C1,C2,C3,C4,C5,C6,C7\"],[\"D1,D2,D3,D4,D5,D6,D7,D8,D9\",\"E1,E2,E3,E4,E5,E6,E7,E8,E9\",\"F1,F2,F3,F4,F5,F6,F7,F8,F9\",\"G1,G2,G3,G4,G5,G6,G7,G8,G9\",\"H1,H2,H3,H4,H5,H6,H7,H8,H9\"],[\"I1,I2,I3,I4,I5,I6,I7,I8,I9,I10,I11,I12,I13\",\"J1,J2,J3,J4,J5,J6,J7,J8,J9,J10,J11,J12,J13\",\"K1,K2,K3,K4,K5,K6,K7,K8,K9,K10,K11,K12,K13\",\"L1,L2,L3,L4,L5,L6,L7,L8,L9,L10,L11,L12,L13\",\"M1,M2,M3,M4,M5,M6,M7,M8,M9,M10,M11,M12,M13\",\"N1,N2,N3,N4,N5,N6,N7,N8,N9,N10,N11,N12,N13\",\"O1,O2,O3,O4,O5,O6,O7,O8,O9,O10,O11,O12,O13\"]]'),
(3, 3, '[[\"A1,A2,A3,A4,A5,A6,A7,A8,A9,A10\",\"B1,B2,B3,B4,B5,B6,B7,B8,B9,B10\",\"C1,C2,C3,C4,C5,C6,C7,C8,C9,C10\",\"D1,D2,D3,D4,D5,D6,D7,D8,D9,D10\"],[\"E1,E2,E3,E4,E5,E6,E7,E8,E9,E10,E11,E12\",\"F1,F2,F3,F4,F5,F6,F7,F8,F9,F10,F11,F12\",\"G1,G2,G3,G4,G5,G6,G7,G8,G9,G10,G11,G12\",\"H1,H2,H3,H4,H5,H6,H7,H8,H9,H10,H11,H12\",\"I1,I2,I3,I4,I5,I6,I7,I8,I9,I10,I11,I12\",\"J1,J2,J3,J4,J5,J6,J7,J8,J9,J10,J11,J12\"],[\"K1,K2,K3,K4,K5,K6,K7,K8,K9,K10,K11,K12,K13,K14,K15\",\"L1,L2,L3,L4,L5,L6,L7,L8,L9,L10,L11,L12,L13,L14,L15\",\"M1,M2,M3,M4,M5,M6,M7,M8,M9,M10,M11,M12,M13,M14,M15\",\"N1,N2,N3,N4,N5,N6,N7,N8,N9,N10,N11,N12,N13,N14,N15\",\"O1,O2,O3,O4,O5,O6,O7,O8,O9,O10,O11,O12,O13,O14,O15\",\"P1,P2,P3,P4,P5,P6,P7,P8,P9,P10,P11,P12,P13,P14,P15\",\"Q1,Q2,Q3,Q4,Q5,Q6,Q7,Q8,Q9,Q10,Q11,Q12,Q13,Q14,Q15\",\"R1,R2,R3,R4,R5,R6,R7,R8,R9,R10,R11,R12,R13,R14,R15\"]]'),
(4, 4, '[[\"A1,A2,A3,A4,A5,A6,A7,A8\"],[\"B1,B2,B3,B4,B5,B6,B7,B8,B9,B10\",\"C1,C2,C3,C4,C5,C6,C7,C8,C9,C10\",\"D1,D2,D3,D4,D5,D6,D7,D8,D9,D10\",\"E1,E2,E3,E4,E5,E6,E7,E8,E9,E10\"],[\"F1,F2,F3,F4,F5,F6,F7,F8,F9,F10\",\"G1,G2,G3,G4,G5,G6,G7,G8,G9,G10\",\"H1,H2,H3,H4,H5,H6,H7,H8,H9,H10\",\"I1,I2,I3,I4,I5,I6,I7,I8,I9,I10\",\"J1,J2,J3,J4,J5,J6,J7,J8,J9,J10\",\"K1,K2,K3,K4,K5,K6,K7,K8,K9,K10\"]]'),
(5, 5, '[[\"A1,A2,A3,A4,A5,A6\",\"B1,B2,B3,B4,B5,B6\"],[\"C1,C2,C3,C4,C5,C6,C7,C8\",\"D1,D2,D3,D4,D5,D6,D7,D8\",\"E1,E2,E3,E4,E5,E6,E7,E8\",\"F1,F2,F3,F4,F5,F6,F7,F8\"],[\"G1,G2,G3,G4,G5,G6,G7,G8,G9,G10\",\"H1,H2,H3,H4,H5,H6,H7,H8,H9,H10\",\"I1,I2,I3,I4,I5,I6,I7,I8,I9,I10\",\"J1,J2,J3,J4,J5,J6,J7,J8,J9,J10\"]]'),
(6, 6, '[[\"A1,A2,A3,A4,A5\",\"B1,B2,B3,B4,B5\",\"C1,C2,C3,C4,C5\",\"D1,D2,D3,D4,D5\"],[\"E1,E2,E3,E4,E5\",\"F1,F2,F3,F4,F5\",\"G1,G2,G3,G4,G5\",\"H1,H2,H3,H4,H5\"]]'),
(7, 7, '[[\"A1,A2\",\"B1,B2\"],[\"C1,C2,C3,C4\",\"D1,D2,D3,D4\",\"E1,E2,E3,E4\"]]');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_shows`
--

INSERT INTO `tbl_shows` (`show_id`, `theatre_id`, `movie_id`, `starting_date`, `ending_date`, `screen`) VALUES
(1, 1, 2, '2022-12-24', '2023-01-31', '1'),
(2, 1, 3, '2022-12-24', '2023-01-31', '2'),
(3, 1, 4, '2022-12-24', '2023-01-31', '3'),
(4, 2, 2, '2022-12-24', '2023-01-31', '1'),
(5, 2, 3, '2022-12-24', '2023-01-31', '2'),
(6, 3, 3, '2023-01-26', '2023-02-16', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_showtimes`
--

CREATE TABLE `tbl_showtimes` (
  `showtime_id` int(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `starting_time` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_showtimes`
--

INSERT INTO `tbl_showtimes` (`showtime_id`, `show_id`, `starting_time`) VALUES
(4, 4, '[\"09:00\",\"15:00\",\"18:00\"]'),
(6, 5, '[\"10:00\",\"12:00\",\"19:00\"]'),
(7, 2, '[\"09:00\",\"12:00\",\"15:00\"]'),
(8, 3, '[\"17:00\",\"21:00\"]'),
(9, 1, '[\"11:00\",\"17:00\"]'),
(10, 6, '[\"10:00\",\"17:00\"]');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_show_ticket_rates`
--

INSERT INTO `tbl_show_ticket_rates` (`ticket_rate_id`, `show_id`, `ticket_category_id`, `category`, `ticket_rate`) VALUES
(5, 1, 2, '[\"1\",\"2\",\"3\"]', '[\"300\",\"250\",\"200\"]'),
(6, 4, 3, '[\"1\",\"2\",\"4\"]', '[\"320\",\"280\",\"250\"]'),
(7, 5, 5, '[\"1\",\"2\",\"4\"]', '[\"280\",\"240\",\"200\"]'),
(8, 2, 4, '[\"1\",\"2\",\"3\"]', '[\"250\",\"200\",\"180\"]'),
(9, 3, 6, '[\"1\",\"2\"]', '[\"200\",\"150\"]'),
(10, 6, 7, '[\"1\",\"2\"]', '[\"300\",\"250\"]');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_theatres`
--

INSERT INTO `tbl_theatres` (`theatre_id`, `theatre_name`, `city`, `address`, `telephone`, `website`, `image`, `status`, `screens`, `avg_ratings`, `total_ratings`, `num_of_ratings`, `user_ip_addresses`) VALUES
(1, 'Wave City Center Noida', 'Noida', 'Noida, Sector 32, Gautam Buddha Nagar', 0, '', 'https://filminformation.com/wp-content/uploads/2020/05/cinemaschembakassery-cinemas-irinjalakuda-thrissur-multiplex-cinema-halls-j8dtanz7ve.jpg', 1, 3, 0, 0, 0, ''),
(2, 'Cinepolis-Grand Venice Mall', 'Greater Noida', 'Greater Noida, Surajpur Site 4, Gautam Buddha Nagar', 2147483647, 'http://www.veniceindia.com', 'https://filminformation.com/wp-content/uploads/2020/05/cinemaschembakassery-cinemas-irinjalakuda-thrissur-multiplex-cinema-halls-j8dtanz7ve.jpg', 1, 4, 0, 0, 0, ''),
(3, 'Padma Cine Square', 'Kaithal', 'Kaithal, Rishi Nagar, Kaithal', 2147483647, 'http://www.cinesquare.in', 'https://filminformation.com/wp-content/uploads/2020/05/cinemaschembakassery-cinemas-irinjalakuda-thrissur-multiplex-cinema-halls-j8dtanz7ve.jpg', 1, 2, 0, 0, 0, '');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_theatre_seat_categories`
--

INSERT INTO `tbl_theatre_seat_categories` (`seat_category_id`, `theatre_id`, `category_name`, `num_of_rows`, `num_of_columns`, `num_of_seats`, `screen`) VALUES
(2, 1, '[\"1\",\"2\",\"3\"]', '[\"2\",\"2\",\"2\"]', '[\"5\",\"7\",\"9\"]', '[10,14,18]', '1'),
(3, 2, '[\"1\",\"2\",\"4\"]', '[\"2\",\"3\",\"3\"]', '[\"3\",\"5\",\"9\"]', '[6,15,27]', '1'),
(4, 1, '[\"1\",\"2\",\"3\"]', '[\"1\",\"3\",\"3\"]', '[\"8\",\"10\",\"10\"]', '[8,30,30]', '2'),
(5, 2, '[\"1\",\"2\",\"4\"]', '[\"2\",\"3\",\"3\"]', '[\"6\",\"8\",\"10\"]', '[12,18,30]', '2'),
(6, 1, '[\"1\",\"2\"]', '[\"4\",\"4\"]', '[\"5\",\"5\"]', '[20,20]', '3'),
(7, 3, '[\"1\",\"2\"]', '[\"2\",\"3\"]', '[\"2\",\"4\"]', '[4,12]', '1');

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
  `mobile` varchar(200) NOT NULL,
  `status` enum('inactive','active') NOT NULL,
  `code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `username`, `password`, `first_name`, `last_name`, `email`, `mobile`, `status`, `code`) VALUES
(1, 'testuser1', '448ddd517d3abb70045aea6929f02367', 'Anchal', 'Agent', 'ds299555@gmail.com', '8279356365', 'active', '77618');

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
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_booking_temp`
--
ALTER TABLE `tbl_booking_temp`
  MODIFY `temp_ticket_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_carousel`
--
ALTER TABLE `tbl_carousel`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_common_seat_categories`
--
ALTER TABLE `tbl_common_seat_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_contact_us`
--
ALTER TABLE `tbl_contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_movies`
--
ALTER TABLE `tbl_movies`
  MODIFY `movie_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_seat_maps`
--
ALTER TABLE `tbl_seat_maps`
  MODIFY `seat_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_shows`
--
ALTER TABLE `tbl_shows`
  MODIFY `show_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_showtimes`
--
ALTER TABLE `tbl_showtimes`
  MODIFY `showtime_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_show_ticket_rates`
--
ALTER TABLE `tbl_show_ticket_rates`
  MODIFY `ticket_rate_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_theatres`
--
ALTER TABLE `tbl_theatres`
  MODIFY `theatre_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_theatre_seat_categories`
--
ALTER TABLE `tbl_theatre_seat_categories`
  MODIFY `seat_category_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
