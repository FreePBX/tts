<?php
namespace FreePBX\modules\Tts\Modules;
class Txt2wave{
    public function __construct(){
        $this->freepbx = \FreePBX::Create();
        $this->astman = $this->freepbx->astman;
    }
}