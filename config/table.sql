CREATE TABLE IF NOT EXISTS films (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) DEFAULT NULL,
  `Release_Year` int(11) DEFAULT NULL,
  `format` varchar(255) DEFAULT NULL,
  `Stars` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

