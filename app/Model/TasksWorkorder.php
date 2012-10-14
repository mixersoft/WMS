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
	* assign a tasksWorkorder to an operator.
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
	* validate if a status change can be done
	* 
	* change status rules:
	* general rules: newStatus is valid AND task exists AND task is active AND the operator has the task assigned
	* Working: task.status != 'Working' AND parent Workorder.status != 'New'
	* Paused: task.status == 'Working'	
	* Done: task.started is not null AND task.status != Done
	* 
	* @return true if the change can be done, otherwise string explaining the reason
	*/
	public function canChangeStatus($id, $newStatus) {
		if (!in_array($newStatus, array('Working', 'Paused', 'Done'))) {
			return __('Status %s not valid', $newStatus);
		}
		$tasksWorkorder = $this->find('first', array('conditions' => array('TasksWorkorder.id' => $id), 'contain' => array('Workorder')));
		if (empty($tasksWorkorder)) {
			return __('Task does not exists');
		} elseif (!$tasksWorkorder['TasksWorkorder']['active']) {
			return __('Tasks not active');
		} elseif ($tasksWorkorder['TasksWorkorder']['operator_id'] != AuthComponent::user('id')) {
			return __('You are not the assigned operator to this task');
		}
		switch ($newStatus) {
			case 'Working':
				if ($tasksWorkorder['TasksWorkorder']['status'] == 'Working') {
					return __('The task already has status Working');
				} elseif ($tasksWorkorder['Workorder']['status'] == 'New') {
					return __('The workoerder is not ready to start work');
				}
			break;
			case 'Paused':
				if ($tasksWorkorder['TasksWorkorder']['status'] != 'Working') {
					return __('You cannot pause the task because it is not in status Working');
				}
			break;
			case 'Done':
				if (empty($tasksWorkorder['TasksWorkorder']['started'])) {
					return __('This task was never started');
				} elseif ($tasksWorkorder['TasksWorkorder']['status'] == 'Done') {
					return __('The task already has the Status done');
				}
			break;
		}
		return true;
	}


	/**
	* change the satus in a task
	* 
	* @return true if the status change was done, string if error, false if error with database
	*/
	public function changeStatus($id, $newStatus) {
		$canChangeStatus = $this->canChangeStatus($id, $newStatus);
		if (is_string($canChangeStatus)) {
			return $canChangeStatus;
		}
		$tasksWorkorder = $this->find('first', array('conditions' => array('TasksWorkorder.id' => $id), 'contain' => array('Workorder')));
		define('NOW', date('Y-m-d H:i:s'));
		$dataToSave = array('id' => $id, 'status' => $newStatus);
		switch ($newStatus) {
			case 'Working':
				if (empty($tasksWorkorder['TasksWorkorder']['started'])) {
					$dataToSave['started'] = NOW;
				} 
				//if the task was paused, add the paused time
				if ($tasksWorkorder['TasksWorkorder']['status'] == 'Paused') {
					$pausedTime = strtotime(NOW) - strtotime($tasksWorkorder['TasksWorkorder']['paused_at']);
					$totalPausedTime = $tasksWorkorder['TasksWorkorder']['paused'] + $pausedTime;
					$dataToSave['paused'] = $totalPausedTime;
				}
			break;
			case 'Paused';
				$dataToSave['paused_at'] = NOW;
			break;
			case 'Done':
				$dataToSave['finished'] = NOW;
				//calculate elapsed time
				$totalTime = strtotime(NOW) - strtotime($tasksWorkorder['TasksWorkorder']['started']);
				$totalWorkingTime = $totalTime - $tasksWorkorder['TasksWorkorder']['paused'];
				$dataToSave['elapsed'] = $totalWorkingTime;
			break;
		}
		if ($this->save($dataToSave)) {
			$this->ActivityLog->saveTaskStatusChange($id, $tasksWorkorder['TasksWorkorder']['status'], $newStatus);
			$this->Workorder->updateStatus($tasksWorkorder['TasksWorkorder']['workorder_id']);
			return true;
		} else {
			return false;
		}
	}
	

}