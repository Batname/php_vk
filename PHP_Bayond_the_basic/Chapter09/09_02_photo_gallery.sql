
--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=8;

--
-- Dumping data for table `users`
--
INSERT INTO `users` VALUES (1,'kskoglund','secretpwd','Kevin','Skoglund'),(7,'janesmith','abcd\'12345','Jane','Smith'),(6,'johnsmith','45668899','John','Smith');
