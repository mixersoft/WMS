<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

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