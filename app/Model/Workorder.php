<?php

class Workorder extends AppModel {

	public $hasMany = array('TasksWorkorder', 'AssetsWorkorder');

	public $belongsTo = array(
		'Manager' => array('className' => 'Editor', 'foreignKey' => 'manager_id'),
	);

	public $displayField = 'id';


	/**
	* get workorders, filterd by various params
	*/
	public function getAll($params = array()) {
		$findParams = array(
			'conditions' => array('Workorder.active' => true),
			'contain' => array('Manager'),
		);
		$possibleParams = array('id', 'manager_id');
		foreach ($possibleParams as $param) {
			if (!empty($params[$param])) {
				$findParams['conditions'][] = array('Workorder.' . $param => $params[$param]);
			}
		}
		$workorders = $this->find('all', $findParams);
		foreach ($workorders as $i => $workorder) {
			$workorders[$i]['Workorder']['slack_time'] = $this->calculateSlackTime($workorder);
			$workorders[$i]['Workorder']['work_time'] = $this->calculateWorkTime($workorder);
		}
		return $workorders;
	}


	/**
	* function to calculate slack time, implementation pending
	* Slack time: time remaining to the task due date
	* @return slack time in seconds
	*/
	public function calculateSlackTime($workorder) {
		$sixHours = 60 * 60 * 6;
		return rand (-1 * $sixHours, $sixHours);
	}


	/**
	* function to calculate work time, implementation pending
	* @return work time in seconds
	*/
	public function calculateWorkTime($workorder) {
		return rand(0, 90000);
	}


}