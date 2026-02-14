-- Karigar Jama Voucher: header (linked to Issue Entry)
CREATE TABLE IF NOT EXISTS `cp_karigar_jama_voucher` (
  `id` int NOT NULL AUTO_INCREMENT,
  `voucher_date` date NOT NULL,
  `karigar_id` int NOT NULL COMMENT 'cp_customer.id (type=3)',
  `issue_entry_id` int DEFAULT NULL COMMENT 'cp_issue_entry.id when connected',
  `sr_no` varchar(30) DEFAULT NULL,
  `voucher_number` varchar(30) DEFAULT NULL COMMENT 'auto-generated e.g. JMV000001',
  `total_fine_wt` decimal(18,3) DEFAULT NULL,
  `total_amount` decimal(18,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `is_deleted` tinyint DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `karigar_id` (`karigar_id`),
  KEY `issue_entry_id` (`issue_entry_id`),
  KEY `voucher_date` (`voucher_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Jama voucher lines
CREATE TABLE IF NOT EXISTS `cp_karigar_jama_voucher_line` (
  `id` int NOT NULL AUTO_INCREMENT,
  `voucher_id` int NOT NULL,
  `sr_no` varchar(20) DEFAULT NULL,
  `order_no` varchar(50) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `psc` decimal(10,2) DEFAULT NULL,
  `gross_wt` decimal(18,3) DEFAULT NULL,
  `net_wt` decimal(18,3) DEFAULT NULL,
  `touch_pct` decimal(10,2) DEFAULT NULL,
  `fine_wt` decimal(18,3) DEFAULT NULL COMMENT 'touch_pct/100 * net_wt',
  `remark` varchar(500) DEFAULT NULL,
  `sort_order` int DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `voucher_id` (`voucher_id`),
  CONSTRAINT `fk_jama_line_voucher` FOREIGN KEY (`voucher_id`) REFERENCES `cp_karigar_jama_voucher` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Stone (multiple per line): Item | Weight | Amount
CREATE TABLE IF NOT EXISTS `cp_karigar_jama_line_stone` (
  `id` int NOT NULL AUTO_INCREMENT,
  `line_id` int NOT NULL,
  `item` varchar(255) DEFAULT NULL,
  `stone_wt` decimal(18,3) DEFAULT NULL,
  `stone_amount` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `line_id` (`line_id`),
  CONSTRAINT `fk_jama_stone_line` FOREIGN KEY (`line_id`) REFERENCES `cp_karigar_jama_voucher_line` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Diamond (multiple per line)
CREATE TABLE IF NOT EXISTS `cp_karigar_jama_line_diamond` (
  `id` int NOT NULL AUTO_INCREMENT,
  `line_id` int NOT NULL,
  `diamond_wt` decimal(18,3) DEFAULT NULL,
  `diamond_amount` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `line_id` (`line_id`),
  CONSTRAINT `fk_jama_diamond_line` FOREIGN KEY (`line_id`) REFERENCES `cp_karigar_jama_voucher_line` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Other amount (multiple per line)
CREATE TABLE IF NOT EXISTS `cp_karigar_jama_line_other` (
  `id` int NOT NULL AUTO_INCREMENT,
  `line_id` int NOT NULL,
  `other_amount` decimal(18,2) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `line_id` (`line_id`),
  CONSTRAINT `fk_jama_other_line` FOREIGN KEY (`line_id`) REFERENCES `cp_karigar_jama_voucher_line` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
