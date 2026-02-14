-- Add total_fine_wt and total_amount to voucher (stored for grid display)
ALTER TABLE `cp_karigar_jama_voucher` ADD COLUMN `total_fine_wt` decimal(18,3) DEFAULT NULL AFTER `sr_no`;
ALTER TABLE `cp_karigar_jama_voucher` ADD COLUMN `total_amount` decimal(18,2) DEFAULT NULL AFTER `total_fine_wt`;
