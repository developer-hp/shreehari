-- Add remark column to supplier ledger transaction table
ALTER TABLE `cp_supplier_ledger_txn` 
ADD COLUMN `remark` TEXT NULL AFTER `drcr`;

-- Add remark column to karigar jama voucher table
ALTER TABLE `cp_karigar_jama_voucher` 
ADD COLUMN `remark` TEXT NULL AFTER `drcr`;
