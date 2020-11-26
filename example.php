<?php

require 'engine/engine.php';

$URL = 'https://cab-f56-194g0.streamalloha.live/hs/17/1606421550/6wIL0KlUd6Q5C7NRPC2soA/50/11050/';

Master::Setup($URL);

if(Master::GetResolution() && Master::GetFiles()) {
	Master::PrintDebug();
}

if(Master::GetResolution() && Master::GetFiles()) {
	$Target = Master::Get('files');		// 1920x1080
	if(Master::Start($Target[3])) {
		echo "Download - Completed";
	}
}


?>