<?php

$isLocal = (
	in_array(env('REMOTE_ADDR'), array('127.0.0.1', '::1'))
	or substr(env('HTTP_HOST'), -4) == '.dev'
	or class_exists('ShellDispatcher')
);

$config = array(
	'isLocal' => $isLocal,
	'host_PES' => $isLocal ? 'snappi-dev' : 'dev.snaphappi.com',
	'now' => date('Y-m-d H:i:s'),
);