<?php
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed');}
if ( (isset($amp_conf['ASTVARLIBDIR'])?$amp_conf['ASTVARLIBDIR']:'') == '') {
	$astlib_path = "/var/lib/asterisk";
} else {
	$astlib_path = $amp_conf['ASTVARLIBDIR'];
}

if ( !file_exists($astlib_path."/agi-bin/propolys-tts.agi") ) {
	if ( !copy($amp_conf['AMPWEBROOT']."/admin/modules/tts/agi/propolys-tts.agi", $astlib_path."/agi-bin/propolys-tts.agi") ) {
		echo _("TTS AGI install failed. Module not usable.");
	} else {
		chmod($astlib_path."/agi-bin/propolys-tts.agi", 0764);
	}
}

