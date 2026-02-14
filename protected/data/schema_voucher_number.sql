-- Add auto-generated voucher_number to supplier ledger and karigar jama
ALTER TABLE `cp_supplier_ledger_txn` ADD COLUMN `voucher_number` varchar(30) DEFAULT NULL COMMENT 'auto-generated e.g. SLV000001' AFTER `sr_no`;
ALTER TABLE `cp_karigar_jama_voucher` ADD COLUMN `voucher_number` varchar(30) DEFAULT NULL COMMENT 'auto-generated e.g. JMV000001' AFTER `sr_no`;
