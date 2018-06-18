<?php
namespace FreePBX\modules\Tts;
use FreePBX\modules\Backup as Base;
class Backup Extends Base\BackupBase{
  public function runBackup($id,$transaction){
    $configs = $this->FreePBX->Tts->listTTS();
    $this->addDependency('ttsengines');
    $this->addConfigs($configs);
  }
}