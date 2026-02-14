CREATE TABLE IF NOT EXISTS `cp_subitem_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `sort_order` int DEFAULT 0,
  `is_deleted` tinyint DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `cp_subitem_types` (`id`, `name`, `sort_order`, `is_deleted`) VALUES
(1, 'Moti gm/ct', 1, 0),
(2, 'Mani gm/ct', 2, 0),
(3, 'Villandi ct', 3, 0),
(4, 'Jadtar stone psc', 4, 0),
(5, 'Other charges', 5, 0);
