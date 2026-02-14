-- Add item column to stone table (Item | Weight | Amount template)
ALTER TABLE `cp_karigar_jama_line_stone` ADD COLUMN `item` varchar(255) DEFAULT NULL AFTER `line_id`;
