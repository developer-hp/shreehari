-- Add is_locked column to supplier ledger transaction table
ALTER TABLE `cp_supplier_ledger_txn` 
ADD COLUMN `is_locked` TINYINT NOT NULL DEFAULT 0 COMMENT '1=Locked (cannot edit after opening balance update)' AFTER `is_deleted`;

-- Add is_locked column to karigar jama voucher table
ALTER TABLE `cp_karigar_jama_voucher` 
ADD COLUMN `is_locked` TINYINT NOT NULL DEFAULT 0 COMMENT '1=Locked (cannot edit after opening balance update)' AFTER `is_deleted`;
