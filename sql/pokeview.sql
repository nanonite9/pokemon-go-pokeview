--
-- Database: `pokeview`
--

-- --------------------------------------------------------

--
-- Table structure for table `pokestops`
--

DROP TABLE IF EXISTS `pokestops`;
CREATE TABLE IF NOT EXISTS `pokestops` (
  `pokestop_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `location_name` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `location_type` enum('Pokestop','Gym') NOT NULL,
  `s3_image_key` varchar(250) NOT NULL,
  PRIMARY KEY (`pokestop_id`),
  KEY `pokestops_fk_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pokestops`
--

INSERT INTO `pokestops` (`pokestop_id`, `user_id`, `location_name`, `description`, `latitude`, `longitude`, `location_type`, `s3_image_key`) VALUES
(1, 1, 'Wall Mural', 'No description', 43.7595103, -79.5176935, 'Pokestop', '5de0c5b68280d.jpeg'),
(2, 1, 'Yorkgate Equipment Box', 'Art covered electrical box', 43.7581368, -79.5211153, 'Gym', '5de0c6820d0bc.jpeg'),
(3, 1, 'Wisdom Over The Years', 'A giant wall mural commissioned by local community-driven initiatives.', 43.7581255, -79.5167691, 'Pokestop', '5de0c7235dbb6.jpeg'),
(4, 1, 'Derrydowns Park ', 'EX Raid Gym', 43.7596053, -79.5059923, 'Gym', '5de0c8b10c169.jpeg'),
(5, 1, 'Remberto Navia Sports Field East Sign', 'East entrance for the park and soccer field', 43.7598314, -79.5210362, 'Pokestop', '5de0c9960b55b.jpeg'),
(6, 1, 'Tobermory Playground', 'Community garden for exercise', 43.7603937, -79.5096559, 'Pokestop', '5de0ca427954f.jpeg');
-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `pokestop_id` int(11) NOT NULL,
  `review` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`),
  KEY `reviews_fk_user_id` (`user_id`) USING BTREE,
  KEY `reviews_fk_pokestop_id` (`pokestop_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` varchar(250) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

-- Password = Ayana
INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `gender`, `dob`) VALUES
(1, 'asapyanz', '$2y$10$FCc91VrPXdXThgSp8QNkoOY2D14Qg9cZ03jyAqxl50Tr00m7DDJ3S', 'ayanacrystal@gmail.com', 'Female', '01/01/1990');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pokestops`
--
ALTER TABLE `pokestops`
  ADD CONSTRAINT `pokestops_fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `pokestop_id` FOREIGN KEY (`pokestop_id`) REFERENCES `pokestops` (`pokestop_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;


