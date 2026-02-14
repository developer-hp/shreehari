-- Supplier Ledger Book: transaction header
CREATE TABLE IF NOT EXISTS `cp_supplier_ledger_txn` (
  `id` int NOT NULL AUTO_INCREMENT,
  `txn_date` date NOT NULL,
  `supplier_id` int NOT NULL COMMENT 'cp_customer.id (type=1)',
  `sr_no` varchar(30) DEFAULT NULL,
  `voucher_number` varchar(30) DEFAULT NULL COMMENT 'auto-generated e.g. SLV000001',
  `total_fine_wt` decimal(18,3) DEFAULT NULL,
  `total_amount` decimal(18,2) DEFAULT NULL,
  `issue_entry_id` int DEFAULT NULL COMMENT 'cp_issue_entry.id when linked',
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `is_deleted` tinyint DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `txn_date` (`txn_date`),
  KEY `issue_entry_id` (`issue_entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Supplier Ledger: line items (per product)
CREATE TABLE IF NOT EXISTS `cp_supplier_ledger_txn_item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `txn_id` int NOT NULL,
  `sr_no` varchar(20) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `ct` decimal(10,2) DEFAULT NULL COMMENT 'count',
  `gross_wt` decimal(18,3) DEFAULT NULL,
  `net_wt` decimal(18,3) DEFAULT NULL,
  `touch_pct` decimal(10,2) DEFAULT NULL COMMENT 'touch percentage',
  `fine_wt` decimal(18,3) DEFAULT NULL COMMENT 'touch_pct/100 * net_wt',
  `item_total` decimal(18,2) DEFAULT NULL COMMENT 'sum of all charges for this item',
  `sort_order` int DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `txn_id` (`txn_id`),
  CONSTRAINT `fk_supplier_ledger_item_txn` FOREIGN KEY (`txn_id`) REFERENCES `cp_supplier_ledger_txn` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Charge types: 1=moti_gm_ct, 2=mani_gm_ct, 3=villandi_ct, 4=jadtar_stone_psc, 5=other
CREATE TABLE IF NOT EXISTS `cp_supplier_ledger_txn_item_charge` (
  `id` int NOT NULL AUTO_INCREMENT,
  `txn_item_id` int NOT NULL,
  `charge_type` tinyint NOT NULL COMMENT '1=moti_gm_ct, 2=mani_gm_ct, 3=villandi_ct, 4=jadtar_stone_psc, 5=other',
  `charge_name` varchar(255) DEFAULT NULL COMMENT 'for type 5 only',
  `quantity` decimal(18,3) DEFAULT NULL,
  `rate` decimal(18,2) DEFAULT NULL,
  `amount` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `txn_item_id` (`txn_item_id`),
  CONSTRAINT `fk_supplier_ledger_charge_item` FOREIGN KEY (`txn_item_id`) REFERENCES `cp_supplier_ledger_txn_item` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
