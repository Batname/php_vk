
--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `arrays` (
`id` int(100) NOT NULL AUTO_INCREMENT,
  `reposts` int(100) DEFAULT NULL,
  `username` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `userlink` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `userimage` varchar(1000) CHARACTER SET utf8 DEFAULT NULL,
  `user_news_id` int(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
