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

  public function processLegacy($pdo, $data, $tables, $unknownTables, $tmpfiledir){
    $tables = array_flip($tables+$unknownTables);
    if(!isset(tables['tts'])){
      return $this;
    }
    $bmo = $this->FreePBX->Tts;
    $bmo->setDatabase($pdo);
    $bmo->listTTS();
    $bmo->resetDatabase();
    foreach ($configs as $tts) {
      $bmo->add($tts['name'], $tts['text'], $tts['goto'], $tts['engine']);
    }
    return $this;
  }

}