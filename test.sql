-- Adminer 4.2.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `ads`;
CREATE TABLE `ads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `physical` tinyint(4) NOT NULL,
  `seller_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `description` varchar(200) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `allow_mails` tinyint(4) NOT NULL,
  `city` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `t_groupid` (`groupid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `categories` (`id`, `groupid`, `name`) VALUES
(9,	1,	'Автомобили с пробегом'),
(10,	1,	'Запчасти и аксессуары'),
(11,	1,	'Водный транспорт'),
(14,	1,	'Мотоциклы и мототехника'),
(19,	6,	'Ремонт и строительство'),
(20,	6,	'Мебель и интерьер'),
(21,	6,	'Бытовая техника'),
(23,	2,	'Комнаты'),
(24,	2,	'Квартиры'),
(25,	2,	'Дома, дачи, коттеджи'),
(26,	2,	'Гаражи и машиноместа'),
(27,	5,	'Одежда, обувь, аксессуары'),
(28,	5,	'Часы и украшения'),
(29,	5,	'Детская одежда и обувь'),
(30,	5,	'Товары для детей и игрушки'),
(31,	7,	'Настольные компьютеры'),
(32,	7,	'Аудио и видео'),
(33,	8,	'Билеты и путешествия'),
(34,	8,	'Велосипеды'),
(36,	8,	'Коллекционирование'),
(38,	8,	'Музыкальные инструменты'),
(39,	8,	'Спорт и отдых'),
(40,	10,	'Оборудование для бизнеса'),
(42,	2,	'Коммерческая недвижимость'),
(81,	1,	'Грузовики и спецтехника'),
(82,	6,	'Продукты питания'),
(83,	8,	'Книги и журналы'),
(84,	7,	'Телефоны'),
(86,	2,	'Недвижимость за рубежом'),
(87,	6,	'Посуда и товары для кухни'),
(88,	5,	'Красота и здоровье'),
(89,	9,	'Собаки'),
(90,	9,	'Кошки'),
(91,	9,	'Птицы'),
(92,	9,	'Аквариум'),
(93,	9,	'Другие животные'),
(94,	9,	'Товары для животных'),
(96,	7,	'Планшеты и электронные книги'),
(97,	7,	'Игры, приставки и программы'),
(98,	7,	'Ноутбуки'),
(99,	7,	'Оргтехника и расходники'),
(101,	7,	'Товары для компьютера'),
(102,	8,	'Охота и рыбалка'),
(103,	8,	'Знакомства'),
(105,	7,	'Фототехника'),
(106,	6,	'Растения'),
(109,	1,	'Новые автомобили'),
(111,	3,	'Вакансии (поиск сотрудников)'),
(112,	3,	'Резюме (поиск работы)'),
(114,	4,	'Предложения услуг'),
(115,	4,	'Запросы на услуги'),
(116,	10,	'Готовый бизнес');

DROP TABLE IF EXISTS `category_groups`;
CREATE TABLE `category_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `category_groups` (`id`, `name`) VALUES
(1,	'Транспорт'),
(2,	'Недвижимость'),
(3,	'Работа'),
(4,	'Услуги'),
(5,	'Личные вещи'),
(6,	'Для дома и дачи'),
(7,	'Бытовая электроника'),
(8,	'Хобби и отдых'),
(9,	'Животные'),
(10,	'Для бизнеса'),
(9999,	'Разное');

DELIMITER ;;

CREATE TRIGGER `category_groups_bd` BEFORE DELETE ON `category_groups` FOR EACH ROW
UPDATE categories cat SET cat.groupid = 9999 WHERE cat.groupid = old.id;;

DELIMITER ;

DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `cities` (`id`, `name`) VALUES
(641490,	'Барабинск'),
(641510,	'Бердск'),
(641600,	'Искитим'),
(641630,	'Колывань'),
(641680,	'Краснообск'),
(641710,	'Куйбышев'),
(641760,	'Мошково'),
(641780,	'Новосибирск'),
(641790,	'Обь'),
(641800,	'Ордынское'),
(641970,	'Черепаново');

-- 2015-10-28 12:33:29
