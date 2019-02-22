<?php
namespace FreePBX\modules\Tts;
use FreePBX\modules\Backup as Base;
class Backup Extends Base\BackupBase{
	public function runBackup($id,$transaction){
		$this->addDependency('ttsengines');
		$configs = $this->dumpTables();
		$this->addConfigs($configs);
	}
}