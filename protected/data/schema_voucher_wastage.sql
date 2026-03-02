-- Add wastage % column for supplier and karigar voucher line items
ALTER TABLE `cp_supplier_ledger_txn_item`
  ADD COLUMN `wastage` decimal(10,2) DEFAULT 0 AFTER `touch_pct`;

ALTER TABLE `cp_karigar_jama_voucher_line`
  ADD COLUMN `wastage` decimal(10,2) DEFAULT 0 AFTER `touch_pct`;
