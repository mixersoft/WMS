<?php

class TasksWorkorder extends AppModel {

	public $belongsTo = array(
		'Workorder',
		'Task',
		'Operator' => array('className' => 'Editor', 'foreignKey' => 'operator_id'),
	);

	public $hasMany = array('AssetsTask', 'ActivityLog');


	/**
	* add slack_time and work_time as virtual fields
	*/
	public function addTimes($records) {
		foreach ($records as $i => $record) {
			$records[$i]['TasksWorkorder']['slack_time'] = $this->calculateSlackTime($record);
			$records[$i]['TasksWorkorder']['work_time'] = $this->calculateWorkTime($record);
		}
		return $records;
	}


	/**
	* get tasksWorkorders, filtered by various params
	*/
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
		$sixHours = 60 * 60 * 6;
		return rand (-1 * $sixHours, $sixHours);
	}


	/**
	* function to calculate work time, implementation pending
	* @return work time in seconds
	*/
	public function calculateWorkTime($tasksWorkorder) {
		return rand(0, 90000);
	}


	/**
	* assign a taskWorkorder to an operator.
	*/
	public function assign($id, $operatorId) {
		$task = $this->findById($id);
		if (!$task or !$operatorId or $operatorId == $task['TasksWorkorder']['operator_id']) {
			return false;
		}
		$saved = $this->save(array('id' => $id, 'operator_id' => $operatorId));
		if (!$saved) {
			return false;
		}
		$this->ActivityLog->saveTaskAssigment($id, $operatorId);
		return true;
	}


	/**
	* get tasks assigned to an Operator
	*/
	public function assignedTo($operatorId) {
		return $this->getAll(array('operator_id' => $operatorId));
	}


	/**
	* start work in the task
	* 
	* you can start working if:
	* task status != Working AND operator has the task assigned AND parent Workorder status != New AND task is active
	*/
	public function startWork($id) {
		$tasksWorkorder = $this->find('first', array(
			'conditions' => array('TasksWorkorder.id' => $id),
			'contain' => array('Workorder'),
		));
		if (!$tasksWorkorder['TasksWorkorder']['active']) {
			return 'task-not-active';
		} elseif ($tasksWorkorder['TasksWorkorder']['operator_id'] != AuthComponent::user('id')) {
			return 'operator-not-allowed';
		} elseif ($tasksWorkorder['TasksWorkorder']['status'] == 'Working') {
			return 'already-working';
		} elseif ($tasksWorkorder['Workorder']['status'] == 'New') {
			return 'workorder-not-ready';
		}
		$dataToSave = array('id' => $id, 'status' => 'Working');
		if (empty($tasksWorkorder['TasksWorkorder']['started'])) {
			$dataToSave['started'] = date('Y-m-d H:i:s');
		}
		if ($this->save($dataToSave)) {
			$this->ActivityLog->saveTaskStatusChange($id, $tasksWorkorder['TasksWorkorder']['status'], 'Working');
			return true;
		} else {
			return false;
		}
	}


	public function pause($id) {

	}


}