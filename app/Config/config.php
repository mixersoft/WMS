<?php

$isLocal = (
	in_array(env('REMOTE_ADDR'), array('127.0.0.1', '::1'))
	or substr(env('HTTP_HOST'), -4) == '.dev'
	or class_exists('ShellDispatcher')
);

$config = array(
	'isLocal' => $isLocal,
	'debug' => $isLocal ? 2 : 2,
	'Error' => array(
		'handler' => 'ErrorHandler::handleError',
		'level' => E_ALL & ~E_DEPRECATED,
		'trace' => true
	),
	'Exception' => array(
		'handler' => 'ErrorHandler::handleException',
		'renderer' => 'ExceptionRenderer',
		'log' => true
	),
	'App.encoding' => 'UTF-8',
	'Session' => array(
		'defaults' => 'php'
	),
	'Security' => array(
		'level' => 'medium',
		'salt' => '559csfneabpchbaapfpci914d21ab41e3a3da0b9f',
		'cipherSeed' => '0685919657453555424966736845',
	),
	'Acl' => array(
		'classname' => 'DbAcl',
		'database' => 'default',
	),
	'host_PES' => $isLocal ? 'snappi-dev' : 'dev.snaphappi.com',
);