-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2024 at 11:38 AM
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
-- Database: `movie_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `show_id` int(11) NOT NULL,
  `seat_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`seat_ids`)),
  `total_price` decimal(8,2) DEFAULT NULL,
  `status` enum('Pending','Confirmed','Cancelled') DEFAULT 'Pending',
  `payment_method` enum('Credit Card','PayPal','Debit Card','Cash') NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `show_id`, `seat_ids`, `total_price`, `status`, `payment_method`, `booking_date`) VALUES
(47, 1, 37, '[{\"seat\":\"1G\",\"type\":\"VIP\"},{\"seat\":\"1H\",\"type\":\"VIP\"},{\"seat\":\"1I\",\"type\":\"VIP\"}]', 36.00, 'Pending', '', '2024-11-30 10:08:23'),
(48, 1, 39, '[{\"seat\":\"2G\",\"type\":\"VIP\"},{\"seat\":\"2H\",\"type\":\"VIP\"},{\"seat\":\"2I\",\"type\":\"VIP\"}]', 30.00, 'Pending', '', '2024-11-30 10:09:58');

-- --------------------------------------------------------

--
-- Table structure for table `cinemas`
--

CREATE TABLE `cinemas` (
  `cinema_id` int(11) NOT NULL,
  `cinema_name` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `cinema_type` enum('Standard','IMAX','3D','') NOT NULL DEFAULT 'Standard'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cinemas`
--

INSERT INTO `cinemas` (`cinema_id`, `cinema_name`, `address`, `city`, `state`, `postal_code`, `contact_number`, `cinema_type`) VALUES
(1, 'Larkana Cineplex', 'Shaheed Benazir Bhutto Road', 'Larkana', 'Sindh', '77150', '074-1234567', 'Standard'),
(2, 'Star Cinema', 'Gulshan-e-Iqbal Block 5', 'Karachi', 'Sindh', '75300', '021-8765432', '3D'),
(3, 'Ocean Mall Cinema', 'Ocean Mall, Clifton', 'Karachi', 'Sindh', '75600', '021-3344556', 'IMAX'),
(4, 'Atrium Cinemas', 'Atrium Mall, Saddar', 'Karachi', 'Sindh', '74400', '021-1122334', '3D'),
(5, 'The Arena Islamabad', 'Beverly Center, Blue Area', 'Islamabad', 'Islamabad Capital Territory', '44000', '051-7788991', 'IMAX'),
(6, 'Cinepax Rawalpindi', 'Jinnah Park, Saddar', 'Rawalpindi', 'Punjab', '46000', '051-6677889', '3D'),
(7, 'Universal Cinema', 'Emporium Mall, Johar Town', 'Lahore', 'Punjab', '54000', '042-9988776', 'IMAX'),
(8, 'Cinegold Plex', 'Bahria Town Phase 7', 'Rawalpindi', 'Punjab', '46220', '051-3344112', 'Standard'),
(9, 'Cinestar Multan', 'Gulgasht Colony', 'Multan', 'Punjab', '60000', '061-5566778', '3D'),
(10, 'Cinepax Faisalabad', 'D Ground, People\'s Colony', 'Faisalabad', 'Punjab', '38000', '041-1122556', 'Standard'),
(11, 'Cinepax Gujranwala', 'King’s Mall, GT Road', 'Gujranwala', 'Punjab', '52250', '055-4433221', '3D'),
(12, 'Super Cinema', 'Fortress Stadium', 'Lahore', 'Punjab', '54810', '042-6677884', 'Standard'),
(13, 'Mega Multiplex Cinema', 'Millennium Mall', 'Karachi', 'Sindh', '75400', '021-9988771', 'Standard'),
(14, 'PAF Cinema', 'Cantt', 'Lahore', 'Punjab', '54010', '042-5566779', 'Standard'),
(15, 'Cinepax Hyderabad', 'Boulevard Mall', 'Hyderabad', 'Sindh', '71000', '022-6677882', '3D'),
(16, 'Lux Cinema', 'University Road', 'Peshawar', 'KPK', '25000', '091-4433225', 'Standard'),
(17, 'Cinepax Quetta', 'Millennium Mall', 'Quetta', 'Balochistan', '87300', '081-4455663', '3D'),
(18, 'Central Cinema', 'Clock Tower Road', 'Sialkot', 'Punjab', '51310', '052-3344559', 'Standard'),
(19, 'Gujrat Cineplex', 'Main GT Road', 'Gujrat', 'Punjab', '50700', '053-6677884', 'Standard'),
(20, 'Metro Cinema', 'Civic Center', 'Bahawalpur', 'Punjab', '63100', '062-9988774', 'Standard'),
(21, 'Sindh Cineplex', 'Shahbaz Commercial', 'Hyderabad', 'Sindh', '71050', '022-4433226', 'Standard'),
(22, 'Galaxy Cinema', 'Civic Center, G8', 'Islamabad', 'Islamabad Capital Territory', '44020', '051-5566779', 'Standard'),
(23, 'Regal Cinema', 'Hall Road', 'Lahore', 'Punjab', '54030', '042-6677883', 'Standard'),
(24, 'Dream Cinema', 'Dreamworld Resort', 'Karachi', 'Sindh', '75850', '021-7788993', 'Standard'),
(25, 'Multan Cineplex', 'Mall Road', 'Multan', 'Punjab', '60010', '061-6677881', 'Standard');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `favorite_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`favorite_id`, `user_id`, `movie_id`, `added_date`) VALUES
(30, 1, 47, '2024-11-30 10:10:06');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `genre_id` int(11) NOT NULL,
  `genre_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genre_id`, `genre_name`) VALUES
