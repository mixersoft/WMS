<?php

App::uses('Model', 'Model');

class AppModel extends Model {

	public $recursive = -1;

	public $actsAs = array('Containable');


	public function randValue() {
		return substr(base_convert(uniqid(), 16, 36), -5);
	}

}