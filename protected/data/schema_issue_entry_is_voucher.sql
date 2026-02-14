-- Add is_voucher to cp_issue_entry: 0 = manual entry, 1 = created from Jama or Supplier Ledger
ALTER TABLE `cp_issue_entry` ADD COLUMN `is_voucher` TINYINT NOT NULL DEFAULT 0 COMMENT '1=from Jama/Supplier Ledger' AFTER `is_deleted`;
