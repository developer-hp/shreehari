-- Add Issue Entry link to Supplier Ledger (run if table already exists without this column)
ALTER TABLE `cp_supplier_ledger_txn`
  ADD COLUMN `issue_entry_id` int DEFAULT NULL COMMENT 'cp_issue_entry.id when linked',
  ADD KEY `issue_entry_id` (`issue_entry_id`);
