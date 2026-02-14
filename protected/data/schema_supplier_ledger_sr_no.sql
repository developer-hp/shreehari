ALTER TABLE `cp_supplier_ledger_txn`
  ADD COLUMN `sr_no` varchar(30) DEFAULT NULL AFTER `supplier_id`,
  ADD KEY `sr_no` (`sr_no`);
