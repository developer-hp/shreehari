-- Document number sequences for DocumentNumberService (SLT, SV, KV, etc.)
-- Run this if voucher_number or sr_no is not auto-generating (e.g. table missing).

SET NAMES utf8;

CREATE TABLE IF NOT EXISTS `cp_document_sequence` (
  `doc_type` VARCHAR(10) NOT NULL,
  `next_no` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`doc_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Seed all doc types used by the app (safe to re-run)
INSERT INTO `cp_document_sequence` (`doc_type`, `next_no`) VALUES
  ('SUP', 1),
  ('KAR', 1),
  ('ISS', 1),
  ('SLT', 1),
  ('SV', 1),
  ('KV', 1)
ON DUPLICATE KEY UPDATE `doc_type` = VALUES(`doc_type`);
