<?php
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed');}

$autoincrement = (($amp_conf["AMPDBENGINE"] == "sqlite") || ($amp_conf["AMPDBENGINE"] == "sqlite3")) ? "AUTOINCREMENT":"AUTO_INCREMENT";

$sql = "CREATE TABLE IF NOT EXISTS tts (
	id INTEGER NOT NULL $autoincrement,
	name VARCHAR( 100 ) NOT NULL,
	text VARCHAR( 250 ) NOT NULL,
	goto VARCHAR( 50 ),
	engine VARCHAR( 50 ),
	PRIMARY KEY (id)
	)";

$result = $db->query($sql);
if(DB::IsError($result)) {
	die_freepbx($result->getDebugInfo());
}
