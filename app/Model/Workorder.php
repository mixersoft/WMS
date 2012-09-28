<?php

class Workorder extends AppModel {

	public $hasMany = array('TasksWorkorder', 'AssetsWorkorder');

	public $belongsTo = array(
		'Manager' => array('className' => 'Editor', 'foreignKey' => 'manager_id'),
	);

	public $displayField = 'id';


	public function getAll($params = array()) {
		$defaultParams = array(
			'manager_id' => 'complete later'//AuthComponent::user('id'),
		);
		$params = Set::merge($defaultParams, $params);
		$findParams = array(
			'conditions' => array(
				'Workorder.manager_id' => $params['manager_id'],
				'Workorder.active' => true,
			),
			'contain' => array('Manager'),
		);
		$workorders = $this->find('all', $findParams);
		foreach ($workorders as $i => $workorder) {
			$workorders[$i]['Workorder']['slack_time'] = $this->calculateSlackTime($workorder);
			$workorders[$i]['Workorder']['work_time'] = $this->calculateWorkTime($workorder);
		}
		return $workorders;
	}


	/**
	* function to calculate slack time, implementation pending
	* @return slack time in seconds
	*/
	public function calculateSlackTime($workorder) {
		return rand(0, 9999999);
	}


	/**
	* function to calculate work time, implementation pending
	* @return work time in seconds
	*/
	public function calculateWorkTime($workorder) {
		return rand(0, 90000);
	}

}