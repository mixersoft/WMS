<?php

class TasksWorkorder extends AppModel {

	public $belongsTo = array(
		'Workorder',
		'Task',
		'Operator' => array('className' => 'Editor', 'foreignKey' => 'operator_id'),
	);

	public $hasMany = array('AssetsTask', 'ActivityLog');


	public function addTimes($records) {
		foreach ($records as $i => $record) {
			$records[$i]['TasksWorkorder']['slack_time'] = $this->calculateSlackTime($record);
			$records[$i]['TasksWorkorder']['work_time'] = $this->calculateWorkTime($record);
		}
		return $records;
	}


	public function getAll($params = array()) {
		$findParams = array(
			'contain' => array('Operator', 'Task'),
			'conditions' => array('TasksWorkorder.active' => 1),
		);
		$possibleParams = array('id', 'workorder_id', 'operator_id');
		foreach ($possibleParams as $param) {
			if (!empty($params[$param])) {
				$findParams['conditions'][] = array('TasksWorkorder.' . $param => $params[$param]);
			}
		}
		$tasksWorkorders = $this->find('all', $findParams);
		$tasksWorkorders = $this->addTimes($tasksWorkorders);
		return $tasksWorkorders;
	}


	/**
	* function to calculate slack time, implementation pending
	* @return slack time in seconds
	*/
	public function calculateSlackTime($tasksWorkorder) {
		return rand(0, 9999999);
	}


	/**
	* function to calculate work time, implementation pending
	* @return work time in seconds
	*/
	public function calculateWorkTime($tasksWorkorder) {
		return rand(0, 90000);
	}


	public function assign($id, $operatorId) {
		$task = $this->findById($id);
		if (!$task or !$operatorId or !empty($task['TasksWorkorder']['operator_id'])) {
			return false;
		}
		$saved = $this->save(array('id' => $id, 'operator_id' => $operatorId));
		if (!$saved) {
			return false;
		}
		$this->ActivityLog->saveTaskAssigment($id, $operatorId);
		return true;
	}

}