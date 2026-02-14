-- Add closing_wt and closing_amount to cp_customer (net from Opening Balance + Issue Entry).
-- Run this once: positive = DR, negative = CR.
ALTER TABLE `cp_customer`
  ADD COLUMN `closing_wt` DECIMAL(18,3) DEFAULT NULL COMMENT 'Net closing fine wt (DR-CR)',
  ADD COLUMN `closing_amount` DECIMAL(18,2) DEFAULT NULL COMMENT 'Net closing amount (DR-CR)';
