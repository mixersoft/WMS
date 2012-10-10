<?php

App::uses('Model', 'Model');

class AppModel extends Model {

	public $recursive = -1;

	public $actsAs = array('Containable');


	/**
	* return a random string
	*
	* used to fill with dummy data some values that are not calculated yet.
	*/
	public function randValue() {
		return substr(base_convert(uniqid(), 16, 36), -5);
	}

}