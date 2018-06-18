<?php
namespace FreePBX\modules\Tts;
use FreePBX\modules\Backup as Base;
class Restore Extends Base\RestoreBase{
  public function runRestore($jobid){
    $configs = $this->getConfigs();
    foreach ($configs as $tts) {
        $this->FreePBX->Tts->add($tts['name'], $tts['text'], $tts['goto'], $tts['engine']);
    }
  }
}