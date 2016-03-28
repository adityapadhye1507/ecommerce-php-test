-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) NOT NULL,
  PRIMARY KEY (`cart_id`,`user_id`),
  KEY `user_fk_idx` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `cart_products`;
CREATE TABLE `cart_products` (
  `cart_id` int(11) NOT NULL,
  `prodcut_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`cart_id`,`prodcut_id`),
  KEY `products_fk_idx` (`prodcut_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `sales_price` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `quantity`, `image_name`, `sales_price`) VALUES
(11,	'Deadpool Poster 11',	'Description 11',	25,	30,	'Image11.jpg',	0),
(10,	'Deadpool Poster 10',	'Description 10',	20,	12,	'Image10.jpg',	12),
(9,	'Deadpool Poster 9',	'Description 9',	15,	15,	'Image9.jpg',	10),
(3,	'Deadpool Poster 3',	'Description 3',	20,	40,	'Image3.jpg',	0),
(4,	'Deadpool Poster 4',	'Description 4',	17,	20,	'Image4.jpg',	0),
(5,	'Deadpool Poster 5',	'Description 5',	12,	40,	'Image5.jpg',	0),
(7,	'Deadpool Poster 7',	'Description 7',	17,	35,	'Image7.jpg',	0),
(8,	'Deadpool Poster 8',	'Description 8',	22,	25,	'Image8.jpg',	0),
(2,	'Deadpool Poster 2',	'Description 2',	25,	50,	'Image2.jpg',	0),
(6,	'Deadpool Poster 6',	'Description 6',	18,	30,	'Image6.jpg',	0),
(13,	'Deadpool Poster 13',	'Description 13',	10,	20,	'Image13.jpg',	0),
(12,	'Deadpool Poster 12',	'Description 12',	14,	60,	'Image12.jpg',	0),
(1,	'Deadpool Poster 1',	'Description 1',	15,	50,	'Image1.jpg',	0),
(14,	'Deadpool Poster 14',	'Description 14',	20,	10,	'Image14.jpg',	12),
(15,	'Deadpool Poster 15',	'Description 15',	30,	40,	'Image15.jpg',	0),
(16,	'Deadpool Poster 16',	'Description 16',	25,	35,	'Image16.jpg',	0),
(17,	'Deadpool Poster 17',	'Description 17',	29,	45,	'Image17.jpg',	15),
(18,	'Deadpool Poster 18',	'Description 18',	28,	20,	'Image18.jpg',	0),
(19,	'Deadpool Poster 19',	'Description 19',	12,	20,	'Image19.jpg',	0),
(20,	'Deadpool Poster 20',	'Description 20',	16,	16,	'Image20.jpeg',	0),
(21,	'Deadpool Poster 21',	'Description 21',	14,	28,	'Image21.jpg',	0),
(22,	'Deadpool Poster 22',	'Description 22',	13,	20,	'Image22.jpg',	0);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` varchar(20) NOT NULL,
  `password` varchar(45) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `users` (`user_id`, `password`, `admin`) VALUES
('admin',	'admin',	1),
('user',	'user',	0);

-- 2016-03-16 03:01:53