(1, 'Action'),
(2, 'Adventure'),
(3, 'Animation'),
(4, 'Biography'),
(5, 'Comedy'),
(6, 'Crime'),
(7, 'Documentary'),
(8, 'Drama'),
(9, 'Family'),
(10, 'Fantasy'),
(11, 'History'),
(12, 'Horror'),
(13, 'Music'),
(14, 'Musical'),
(15, 'Mystery'),
(16, 'Romance'),
(17, 'Sci-Fi'),
(18, 'Sports'),
(19, 'Thriller'),
(20, 'War'),
(21, 'Western');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'Duration in minutes',
  `release_date` date DEFAULT NULL,
  `poster_url` varchar(255) DEFAULT NULL,
  `banner_url` varchar(255) DEFAULT NULL,
  `trailer_url` varchar(255) DEFAULT NULL,
  `popularity_score` int(11) DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `title`, `description`, `duration`, `release_date`, `poster_url`, `banner_url`, `trailer_url`, `popularity_score`, `is_published`) VALUES
(1, 'Inception', 'A skilled thief is given a chance at redemption if he can successfully perform inception.', 148, '2010-07-16', NULL, NULL, NULL, 90, 0),
(2, 'The Dark Knight', 'Batman faces the Joker in a thrilling battle for Gotham.', 152, '2008-07-18', NULL, NULL, NULL, 95, 0),
(3, 'Avatar', 'A paraplegic marine on an alien planet becomes torn between duty and love.', 162, '2009-12-18', NULL, NULL, NULL, 88, 0),
(4, 'Interstellar', 'A group of explorers travel through a wormhole in search of a new home.', 169, '2014-11-07', NULL, NULL, NULL, 92, 0),
(5, 'Avengers: Endgame', 'The Avengers assemble to reverse the catastrophic events of the Infinity War.', 181, '2019-04-26', NULL, NULL, NULL, 98, 0),
(6, 'Titanic', 'A love story aboard the ill-fated Titanic ship.', 195, '1997-12-19', NULL, NULL, NULL, 93, 0),
(7, 'Jurassic Park', 'A theme park suffers a major power breakdown, unleashing dinosaurs on visitors.', 127, '1993-06-11', NULL, NULL, NULL, 87, 0),
(8, 'The Matrix', 'A hacker discovers the shocking truth about his reality.', 136, '1999-03-31', NULL, NULL, NULL, 89, 0),
(9, 'Gladiator', 'A betrayed Roman general seeks vengeance.', 155, '2000-05-05', NULL, NULL, NULL, 85, 0),
(10, 'Forrest Gump', 'The extraordinary life story of Forrest Gump.', 142, '1994-07-06', NULL, NULL, NULL, 91, 0),
(11, 'Fight Club', 'An insomniac office worker forms an underground fight club.', 139, '1999-10-15', NULL, NULL, NULL, 88, 0),
(12, 'The Godfather', 'The powerful story of a crime family in America.', 175, '1972-03-24', NULL, NULL, NULL, 97, 0),
(13, 'Pulp Fiction', 'Intersecting stories of crime and redemption in Los Angeles.', 154, '1994-10-14', NULL, NULL, NULL, 85, 0),
(14, 'Star Wars', 'A young farm boy becomes the hero of the galaxy.', 121, '1977-05-25', NULL, NULL, NULL, 94, 0),
(15, 'The Lion King', 'A lion cub flees after his father’s death, only to reclaim his kingdom.', 88, '1994-06-24', NULL, NULL, NULL, 89, 0),
(16, '3 Idiots', 'The story of three friends who question the education system.', 170, '2009-12-25', NULL, NULL, NULL, 92, 0),
(17, 'Dangal', 'A father trains his daughters to become wrestling champions.', 161, '2016-12-23', NULL, NULL, NULL, 93, 0),
(18, 'Sholay', 'Two criminals are hired to protect a village from bandits.', 204, '1975-08-15', NULL, NULL, NULL, 94, 0),
(19, 'Dilwale Dulhania Le Jayenge', 'A love story that redefined romance in Bollywood.', 190, '1995-10-20', NULL, NULL, NULL, 91, 0),
(20, 'PK', 'An alien questions societal norms and religions.', 153, '2014-12-19', '/uploads/images/674aea99a96f2.jpg', '/uploads/images/674aea99a9a1a.jpg', '/uploads/videos/674aea6b0e028.mp4', 88, 1),
(21, 'Kabhi Khushi Kabhie Gham', 'A family drama about love and relationships.', 210, '2001-12-14', NULL, NULL, NULL, 85, 0),
(22, 'Bajrangi Bhaijaan', 'A man helps a lost girl return to her home in Pakistan.', 163, '2015-07-17', NULL, NULL, NULL, 87, 0),
(23, 'Padmaavat', 'A period drama about honor and sacrifice.', 164, '2018-01-25', NULL, NULL, NULL, 83, 0),
(24, 'Gully Boy', 'The inspiring journey of a street rapper.', 154, '2019-02-14', NULL, NULL, NULL, 86, 0),
(25, 'Andhadhun', 'A blind pianist gets embroiled in a murder mystery.', 139, '2018-10-05', NULL, NULL, NULL, 84, 0),
(26, 'Zindagi Na Milegi Dobara', 'A bachelor road trip that changes lives.', 153, '2011-07-15', NULL, NULL, NULL, 89, 0),
(27, 'Lagaan', 'Villagers play cricket against British oppressors.', 224, '2001-06-15', NULL, NULL, NULL, 90, 0),
(28, 'Bahubali: The Beginning', 'A kingdom’s prince rises to power.', 159, '2015-07-10', NULL, NULL, NULL, 88, 0),
(29, 'Bahubali: The Conclusion', 'The prince avenges his family’s betrayal.', 171, '2017-04-28', NULL, NULL, NULL, 95, 0),
(30, 'Drishyam', 'A man uses his wits to protect his family from the law.', 163, '2015-07-31', NULL, NULL, NULL, 84, 0),
(31, 'Pushpa: The Rise', 'A laborer rises through the ranks of the smuggling syndicate.', 179, '2021-12-17', '/uploads/images/674ae95e840e9.jpg', '/uploads/images/674ae95e84411.jpg', '/uploads/videos/674ae9bb1884c.mp4', 88, 1),
(32, 'RRR', 'Two revolutionaries fight against British rule.', 187, '2022-03-25', NULL, NULL, NULL, 92, 0),
(33, 'Arjun Reddy', 'A hot-headed surgeon copes with heartbreak.', 182, '2017-08-25', NULL, NULL, NULL, 84, 0),
(34, 'Eega', 'A man reincarnates as a housefly to avenge his death.', 134, '2012-07-06', NULL, NULL, NULL, 85, 0),
(35, 'Magadheera', 'A warrior reincarnates to fulfill his destiny.', 166, '2009-07-31', NULL, NULL, NULL, 90, 0),
(36, 'Baahubali: The Beginning', 'A warrior prince battles for his throne.', 159, '2015-07-10', NULL, NULL, NULL, 94, 0),
(37, 'Baahubali: The Conclusion', 'A prince fulfills his destiny and seeks revenge.', 171, '2017-04-28', NULL, NULL, NULL, 96, 0),
(38, 'Athadu', 'A professional assassin gets entangled in a family’s affairs.', 172, '2005-08-10', NULL, NULL, NULL, 83, 0),
(39, 'Geetha Govindam', 'A love story of opposites attracting.', 142, '2018-08-15', NULL, NULL, NULL, 85, 0),
(40, 'Ala Vaikunthapurramuloo', 'A man discovers his true lineage.', 165, '2020-01-12', NULL, NULL, NULL, 86, 0),
(41, 'Mahanati', 'The biopic of legendary actress Savitri.', 177, '2018-05-09', NULL, NULL, NULL, 87, 0),
(42, 'Jersey', 'A retired cricketer pursues his dream.', 157, '2019-04-19', NULL, NULL, NULL, 84, 0),
(43, 'Sye', 'A rugby competition unites college students.', 174, '2004-09-23', NULL, NULL, NULL, 82, 0),
(44, 'Rangasthalam', 'A man fights to save his village from corruption.', 179, '2018-03-30', NULL, NULL, NULL, 89, 0),
(45, 'Khaidi', 'An ex-convict fights to protect his daughter.', 147, '2019-10-25', NULL, NULL, NULL, 85, 0),
(46, 'Dunki', 'When his friends in Punjab struggle to clear the immigration process, an ex-soldier guides them on a risky journey to enter the UK without permission.', 161, '2023-12-21', '/uploads/images/Dunki (2024) (wariskhan) (ORG) 1080p/folder.jpg', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRDX0Z5KZi2mXjz55UpeYokIAaiVTI2ZFQ7Fg&s', '/uploads/videos/dunki.mp4', 4, 1),
(47, 'Agent', 'A spy with a mysterious past goes on a mission to uncover the truth about a dangerous terrorist organization.', 120, '2023-04-28', '/uploads/images/Agent (2024) (wariskhan) (ORG) 1080p/Agent.jpg', '/uploads/images/Agent (2024) (wariskhan) (ORG) 1080p/agent-trailler.jpg', '/uploads/videos/agent.mp4', 3, 1),
(48, 'John Wick Chapter 4', 'With the price on his head ever increasing, legendary hit man John Wick takes his fight against the High Table global as he seeks out the most powerful players in the underworld, from New York to Paris to Japan to Berlin.', 169, '2023-03-24', '\\uploads\\images\\John Wick Chapter 4 (2023) 1080p (wariskhan) Hindi Original BluRay\\John Wick Chapter 4.jpg', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShtyOnT3qokfIU6LoDdQoHROhE32NjKCd6ag&s', '/uploads/videos/johnwick_ch-4.mp4', 8, 1),
(49, 'Lift', 'A master thief is wooed by his ex-girlfriend and the FBI to pull off an impossible heist with his international crew on a 777 passenger flight from London to Zurich.', 107, '2024-01-12', '\\uploads\\images\\Lift (2024) 1080p (wariskhan) Hindi (ORG) Comedy Action\\Lift.jpg', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTLFNYv6G4HeKDeU8Hm5GUgm-cEzfjQd_22VA&s', '/uploads/videos/lift.mp4', 6, 1),
(50, 'Plane', 'Pilot Brodie Torrance saves passengers from a lightning strike by making a risky landing on a war-torn island -- only to find that surviving the landing was just the beginning. When dangerous rebels take most of the passengers hostage, the only person Torrance can count on for help is Louis Gaspare, an accused murderer who was being transported by the FBI.', 107, '2023-01-11', '\\uploads\\images\\Plane (2023) 720p (wariskhan) Hindi (ORG) ActionThriller\\folder.jpg', 'https://static1.colliderimages.com/wordpress/wp-content/uploads/2022/10/Gerard-Butler-and-Mike-Colter-in-Plane.jpg', '/uploads/videos/plane.mp4', 4, 1),
(51, 'Salaar', 'Just when the prince of Khansaar is about to rise to the throne, a plan of overthrowing him is exercised and only one man can help him retrieve power.', 175, '2023-12-22', '\\uploads\\images\\Salaar (2024) 1080p (wariskhan) Hindi (ORG)\\folder.jpg', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSEF-F6I8LwOuSed8Jbk1T6cfUknC_f1F-Xjg&s', '/uploads/videos/salaar.mp4', 3, 1),
(52, 'Pathan', 'A Pakistani general hires a private terror outfit to conduct attacks in India while Pathaan, an Indian secret agent, is on a mission to form a special unit.', 146, '2023-01-25', '\\uploads\\images\\Pathaan (2023) 1080p (wariskhan) Hindi (ORG)\\folder.jpg', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQJQnixC7wG-Y9yuNkf53IjSZbSZQpwq3ySIg&s', '/uploads/videos/pathan.mp4', 6, 1),
(53, 'Adipurush', 'Raghava, the prince of Ayodhya, lives in exile alongside his wife Janaki and brother Shesh. When the king of Lanka kidnaps Janaki, Raghava and his allies set out to rescue her.', 179, '2023-06-16', '/uploads/images/6738ebf17a922.jpg', '/uploads/images/6738ebf17b4f6.jpg', '/uploads/videos/6738ebf17b02a.mp4', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `movie_genres`
--

CREATE TABLE `movie_genres` (
  `movie_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie_genres`
--

INSERT INTO `movie_genres` (`movie_id`, `genre_id`) VALUES
(1, 17),
(1, 20),
(2, 6),
(2, 19),
(3, 10),
(3, 17),
(4, 8),
(4, 17),
(5, 1),
(5, 19),
(6, 8),
(6, 16),
(7, 1),
(7, 10),
(8, 17),
(8, 19),
(9, 11),
(9, 19),
(10, 4),
(10, 8),
(11, 6),
(11, 19),
(12, 4),
(12, 6),
(13, 5),
(13, 6),
(14, 10),
(14, 17),
(15, 3),
(15, 9),
(16, 5),
(16, 8),
(17, 4),
(17, 18),
(18, 1),
(18, 10),
(19, 8),
(19, 16),
(20, 5),
(20, 8),
(21, 8),
(21, 16),
(22, 8),
(22, 16),
(23, 8),
(23, 11),
(24, 8),
(24, 13),
(25, 5),
(25, 19),
(26, 5),
(26, 8),
(27, 1),
(27, 11),
(28, 10),
(28, 19),
(29, 10),
(29, 19),
(30, 8),
(30, 19),
(31, 1),
(31, 19),
(32, 1),
(32, 11),
(33, 8),
(33, 16),
(34, 10),
(34, 19),
(35, 10),
(35, 19),
(36, 10),
(36, 19),
(37, 10),
(37, 19),
(38, 1),
(38, 8),
(39, 9),
(39, 16),
(40, 8),
(40, 16),
(41, 4),
(41, 8),
(42, 8),
(42, 18),
(43, 1),
(43, 18),
(44, 1),
(44, 19),
(45, 1),
(45, 19),
(46, 19),
(46, 20),
(47, 1),
(47, 19),
(48, 1),
(48, 19),
(49, 1),
(49, 5),
(50, 1),
(50, 19),
(51, 1),
(51, 19);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `rating` tinyint(4) DEFAULT NULL COMMENT 'Rating out of 5',
  `review_text` text DEFAULT NULL COMMENT 'User review text',
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `screens`
--

CREATE TABLE `screens` (
  `screen_id` int(11) NOT NULL,
  `cinema_id` int(11) DEFAULT NULL,
  `screen_name` varchar(50) DEFAULT NULL,
  `screen_type` enum('Standard','IMAX','3D') DEFAULT NULL,
  `total_seats` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `screens`
--

INSERT INTO `screens` (`screen_id`, `cinema_id`, `screen_name`, `screen_type`, `total_seats`) VALUES
(1, 1, 'Screen 1', 'Standard', 150),
(2, 1, 'Screen 2', 'IMAX', 200),
(3, 1, 'Screen 3', '3D', 180),
(4, 2, 'Screen 1', '3D', 180),
(5, 2, 'Screen 2', 'IMAX', 220),
(6, 3, 'Screen 1', 'IMAX', 210),
(7, 3, 'Screen 2', 'Standard', 180),
(8, 4, 'Screen 1', '3D', 200),
(9, 4, 'Screen 2', 'IMAX', 220),
(10, 5, 'Screen 1', 'IMAX', 250),
(11, 5, 'Screen 2', '3D', 230),
(12, 6, 'Screen 1', 'Standard', 160),
(13, 6, 'Screen 2', 'IMAX', 210),
(14, 7, 'Screen 1', '3D', 200),
(15, 7, 'Screen 2', 'Standard', 180),
(16, 8, 'Screen 1', 'IMAX', 240),
(17, 8, 'Screen 2', 'Standard', 170),
(18, 9, 'Screen 1', '3D', 200),
(19, 9, 'Screen 2', 'IMAX', 220),
(20, 10, 'Screen 1', 'Standard', 180),
(21, 10, 'Screen 2', '3D', 190),
(22, 11, 'Screen 1', 'Standard', 160),
(23, 11, 'Screen 2', 'IMAX', 210),
(24, 12, 'Screen 1', 'Standard', 170),
(25, 12, 'Screen 2', '3D', 180),
(26, 13, 'Screen 1', 'Standard', 150),
(27, 13, 'Screen 2', 'IMAX', 200),
(28, 14, 'Screen 1', 'Standard', 160),
(29, 14, 'Screen 2', '3D', 170),
(30, 15, 'Screen 1', 'IMAX', 220),
(31, 15, 'Screen 2', '3D', 210),
(32, 16, 'Screen 1', 'Standard', 180),
(33, 16, 'Screen 2', 'IMAX', 210),
(34, 17, 'Screen 1', '3D', 190),
(35, 17, 'Screen 2', 'Standard', 170),
(36, 18, 'Screen 1', 'Standard', 160),
(37, 18, 'Screen 2', 'IMAX', 200),
(38, 19, 'Screen 1', 'Standard', 180),
(39, 19, 'Screen 2', '3D', 190),
(40, 20, 'Screen 1', 'Standard', 170),
(41, 20, 'Screen 2', 'IMAX', 220),
(42, 21, 'Screen 1', '3D', 200),
(43, 21, 'Screen 2', 'Standard', 180),
(44, 22, 'Screen 1', 'IMAX', 250),
(45, 22, 'Screen 2', 'Standard', 200),
(46, 23, 'Screen 1', '3D', 180),
(47, 23, 'Screen 2', 'Standard', 160),
(48, 24, 'Screen 1', 'IMAX', 230),
(49, 24, 'Screen 2', 'Standard', 170),
(50, 25, 'Screen 1', '3D', 190),
(51, 25, 'Screen 2', 'IMAX', 220);

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `seat_id` int(11) NOT NULL,
  `screen_id` int(11) DEFAULT NULL,
  `seat_number` varchar(10) NOT NULL,
  `seat_type` enum('Regular','Premium','VIP') NOT NULL,
  `price` decimal(6,2) DEFAULT NULL COMMENT 'Price per seat',
  `status` enum('Reserved','Available') DEFAULT 'Available',
  `show_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`seat_id`, `screen_id`, `seat_number`, `seat_type`, `price`, `status`, `show_id`) VALUES
(127, 4, '2G', 'VIP', 10.00, 'Reserved', 39),
(128, 4, '2H', 'VIP', 10.00, 'Reserved', 39),
(129, 4, '2I', 'VIP', 10.00, 'Reserved', 39),
(130, 8, '2G', 'VIP', 0.00, 'Reserved', 6),
(131, 8, '2H', 'VIP', 0.00, 'Reserved', 6),
(132, 8, '2I', 'VIP', 0.00, 'Reserved', 6);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` char(64) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_active` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `user_id`, `login_time`, `last_active`) VALUES
('2qle3takk7073ft8s80dvmnu0m', 1, '2024-11-16 10:09:34', '2024-11-16 10:33:25'),
('2tjgg7hp1qtp3lrc8rcpd91bsf', 1, '2024-11-18 08:28:59', '2024-11-18 08:28:59'),
('683b6mrqv1bn7pcomh9tb7vlvd', 1, '2024-11-30 10:01:50', '2024-11-30 10:05:52'),
('7niamg89s5l2g82bhsctuu0s7o', 1, '2024-11-17 08:31:28', '2024-11-17 08:31:28'),
('bjaankcaf30espqentf2tv084e', 1, '2024-11-18 15:47:26', '2024-11-18 15:47:26'),
('ea3m2u5johc1a77rhfh06drcv3', 1, '2024-11-19 08:40:42', '2024-11-19 09:09:14'),
('l606nev3eh34fdc720htvecqmk', 1, '2024-11-20 04:28:20', '2024-11-20 10:37:33'),
('lbsvq4eu66fn85va9ehlh2d91k', 1, '2024-11-16 17:25:46', '2024-11-16 17:25:46'),
('lc5a7v16gbuh0rls39to1qta4t', 51, '2024-11-20 12:28:10', '2024-11-20 12:28:10'),
('mbdhoi99gh889vsies6ld3r0a3', 1, '2024-11-18 20:27:06', '2024-11-19 00:17:56'),
('nneouf74snhht0pqbe0bv2se90', 1, '2024-11-16 11:58:09', '2024-11-16 11:58:09'),
('pnpg0b5jtsru4cc28q2jui6r6l', 49, '2024-11-14 10:22:18', '2024-11-14 10:22:18'),
('rs6iomn14rld0sfgth6encqnru', 1, '2024-11-21 08:58:39', '2024-11-21 08:58:39'),
('s0cgl0a70lmdf6k5bjrbis72io', 1, '2024-11-18 10:41:03', '2024-11-18 11:42:53'),
('vdk2c2b9klddaob08rrm6j1an2', 1, '2024-11-13 10:13:57', '2024-11-13 12:15:19');

--
-- Triggers `sessions`
--
DELIMITER $$
CREATE TRIGGER `update_user_status_active` BEFORE UPDATE ON `sessions` FOR EACH ROW BEGIN
    -- Update the user's status to Active when the session is updated
    UPDATE users 
    SET status = 'Active' 
    WHERE user_id = NEW.user_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_user_status_inactive` AFTER UPDATE ON `sessions` FOR EACH ROW BEGIN
    -- Check if the last active time is more than 2 minutes ago
    IF TIMESTAMPDIFF(SECOND, OLD.last_active, NOW()) > 120 THEN
        -- Update the user status to Inactive if the condition is met
        UPDATE users 
        SET status = 'Inactive' 
        WHERE user_id = OLD.user_id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `shows`
--

CREATE TABLE `shows` (
  `show_id` int(11) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `screen_id` int(11) DEFAULT NULL,
  `show_date` date DEFAULT NULL,
  `show_time` time DEFAULT NULL,
  `show_end` time DEFAULT NULL,
  `price` decimal(8,2) DEFAULT 0.00 COMMENT 'Ticket price in dollars'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shows`
--

INSERT INTO `shows` (`show_id`, `movie_id`, `screen_id`, `show_date`, `show_time`, `show_end`, `price`) VALUES
(4, 18, 8, '2024-11-21', '13:30:00', '15:00:00', 5.00),
(6, 20, 8, '2024-02-22', '19:46:00', '20:51:00', 0.00),
(7, 16, 9, '2024-12-25', '15:30:00', '17:40:00', 8.00),
(8, 21, 6, '2024-11-23', '15:33:00', '16:55:00', 8.00),
(9, 16, 7, '2024-11-20', '22:09:08', '27:09:08', 4.00),
(10, 17, 6, '2024-11-21', '16:00:00', '18:05:00', 10.00),
(11, 20, 10, '2024-12-25', '15:30:00', '17:50:00', 8.00),
(12, 19, 17, '2024-01-12', '14:00:00', '16:07:00', 10.00),
(13, 19, 18, '2024-01-12', '17:00:00', '19:07:00', 12.00),
(14, 19, 19, '2024-01-12', '20:00:00', '22:07:00', 15.00),
(15, 19, NULL, '2024-01-12', '22:30:00', '00:37:00', 17.00),
(16, 19, 20, '2024-01-12', '23:00:00', '01:07:00', 14.00),
(17, 21, 21, '2023-12-22', '14:00:00', '16:55:00', 12.00),
(18, 21, NULL, '2023-12-22', '17:00:00', '19:55:00', 13.00),
(19, 21, 24, '2023-12-22', '20:00:00', '22:55:00', 15.00),
(20, 21, NULL, '2023-12-22', '22:30:00', '01:25:00', 16.00),
(21, 21, 22, '2023-12-22', '23:00:00', '01:55:00', 18.00),
(22, 16, 25, '2023-12-21', '14:00:00', '16:41:00', 11.00),
(23, 16, NULL, '2023-12-21', '17:00:00', '19:41:00', 13.00),
(24, 16, 19, '2023-12-21', '20:00:00', '22:41:00', 14.00),
(25, 16, NULL, '2023-12-21', '22:30:00', '01:11:00', 16.00),
(26, 16, 26, '2023-12-21', '23:00:00', '01:41:00', 17.00),
(27, 29, 28, '2023-06-16', '14:00:00', '16:59:00', 9.00),
(28, 29, NULL, '2023-06-16', '17:00:00', '19:59:00', 10.00),
(29, 29, 29, '2023-06-16', '20:00:00', '22:59:00', 11.00),
(30, 29, NULL, '2023-06-16', '22:30:00', '01:29:00', 12.00),
(31, 29, 31, '2023-06-16', '23:00:00', '01:59:00', 13.00),
(32, 17, 26, '2023-04-28', '14:00:00', '15:59:00', 10.00),
(33, 17, NULL, '2023-04-28', '17:00:00', '18:59:00', 12.00),
(34, 17, 22, '2023-04-28', '20:00:00', '21:59:00', 14.00),
(35, 17, NULL, '2023-04-28', '22:30:00', '00:29:00', 16.00),
(36, 17, 30, '2023-04-28', '23:00:00', '00:59:00', 18.00),
(37, 48, 1, '2024-02-22', '16:30:00', '17:40:00', 6.00),
(38, 47, 1, '2024-03-20', '14:03:00', '16:30:00', 7.00),
(39, 46, 4, '2024-02-20', '16:20:00', '17:30:00', 5.00),
(40, 47, 4, '2024-02-24', '16:00:00', '17:00:00', 8.00),
(41, 49, 43, '2025-02-02', '16:00:00', '17:00:00', 6.00),
(42, 50, 20, '2025-02-20', '15:00:00', '16:00:00', 9.00),
(43, 51, 24, '2024-02-04', '16:44:00', '17:07:00', 3.00),
(44, 52, 7, '2025-02-02', '14:05:00', '16:04:00', 6.00),
(45, 53, 13, '2025-02-04', '14:00:00', '16:00:00', 4.00),
(46, 20, 3, '2025-02-02', '14:05:00', '16:02:00', 5.00),
(47, 31, 1, '2025-02-02', '16:05:00', '17:32:00', 7.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('Active','Inactive','Suspended') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `age`, `is_admin`, `status`, `created_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$qFeCzsZTsYUnZmfLSLG1SOPE4rdt0aid1ySTcxLmlG6ggJ5xJcZAq', NULL, 1, 'Active', '2024-11-30 09:59:17'),
(2, 'JohnDoe', 'johndoe@gmail.com', 'password123', 25, 0, 'Active', '2023-06-15 14:30:00'),
(3, 'JaneSmith', 'janesmith@gmail.com', 'password123', 30, 0, 'Active', '2022-03-20 09:00:00'),
(4, 'AliceWonder', 'alice@gmail.com', 'password123', 27, 0, 'Inactive', '2023-01-10 11:15:00'),
(5, 'BobBuilder', 'bob@gmail.com', 'password123', 35, 0, 'Suspended', '2021-12-25 08:45:00'),
(6, 'CharlieBrown', 'charlie@gmail.com', 'password123', 20, 0, 'Active', '2024-01-01 12:00:00'),
(7, 'DianaPrince', 'diana@gmail.com', 'password123', 29, 0, 'Active', '2023-07-18 19:20:00'),
(8, 'EveAdams', 'eve@gmail.com', 'password123', 24, 0, 'Active', '2022-08-05 15:45:00'),
(9, 'FrankCastle', 'frank@gmail.com', 'password123', 38, 0, 'Suspended', '2023-02-12 10:00:00'),
(10, 'GraceHopper', 'grace@gmail.com', 'password123', 32, 0, 'Inactive', '2023-05-21 17:30:00'),
(11, 'HenryFord', 'henry@gmail.com', 'password123', 40, 0, 'Active', '2022-11-11 10:10:10'),
(12, 'IsaacNewton', 'isaac@gmail.com', 'password123', 22, 0, 'Active', '2024-03-05 18:18:18'),
(13, 'JuliaRoberts', 'julia@gmail.com', 'password123', 29, 0, 'Active', '2021-07-13 09:25:00'),
(14, 'KevinHart', 'kevin@gmail.com', 'password123', 33, 0, 'Active', '2023-11-25 13:00:00'),
(15, 'LindaCarter', 'linda@gmail.com', 'password123', 28, 0, 'Active', '2023-02-01 10:10:00'),
(16, 'MarkTwain', 'mark@gmail.com', 'password123', 45, 0, 'Inactive', '2022-09-15 08:30:00'),
(17, 'NancyDrew', 'nancy@gmail.com', 'password123', 31, 0, 'Active', '2023-03-22 17:15:00'),
(18, 'OliverQueen', 'oliver@gmail.com', 'password123', 29, 0, 'Active', '2024-06-09 19:00:00'),
(19, 'PeterParker', 'peter@gmail.com', 'password123', 23, 0, 'Active', '2023-08-30 14:50:00'),
(20, 'QuincyJones', 'quincy@gmail.com', 'password123', 36, 0, 'Suspended', '2022-04-15 10:20:00'),
(21, 'RachelGreen', 'rachel@gmail.com', 'password123', 26, 0, 'Active', '2023-05-12 16:40:00'),
(22, 'SamWilson', 'sam@gmail.com', 'password123', 29, 0, 'Active', '2023-01-29 13:25:00'),
(23, 'TonyStark', 'tony@gmail.com', 'password123', 40, 0, 'Active', '2022-02-18 09:30:00'),
(24, 'UmaThurman', 'uma@gmail.com', 'password123', 35, 0, 'Inactive', '2023-07-23 15:45:00'),
(25, 'VictorVonDoom', 'victor@gmail.com', 'password123', 41, 0, 'Suspended', '2021-11-05 08:15:00'),
(26, 'WalterWhite', 'walter@gmail.com', 'password123', 50, 0, 'Active', '2023-09-12 17:00:00'),
(27, 'XanderCage', 'xander@gmail.com', 'password123', 30, 0, 'Active', '2023-10-10 10:00:00'),
(28, 'YvonneStrahovski', 'yvonne@gmail.com', 'password123', 33, 0, 'Active', '2023-04-06 14:20:00'),
(29, 'ZacharyLevi', 'zachary@gmail.com', 'password123', 39, 0, 'Active', '2023-06-18 12:30:00'),
(30, 'User30', 'user30@gmail.com', 'password123', 28, 0, 'Active', '2023-03-15 15:30:00'),
(31, 'User31', 'user31@gmail.com', 'password123', 24, 0, 'Active', '2023-05-10 13:15:00'),
(32, 'User32', 'user32@gmail.com', 'password123', 35, 0, 'Active', '2022-01-05 12:00:00'),
(33, 'User33', 'user33@gmail.com', 'password123', 29, 0, 'Active', '2022-06-25 10:30:00'),
(34, 'User34', 'user34@gmail.com', 'password123', 31, 0, 'Inactive', '2023-02-22 11:20:00'),
(35, 'User35', 'user35@gmail.com', 'password123', 27, 0, 'Suspended', '2021-12-31 09:45:00'),
(36, 'User36', 'user36@gmail.com', 'password123', 26, 0, 'Active', '2024-01-15 12:00:00'),
(37, 'User37', 'user37@gmail.com', 'password123', 33, 0, 'Active', '2023-08-18 14:40:00'),
(38, 'User38', 'user38@gmail.com', 'password123', 40, 0, 'Active', '2022-07-05 15:15:00'),
(39, 'User39', 'user39@gmail.com', 'password123', 28, 0, 'Active', '2023-03-01 16:25:00'),
(40, 'User40', 'user40@gmail.com', 'password123', 32, 0, 'Active', '2022-04-10 09:10:00'),
(41, 'User41', 'user41@gmail.com', 'password123', 24, 0, 'Active', '2023-06-12 17:30:00'),
(42, 'User42', 'user42@gmail.com', 'password123', 29, 0, 'Active', '2024-02-08 14:00:00'),
(43, 'User43', 'user43@gmail.com', 'password123', 26, 0, 'Inactive', '2022-03-10 10:45:00'),
(44, 'User44', 'user44@gmail.com', 'password123', 35, 0, 'Suspended', '2023-01-30 08:15:00'),
(45, 'User45', 'user45@gmail.com', 'password123', 31, 0, 'Active', '2023-09-20 18:30:00'),
(46, 'User46', 'user46@gmail.com', 'password123', 27, 0, 'Active', '2023-10-25 10:20:00'),
(47, 'User47', 'user47@gmail.com', 'password123', 34, 0, 'Active', '2023-05-05 13:50:00'),
(48, 'User48', 'user48@gmail.com', 'password123', 30, 0, 'Inactive', '2022-08-15 11:10:00'),
(49, 'User49', 'user49@gmail.com', 'password123', 27, 0, 'Active', '2024-11-30 09:59:17'),
(50, 'faisal', 'deletepleasename@gmail.com', '$2y$10$TB96IxVYeRSXvZRrE4cHQub9J0okmbiv4jgc7P4vUJGcQEleHeMnO', 18, 1, 'Inactive', '2024-11-10 10:32:10'),
(51, 'faisal j', 'deletepleasenam1e@gmail.com', '$2y$10$j3NkNMqxnOiaHxJkMA6HrOcUYFVv5ci4VSfpbOUh3e7AjTD.2cYYm', 11, 0, 'Active', '2024-11-10 11:16:32'),
(52, 'Testuser', 'test@gmail.com', '$2y$10$TJkmT3ymp1FKLW15B9k8FuQSsB84OkyTdlX9eqcnl8ESHpKimGr3G', 24, 0, 'Active', '2024-11-11 09:29:19'),
(53, 'Test1', 'deletepleasename1@gmail.com', '$2y$10$C2hmfRTsJ8NYZxt5RWj2meeFosRANTmVq642QuPPmBO2zycjwUj/m', 20, 0, 'Active', '2024-11-11 09:30:49'),
(54, 'testing', 'testing@gmail.com', '$2y$10$u6y6y.4T/YozPdvIfX7f7.6S1YJXDTS9lGEqm9bgylDpP/me64cJu', 14, 0, 'Active', '2024-11-11 10:07:25'),
(55, 'john_doe', 'john@example.com', '$2y$10$8uuiUI3jJkDkTgU4k3B8jO3HtJZT/r9fJoRMI4FXgUm98r6bZ9AiK', 30, 0, 'Active', '2024-11-11 10:43:01'),
(56, 'jane_smith', 'jane@example.com', '$2y$10$hghjhSJHdjskfH2j8sd3uJ8FDkjsh4r9fJoRMI4FXgUm98r6bZ9AiK', 25, 0, 'Active', '2024-11-11 10:43:01'),
(57, 'alex_jones', 'alex@example.com', '$2y$10$1djkF2jhkdjfhDJ2D8J4KJD9r9fJoRMI4FXgUm98r6bZ9AiK', 22, 0, 'Active', '2024-11-11 10:43:01'),
(58, 'testag', 'testag@gmail.com', '$2y$10$YUHXNb8q/fviJRCCe2l86OIh8pp71eD4E5lTxfo6DW4C4XQ6y3n2i', 24, 0, 'Active', '2024-11-13 10:24:04'),
(59, 'testag1', 'testag1@gmail.com', '$2y$10$oPSE9F42wzh3qt/HeUxSPOirmxtA8nSr3AvLYSF2cnJPtFGRkntki', 24, 0, 'Active', '2024-11-13 10:40:19'),
(60, 'testag2', 'testag2@gmail.com', '$2y$10$EGSwiWQ4EQBC8cg64ZoQZe7EVhSeoWnnvh1r5DurXyCqfC.LruxA6', 24, 0, 'Active', '2024-11-13 10:44:02'),
(61, 'testag3', 'testag4@gmail.com', '$2y$10$Xdxbw1n/RswP8j6XDr6Pue3HAa1ZHAgYn80/3wpZ5yaLxHjYUSyhu', 24, 0, 'Active', '2024-11-13 10:44:33'),
(62, 'testag5', 'testag5@gmail.com', '$2y$10$QT7c5/tpn4tDvA9wV4gFjeabbsTB3RWTOnMDlJAePNfFS3uR9QEri', 24, 0, 'Active', '2024-11-13 10:56:45'),
(63, 'tester', 'tester@gmail.com', '$2y$10$Jcdu9ieVWDzuTM/GmA5dhep00zqSR3bPObtaEj6s4qKh76BUJoWVq', 24, 0, 'Active', '2024-11-14 10:22:08'),
(64, 'useruser', 'useruser@gmail.com', '$2y$10$LXbMRWvcQoZ2S2m2ewrbRucIeU4SoUWoO75lRiEXmYfQXwIZHK1Oe', 24, 0, 'Active', '2024-11-18 23:41:24'),
(65, 'ICONOIC', 'iconic@gmail.com', '$2y$10$BSsrwj52H4W.zMTrlfyUD.sQ6ad/8/3KTfHYLyeAbhpfREmwiIfHG', 24, 0, 'Active', '2024-11-20 12:28:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `show_id` (`show_id`);

--
-- Indexes for table `cinemas`
--
ALTER TABLE `cinemas`
  ADD PRIMARY KEY (`cinema_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorite_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genre_id`),
  ADD UNIQUE KEY `genre_name` (`genre_name`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `movie_genres`
--
ALTER TABLE `movie_genres`
  ADD PRIMARY KEY (`movie_id`,`genre_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `screens`
--
ALTER TABLE `screens`
  ADD PRIMARY KEY (`screen_id`),
  ADD KEY `cinema_id` (`cinema_id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`seat_id`),
  ADD KEY `screen_id` (`screen_id`),
  ADD KEY `fk_show` (`show_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `shows`
--
ALTER TABLE `shows`
  ADD PRIMARY KEY (`show_id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `screen_id` (`screen_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `cinemas`
--
ALTER TABLE `cinemas`
  MODIFY `cinema_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `screens`
--
ALTER TABLE `screens`
  MODIFY `screen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `seat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `shows`
--
ALTER TABLE `shows`
  MODIFY `show_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=277;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`show_id`) REFERENCES `shows` (`show_id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE;

--
-- Constraints for table `movie_genres`
--
ALTER TABLE `movie_genres`
  ADD CONSTRAINT `movie_genres_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movie_genres_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`genre_id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE;

--
-- Constraints for table `screens`
--
ALTER TABLE `screens`
  ADD CONSTRAINT `screens_ibfk_1` FOREIGN KEY (`cinema_id`) REFERENCES `cinemas` (`cinema_id`) ON DELETE CASCADE;

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `fk_show` FOREIGN KEY (`show_id`) REFERENCES `shows` (`show_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`screen_id`) REFERENCES `screens` (`screen_id`) ON DELETE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `shows`
--
ALTER TABLE `shows`
  ADD CONSTRAINT `shows_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shows_ibfk_2` FOREIGN KEY (`screen_id`) REFERENCES `screens` (`screen_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
