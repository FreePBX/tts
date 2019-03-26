<?php /* $Id: $ */
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed');}
/**
 * License for all code of this FreePBX module can be found in the license file inside the module directory
 * Copyright 2013 Schmooze Com Inc.
 * Xavier Ourciere xourciere[at]propolys[dot]com
 * Copytright 2018 Sangoma Technologies
 **/

if ( (isset($amp_conf['ASTVARLIBDIR'])?$amp_conf['ASTVARLIBDIR']:'') == '') {
	$astlib_path = "/var/lib/asterisk";
} else {
	$astlib_path = $amp_conf['ASTVARLIBDIR'];
}
$tts_astsnd_path = $astlib_path."/sounds/tts/";

if (!file_exists($astlib_path."/agi-bin/propolys-tts.agi") ) {
	$tts_agi_error = _("AGI script not found");
}

// returns a associative arrays with keys 'destination' and 'description'
function tts_destinations() {
	$results = \FreePBX::Tts()->listTTS();

	// return an associative array with destination and description
	if (isset($results) && $results){
		foreach($results as $result){
				$extens[] = array('destination' => 'ext-tts,'.$result['id'].',1', 'description' => $result['name']);
		}

		return $extens;
	} else {
		return null;
	}
}

function tts_getdestinfo($dest) {
	global $amp_conf;
		if (substr(trim($dest),0,8) == 'ext-tts,') {
			$tts = explode(',',$dest);
				$tts = $tts[1];
				$thistts = tts_get($tts);
				if (empty($thistts)) {
					return array();
				} else {
						return array('description' => sprintf(_("Text to Speech: %s"),$thistts['name']),
							'edit_url' => 'config.php?display=tts&view=form&id='.urlencode($tts),
							);
				}
	} else {
			return false;
		}
}


function tts_get_ttsengine_path($engine) {
	if (function_exists('ttsengines_get_engine_path')) {
		return ttsengines_get_engine_path($engine);
	} else {
		return "/invalid/filename";
	}
}

function tts_list() {
	FreePBX::Modules()->deprecatedFunction();
	return \FreePBX::Tts()->listTTS();
}

function tts_get($p_id) {
	global $db;

	$sql = "SELECT id, name, text, goto, engine FROM tts WHERE id=$p_id";
	return $db->getRow($sql, DB_FETCHMODE_ASSOC);
}

function tts_del($p_id) {
    FreePBX::Modules()->deprecatedFunction();
    return \FreePBX::Tts()->delete($p_id);
}

function tts_add($p_name, $p_text, $p_goto, $p_engine) {
    FreePBX::Modules()->deprecatedFunction();
    return \FreePBX::Tts()->add($p_name, $p_text, $p_goto, $p_engine);
}

function tts_update($p_id, $p_name, $p_text, $p_goto, $p_engine) {
    FreePBX::Modules()->deprecatedFunction();
    return \FreePBX::Tts()->edit($p_id, $p_name, $p_text, $p_goto, $p_engine);
}
