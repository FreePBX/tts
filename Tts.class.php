<?php
// vim: set ai ts=4 sw=4 ft=php:
namespace FreePBX\modules;
use PDO;
use BMO;
use FreePBX_Helpers;

class Tts extends FreePBX_Helpers implements BMO {
	public function install() {

	}
	public function uninstall() {

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
			$this->add($vars['name'], $vars['text'], $goto, $vars['engine']);
			needreload();
			break;
			case "delete":
			$this->delete($vars['id']);
			needreload();
			break;
			case "edit":
			$this->edit($vars['id'], $vars['name'], $vars['text'], $goto, $_REQUEST['engine']);
			needreload();
			break;
			default:
			break;
		}
	}

	public function listTTS(){
		$sql = "SELECT * FROM tts ORDER BY name";
		$stmt = $this->FreePBX->Database->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchall(PDO::FETCH_ASSOC);
		if(!$res) {
			return array();
		}
		return $res;
	}

	public function add($name, $text, $goto, $engine){
		$name = htmlentities($name, ENT_COMPAT | ENT_HTML401, "UTF-8");
		$text = htmlentities($text,ENT_COMPAT | ENT_HTML401, "UTF-8");
		$tts_list = $this->listTTS();
		$tts = [];
		if (is_array($tts_list)) {
			foreach ($tts_list as $tts) {
				if ($tts['name'] === $name) {
					echo "<script>javascript:alert('" . _("This name already exists") . "');</script>";
					return false;
				}
			}
		}
		$sql = 'INSERT INTO tts (name,text,goto,engine) VALUES (:name,:text,:goto,:engine)';
		$stmt = $this->FreePBX->Database->prepare($sql);
		$stmt->execute([
			':name' => $name,
			':text' => $text,
			':goto' => $goto,
			':engine' => $engine,
		]);
		return $this;
	}

	public function edit($id, $name, $text, $goto, $engine){
		$name = htmlentities($name, ENT_COMPAT | ENT_HTML401, "UTF-8");
		$text = htmlentities($text, ENT_COMPAT | ENT_HTML401, "UTF-8");
		$sql = 'UPDATE tts SET name = :name, text=:text, goto=:goto, engine=:engine WHERE id = :id';
		$stmt = $this->FreePBX->Database->prepare($sql);
		$stmt->execute([
			':id' => $id,
			':name' => $name,
			':text' => $text,
			':goto' => $goto,
			':engine' => $engine,
		]);
		return $this;
	}

	public function delete($id){
		$sql = 'DELETE FROM tts WHERE id = ?';
		$stmt = $this->FreePBX->Database->prepare($sql);
		$stmt->execute(array($id));
		return $this;
	}

	public static function myDialplanHooks(){
		return true;
	}

	public function doDialplanHook(&$ext, $engine, $priority){
		$contextname = 'ext-tts';
		if (is_array($tts_list = $this->listTTS())) {
			foreach ($tts_list as $item) {
				$tts = tts_get($item['id']);
				$ttsid = $tts['id'];
				$ttsname = $tts['name'];
				$ttstext = $tts['text'];
				$ttsgoto = $tts['goto'];
				$ttsengine = $tts['engine'];
				$ttspath = tts_get_ttsengine_path($ttsengine);
				$ext->add($contextname, $ttsid, '', new \ext_noop('TTS: ' . $ttsname));
				$ext->add($contextname, $ttsid, '', new \ext_noop('Using: ' . $ttsengine));
				$ext->add($contextname, $ttsid, '', new \ext_answer());
				$ext->add($contextname, $ttsid, '', new \ext_agi('propolys-tts.agi,"' . $ttstext . '",' . $ttsengine . ',' . $ttspath['path']));
				$ext->add($contextname, $ttsid, '', new \ext_goto($ttsgoto));
			}
		}
	}

	public function getActionBar($request) {
		$buttons = array();
		if (!function_exists('ttsengines_get_all_engines')) {
			return $buttons;
		}
		switch($request['view']) {
			case 'form':
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
			break;
			default:
			break;
		}
		return $buttons;
	}
	public function getRightNav($request) {
		if(!empty($_GET['view']) && $_GET['view'] === 'form'){
			return load_view(__DIR__."/views/rnav.php",[]);
		}
	}
	public function ajaxRequest($command, &$setting) {
		if($command === 'getJSON'){
			return true;
		}
		return false;
	}
	public function ajaxHandler(){
		if($_REQUEST['command'] === 'getJSON' && $_REQUEST['jdata'] === 'grid'){
			return $this->listTTS();
		}
		return false;
	}
}
