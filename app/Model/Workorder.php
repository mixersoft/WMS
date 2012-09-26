<?php

class Workorder extends AppModel {

	public $hasMany = array('TasksWorkorder', 'AssetsWorkorder');

	public $belongsTo = array(
		'Manager' => array('className' => 'Editor', 'foreignKey' => 'manager_id'),
	);


	public function getAll($params = array()) {
		$defaultParams = array(
			'manager_id' => 'complete later'//AuthComponent::user('id'),
		);
		$params = Set::merge($defaultParams, $params);
		$findParams = array(
			'conditions' => array(
				'Workorder.manager_id' => $params['manager_id'],
			),
		);
		return $this->find('all', $findParams);
	}

}