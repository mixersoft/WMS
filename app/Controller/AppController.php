<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

	public $uses = array('ActivityLog');

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
		'DebugKit.Toolbar'
	);


}