<?php

$isLocal = (
	in_array(env('REMOTE_ADDR'), array('127.0.0.1', '::1'))
	or !strpos(env('HTTP_HOST'), 'snaphappi.com')
	or class_exists('ShellDispatcher')
);

$config = array(
	'isLocal' => $isLocal,
	'now' => date('Y-m-d H:i:s'),
	'Config' => array(
		'language' => 'eng'
	),
	'host' => array(
		'PES' =>  env('HTTP_HOST')=='github' ? 'snappi-dev' : 'dev.snaphappi.com',
	),
	'path' => array(
		'default_badges' => array(
			'Asset' => '/static/img/css-gui/snappi.png',
			'Story' => '/static/img/css-gui/snappi.png',
			'Collection' => '/static/img/css-gui/snappi.png',
			'Person' => '/static/img/css-gui/snappi.png',
			'Circle' => '/static/img/css-gui/snappi.png',
			'Group' => '/static/img/css-gui/snappi.png',
			'Event' => '/static/img/css-gui/snappi.png',
			'Wedding' => '/static/img/css-gui/snappi.png',
			'Tag' => '/static/img/css-gui/snappi.png',
		),
	),
);