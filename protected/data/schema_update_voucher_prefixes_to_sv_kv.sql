-- Update document sequence doc_type from SLV/JMV to SV/KV
-- This migration updates the sequence table to use new prefixes

-- Update existing SLV entries to SV (if any exist)
UPDATE `cp_document_sequence` SET `doc_type` = 'SV' WHERE `doc_type` = 'SLV';

-- Update existing JMV entries to KV (if any exist)
UPDATE `cp_document_sequence` SET `doc_type` = 'KV' WHERE `doc_type` = 'JMV';

-- Insert SV and KV if they don't exist (safe to re-run)
INSERT INTO `cp_document_sequence` (`doc_type`, `next_no`) VALUES
  ('SV', 1),
  ('KV', 1)
ON DUPLICATE KEY UPDATE `doc_type` = VALUES(`doc_type`);
