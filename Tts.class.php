<?php
// vim: set ai ts=4 sw=4 ft=php:
namespace FreePBX\modules;

class Tts extends \FreePBX_Helpers implements \BMO {

	public function __construct($freepbx = null) {
		$this->freepbx = $freepbx;
		$this->db = $freepbx->Database;
	}

	public function install() {

	}
	public function uninstall() {

	}
	public function backup(){

	}
	public function restore($backup){

	}
	public function doConfigPageInit() {
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
				$_REQUEST['id'] = \tts_add($vars['name'], $vars['text'], $goto, $vars['engine']);
				\needreload();
			break;
			case "delete":
				\tts_del($vars['id']);
				$_REQUEST['id'] = null;
				\needreload();
			break;
			case "edit":
				\tts_update($vars['id'], $vars['name'], $vars['text'], $goto, $_REQUEST['engine']);
				\needreload();
			break;
		}
	}
	public function listTTS(){
		$sql = "SELECT id, name FROM tts ORDER BY name";
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchall(\PDO::FETCH_ASSOC);
		if(!$res) {
			return array();
		}
		return $res;
	}
	public function getActionBar($request) {
		$buttons = array();
		if (!function_exists('ttsengines_get_all_engines')) {
				return $buttons;
		}
		switch($request['display']) {
			case 'tts':
				$buttons = array(
					'delete' => array(
						'name' => 'delete',
						'id' => 'delete',
						'value' => _("Delete")
					),
					'reset' => array(
						'name' => 'reset',
						'id' => 'reset',
						'value' => _("Reset")
					),
					'submit' => array(
						'name' => 'submit',
						'id' => 'submit',
						'value' => _("Submit")
					)
				);
				if(empty($request['id']) || $request['action'] == 'delete'){
					unset($buttons['delete']);
				}
				return $buttons;
			break;
		}
	}
	public function getRightNav($request) {
	  return load_view(__DIR__."/views/rnav.php",array());
	}
	public function ajaxRequest($req, &$setting) {
		switch ($req) {
			case 'getJSON':
				return true;
			break;
			default:
				return false;
			break;
		}
	}
	public function ajaxHandler(){
		switch ($_REQUEST['command']) {
			case 'getJSON':
				switch ($_REQUEST['jdata']) {
					case 'grid':
						return array_values($this->listTTS());
					break;

					default:
						return false;
					break;
				}
			break;

			default:
				return false;
			break;
		}
}
}
