CREATE DATABASE `plates` /*!40100 DEFAULT CHARACTER SET utf8 */;
CREATE TABLE `message` (
  `idmessage` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  `plate` varchar(255) DEFAULT NULL,
  `message` varchar(225) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idmessage`),
  UNIQUE KEY `idmessage_UNIQUE` (`idmessage`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
CREATE TABLE `names` (
  `idnames` int(11) NOT NULL,
  `name` varchar(225) DEFAULT NULL,
  `article` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`idnames`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `plate` (
  `idplate` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) DEFAULT NULL,
  `plate` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idplate`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
