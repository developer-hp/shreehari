-- Ledger / Voucher module schema (new tables)
-- Note: This project does not use Yii migrations; apply this SQL to your MySQL DB.

SET NAMES utf8;

-- Master: Ledger Accounts
CREATE TABLE IF NOT EXISTS `cp_ledger_account` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `type` TINYINT NOT NULL COMMENT '1=Supplier,2=Karigar',
  `party_customer_id` INT NULL COMMENT 'Optional link to cp_customer.id',
  `opening_fine_wt` DECIMAL(16,3) NOT NULL DEFAULT 0.000,
  `opening_fine_wt_drcr` TINYINT NOT NULL DEFAULT 2 COMMENT '1=DR,2=CR',
  `opening_amount` DECIMAL(16,2) NOT NULL DEFAULT 0.00,
  `opening_amount_drcr` TINYINT NOT NULL DEFAULT 2 COMMENT '1=DR,2=CR',
  `is_deleted` TINYINT NOT NULL DEFAULT 0,
  `created_at` DATETIME NULL,
  `created_by` INT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_ledger_account_type` (`type`),
  KEY `idx_ledger_account_party` (`party_customer_id`),
  KEY `idx_ledger_account_deleted` (`is_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Shared: Document numbering
CREATE TABLE IF NOT EXISTS `cp_document_sequence` (
  `doc_type` VARCHAR(10) NOT NULL,
  `next_no` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`doc_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Supplier Ledger (A) - Header
CREATE TABLE IF NOT EXISTS `cp_supplier_txn` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sr_no` VARCHAR(30) NOT NULL,
  `txn_date` DATE NOT NULL,
  `supplier_account_id` INT NOT NULL,
  `remarks` TEXT NULL,
  `created_by` INT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `is_deleted` TINYINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_supplier_txn_sr_no` (`sr_no`),
  KEY `idx_supplier_txn_date` (`txn_date`),
  KEY `idx_supplier_txn_account` (`supplier_account_id`),
  KEY `idx_supplier_txn_deleted` (`is_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Supplier Ledger (A) - Items
CREATE TABLE IF NOT EXISTS `cp_supplier_txn_item` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `supplier_txn_id` INT NOT NULL,
  `sr_no_line` INT NOT NULL DEFAULT 1,
  `item_name` VARCHAR(255) NOT NULL,
  `ct` DECIMAL(16,3) NULL DEFAULT NULL,
  `gross_wt` DECIMAL(16,3) NULL DEFAULT NULL,
  `net_wt` DECIMAL(16,3) NULL DEFAULT NULL,
  `touch_pct` DECIMAL(7,3) NULL DEFAULT NULL,
  `fine_wt` DECIMAL(16,3) NULL DEFAULT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_supplier_item_txn` (`supplier_txn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Supplier Ledger (A) - Charges
CREATE TABLE IF NOT EXISTS `cp_supplier_txn_charge` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `supplier_txn_item_id` INT NOT NULL,
  `charge_type` VARCHAR(30) NULL DEFAULT NULL COMMENT 'moti/mani/villandi/jadtar/other',
  `name` VARCHAR(255) NULL DEFAULT NULL,
  `qty` DECIMAL(16,3) NULL DEFAULT NULL,
  `rate` DECIMAL(16,2) NULL DEFAULT NULL,
  `amount` DECIMAL(16,2) NULL DEFAULT NULL,
  `unit` VARCHAR(10) NULL DEFAULT NULL COMMENT 'gm/ct/psc',
  `sort_order` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_supplier_charge_item` (`supplier_txn_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Karigar Jama Voucher + Ledger (B) - Header
CREATE TABLE IF NOT EXISTS `cp_karigar_voucher` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sr_no` VARCHAR(30) NOT NULL,
  `voucher_date` DATE NOT NULL,
  `karigar_account_id` INT NOT NULL,
  `remarks` TEXT NULL,
  `created_by` INT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `is_deleted` TINYINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_karigar_voucher_sr_no` (`sr_no`),
  KEY `idx_karigar_voucher_date` (`voucher_date`),
  KEY `idx_karigar_voucher_account` (`karigar_account_id`),
  KEY `idx_karigar_voucher_deleted` (`is_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Karigar Jama Voucher - Lines
CREATE TABLE IF NOT EXISTS `cp_karigar_voucher_line` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `karigar_voucher_id` INT NOT NULL,
  `order_no` VARCHAR(50) NULL DEFAULT NULL,
  `customer_account_id` INT NULL DEFAULT NULL COMMENT 'Optional link to cp_customer.id or cp_ledger_account.id (customer)',
  `item_name` VARCHAR(255) NOT NULL,
  `psc` INT NULL DEFAULT NULL,
  `gross_wt` DECIMAL(16,3) NULL DEFAULT NULL,
  `net_wt` DECIMAL(16,3) NULL DEFAULT NULL,
  `touch_pct` DECIMAL(7,3) NULL DEFAULT NULL,
  `fine_wt` DECIMAL(16,3) NULL DEFAULT NULL,
  `remark` VARCHAR(255) NULL DEFAULT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_karigar_line_voucher` (`karigar_voucher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Karigar Jama Voucher - Components
CREATE TABLE IF NOT EXISTS `cp_karigar_voucher_component` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `karigar_voucher_line_id` INT NOT NULL,
  `component_type` VARCHAR(30) NULL DEFAULT NULL COMMENT 'stone/diamond/other',
  `name` VARCHAR(255) NULL DEFAULT NULL,
  `wt` DECIMAL(16,3) NULL DEFAULT NULL,
  `amount` DECIMAL(16,2) NULL DEFAULT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_karigar_component_line` (`karigar_voucher_line_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Credit / Issue Entry (C)
CREATE TABLE IF NOT EXISTS `cp_issue_entry` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `sr_no` VARCHAR(30) NOT NULL,
  `issue_date` DATE NOT NULL,
  `account_id` INT NOT NULL COMMENT 'cp_ledger_account.id',
  `fine_wt` DECIMAL(16,3) NULL DEFAULT NULL,
  `amount` DECIMAL(16,2) NULL DEFAULT NULL,
  `remarks` TEXT NULL,
  `created_by` INT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  `is_deleted` TINYINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_issue_entry_sr_no` (`sr_no`),
  KEY `idx_issue_entry_date` (`issue_date`),
  KEY `idx_issue_entry_account` (`account_id`),
  KEY `idx_issue_entry_deleted` (`is_deleted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Seed sequences (safe to re-run)
INSERT INTO `cp_document_sequence` (`doc_type`, `next_no`) VALUES
  ('SUP', 1),
  ('KAR', 1),
  ('ISS', 1)
ON DUPLICATE KEY UPDATE `doc_type` = VALUES(`doc_type`);

