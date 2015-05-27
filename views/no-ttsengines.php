<?php
$danger = array(
	sprintf(_('Please install the TTS Engines module via %s or run `fwconsole ma install ttsengines` from the CLI`'),'<a href="config.php?display=modules">Module Admin</a>')
);
echo generate_message_banner(_('TTS Engines Not Installed'), 'danger', $danger);
