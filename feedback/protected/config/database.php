<?php

// This is the database connection configuration.
// This is the database connection configuration.
$username = "amcodr";
$password = "amcodr@123";
$database = "customer_ledger_db";

$username = "root";
$password = "";
$database = "test_hari_db";

return array(
	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
	// uncomment the following lines to use a MySQL database
	'connectionString' => 'mysql:host=localhost;dbname='.$database,
	'emulatePrepare' => true,
	'username' => $username,
	'password' => $password,
	'charset' => 'utf8',
);