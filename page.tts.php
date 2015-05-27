<?php /* $Id: $ */
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed');}
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2013 Schmooze Com Inc.
//  Xavier Ourciere xourciere[at]propolys[dot]com
//

/**
 * This module REQUIRES the 'ttsengines' module. But since FreePBX
 *  doesn't handle circular dependancies, we have to force one.
 */
if (!function_exists('ttsengines_get_all_engines')) {
	show_view(__DIR__ . '/views/no-ttsengines.php');
	return;
}

$request = array(
	'action',
	'id',
	'goto0',
	'name',
	'text',
	'engine',
);
$vars = array();
$goto = null;

foreach($request as $key) {
	$vars[$key] = isset($_REQUEST[$key]) ? $_REQUEST[$key] : null;
}

if (isset($vars['goto0']) && isset($_REQUEST[$vars['goto0']."0"])) {
	$goto = $_REQUEST[$vars['goto0']."0"];
}

switch ($vars['action']) {
	case "add":
		$vars['id'] = tts_add($vars['name'], $vars['text'], $goto, $vars['engine']);
		needreload();
	break;
	case "delete":
		tts_del($vars['id']);
		$vars['id'] = null;
		needreload();
	break;
	case "edit":
		tts_update($vars['id'], $vars['name'], $vars['text'], $goto, $_REQUEST['engine']);
		needreload();
	break;
}

//this function needs to be available to other modules (those that use goto destinations)
//therefore we put it in globalfunctions.php
$data['tts_list'] = tts_list();
$data['engine_list'] = ttsengines_get_all_engines();
$data['action'] = $vars['action'];

if ( (isset($amp_conf['ASTVARLIBDIR'])?$amp_conf['ASTVARLIBDIR']:'') == '') {
	$astlib_path = "/var/lib/asterisk";
} else {
	$astlib_path = $amp_conf['ASTVARLIBDIR'];
}
$data['tts_astsnd_path'] = $astlib_path . "/sounds/tts/";

$data['tts_agi_error'] = null;
if (!($tts_agi = file_exists($astlib_path."/agi-bin/propolys-tts.agi"))) {
	$data['tts_agi_error'] = _("AGI script not found");
}

if (!empty($vars['id']) || $action !== 'delete') {
	$tts = tts_get($vars['id']);

	foreach ($tts as $key => $value) {
		$data[$key] = $value;
	}
}

show_view(__DIR__ . '/views/tts.php', $data);
