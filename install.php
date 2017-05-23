<?php
$table = \FreePBX::Database()->migrate("tts");
$cols = array (
	'id' => array (
		'type' => 'integer',
		'primaryKey' => true,
		'autoincrement' => true,
	),
	'name' => array (
		'type' => 'string',
		'length' => '100',
	),
	'text' => array (
		'type' => 'text',
	),
	'goto' => array (
		'type' => 'string',
		'length' => '50',
		'notnull' => false,
	),
	'engine' => array (
		'type' => 'string',
		'length' => '50',
		'notnull' => false,
	),
);

$table->modify($cols);
unset($table);
