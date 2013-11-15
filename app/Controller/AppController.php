<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

	public $uses = array('ActivityLog', 'Editor');

	public $helpers = array('Html', 'Form', 'Time');

	public $components = array(
		'Session',
		'Auth' => array(
    		'authenticate' => array(
    			'Form' => array('userModel' => 'Editor'),
    		),
			'loginAction' => array(
				'controller' => 'editors',
				'action' => 'login',
			),
		),
		// 'DebugKit.Toolbar'
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		$host_PES = Configure::read('host.PES');
		Stagehand::$stage_baseurl = "http://{$host_PES}/svc/STAGING/";
		Stagehand::$badge_baseurl = "http://{$host_PES}/";
		Stagehand::$default_badges = Configure::read('path.default_badges');		
	}


}