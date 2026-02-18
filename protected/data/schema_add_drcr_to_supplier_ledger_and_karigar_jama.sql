-- Add drcr column to supplier ledger transaction table
ALTER TABLE `cp_supplier_ledger_txn` 
ADD COLUMN `drcr` TINYINT NOT NULL DEFAULT 1 COMMENT '1=DR, 2=CR' AFTER `issue_entry_id`;

-- Add drcr column to karigar jama voucher table
ALTER TABLE `cp_karigar_jama_voucher` 
ADD COLUMN `drcr` TINYINT NOT NULL DEFAULT 2 COMMENT '1=DR, 2=CR' AFTER `issue_entry_id`;
