<?php

class m260417_120000_create_diamond_voucher_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('cp_diamond_voucher', array(
			'id' => 'pk',
			'voucher_date' => 'date NOT NULL',
			'voucher_number' => 'varchar(30) DEFAULT NULL',
			'customer_id' => 'int(11) NOT NULL',
			'subitem_type_id' => 'int(11) NOT NULL',
			'qty' => 'decimal(12,3) NOT NULL DEFAULT 0.000',
			'rate' => 'decimal(12,2) NOT NULL DEFAULT 0.00',
			'amount' => 'decimal(12,2) NOT NULL DEFAULT 0.00',
			'drcr' => 'tinyint(1) NOT NULL DEFAULT 1',
			'issue_entry_id' => 'int(11) DEFAULT NULL',
			'remarks' => 'text',
			'created_by' => 'int(11) DEFAULT NULL',
			'created_at' => 'datetime DEFAULT NULL',
			'is_deleted' => 'tinyint(1) NOT NULL DEFAULT 0',
			'is_locked' => 'tinyint(1) NOT NULL DEFAULT 0',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

		$this->createIndex('idx_diamond_voucher_date', 'cp_diamond_voucher', 'voucher_date');
		$this->createIndex('idx_diamond_voucher_customer', 'cp_diamond_voucher', 'customer_id');
		$this->createIndex('idx_diamond_voucher_issue_entry', 'cp_diamond_voucher', 'issue_entry_id');
		$this->createIndex('idx_diamond_voucher_deleted', 'cp_diamond_voucher', 'is_deleted');
	}

	public function down()
	{
		$this->dropTable('cp_diamond_voucher');
	}
}