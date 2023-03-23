SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

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
-- Table structure for table `tbl_carousel`
--

CREATE TABLE `tbl_carousel` (
  `id` int(10) NOT NULL,
  `movie_id` varchar(11) NOT NULL,
  `carousel_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `tbl_common_seat_categories`
--

CREATE TABLE `tbl_common_seat_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `tbl_seat_maps`
--

CREATE TABLE `tbl_seat_maps` (
  `seat_id` int(200) NOT NULL,
  `seat_category_id` int(11) NOT NULL,
  `seat_number` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Table structure for table `tbl_showtimes`
--

CREATE TABLE `tbl_showtimes` (
  `showtime_id` int(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `starting_time` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
