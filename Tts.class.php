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

	}
	public function getActionBar($request) {
		$buttons = array();
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
}
