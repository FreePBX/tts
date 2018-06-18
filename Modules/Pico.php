<?php
namespace FreePBX\modules\Tts\Modules;
class Pico{
    public function __construct(){
        $this->freepbx = \FreePBX::Create();
        $this->astman = $this->freepbx->astman;
    }
}