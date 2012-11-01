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
		foreach ($records as $i => & $record) {
			$records[$i]['TasksWorkorder']['work_time'] = $this->calculateWorkTime($record);
			$records[$i]['TasksWorkorder']['slack_time'] = $this->calculateSlackTime($record);
		}
		return $records;
	}


	/**	* get tasksWorkorders, filtered by various params
	*/
	public function getAll($params = array()) {
		$findParams = array(
			'contain' => array('Task',
				'Operator'=>array(
					'Skill'
				),
				'Workorder'=>array(
					'Source',
					'Client',
				)
			),
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
		$tasksWorkorders = $this->removeNotActive($tasksWorkorders);
		return $tasksWorkorders;
	}


	/**
	* function to calculate slack time, implementation pending
	* NOTE: uses result from TasksWorkorder::calculateWorkTime()
	* @return slack time in seconds
	*/
	public function calculateSlackTime(& $tasksWorkorder) {
		$due = strtotime($tasksWorkorder['Workorder']['due']);
		if ($due===false) { // for testing with Workorder.due == null
			$due = Configure::read('testing.workorder_due');
			if (!$due) {
				debug("WARNING: Workorder.due is null, using +3 hours for testing");
				$due = strtotime("+3 hours");
				$tasksWorkorder['Workorder']['due'] = date('Y-m-d H:i:s', $due);
				Configure::write('testing.workorder_due', $due);
			}
		}
		$slack_time = $due - ($tasksWorkorder['TasksWorkorder']['work_time'] + time());
		return $slack_time;
	}


	/**
	* function to calculate work time, implementation pending
	 * @param $tasksWorkorder BY REFERENCE, from #this->getAll()
	* @return work time in seconds
	*/
	public function calculateWorkTime(& $tasksWorkorder) {
		$work_rate = $tasksWorkorder['Task']['target_work_rate'];
		$tasksWorkorder['TasksWorkorder']['target_work_time'] = 3600 *  $tasksWorkorder['TasksWorkorder']['assets_task_count']/$work_rate;
		
		if (!empty($tasksWorkorder['Operator']['Skill'][0]['rate_7_day'])) {
			// operator_work_time
			$work_rate = $tasksWorkorder['Operator']['Skill'][0]['rate_7_day'];
			$tasksWorkorder['TasksWorkorder']['operator_work_time'] = 3600 * $tasksWorkorder['TasksWorkorder']['assets_task_count']/$work_rate;
			return $tasksWorkorder['TasksWorkorder']['operator_work_time'];
		} else $tasksWorkorder['TasksWorkorder']['operator_work_time'] = '';
		return $tasksWorkorder['TasksWorkorder']['target_work_time'];
	}


	/**
	* removes those tasks that belongsTo a workorder not active
	*/
	public function removeNotActive($tasksWorkorders) {
		$ret = array();
		foreach ($tasksWorkorders as $tasksWorkorder) {
			if ($tasksWorkorder['Workorder']['active']) {
				$ret[] = $tasksWorkorder;
			}
		}
		return $ret;
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
		//$tasksWorkorder = $this->find('first', array('conditions' => array('TasksWorkorder.id' => $id), 'contain' => array('Workorder')));
		$tasksWorkorders = $this->getAll(array('id' => $id));
		if (empty($tasksWorkorders)) {
			return __('Task not active or does not exists');
		}
		$tasksWorkorder = $tasksWorkorders[0];
		if ($tasksWorkorder['TasksWorkorder']['operator_id'] != AuthComponent::user('id')) {
			return __('You are not the assigned operator to this task');
		}
		switch ($newStatus) {
			case 'Working':
				if ($tasksWorkorder['TasksWorkorder']['status'] == 'Working') {
					return __('The task already has status Working');
				} elseif ($tasksWorkorder['Workorder']['status'] == 'New') {
					return __('The workorder is not ready to start work');
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
		$dataToSave = array('id' => $id, 'status' => $newStatus);
		switch ($newStatus) {
			case 'Working':
				if (empty($tasksWorkorder['TasksWorkorder']['started'])) {
					$dataToSave['started'] = Configure::read('now');
				}
				//if the task was paused, add the paused time
				if ($tasksWorkorder['TasksWorkorder']['status'] == 'Paused') {
					$pausedTime = strtotime(Configure::read('now')) - strtotime($tasksWorkorder['TasksWorkorder']['paused_at']);
					$totalPausedTime = $tasksWorkorder['TasksWorkorder']['paused'] + $pausedTime;
					$dataToSave['paused'] = $totalPausedTime;
				}
			break;
			case 'Paused';
				$dataToSave['paused_at'] = Configure::read('now');
			break;
			case 'Done':
				$dataToSave['finished'] = Configure::read('now');
				//calculate elapsed time
				$totalTime = strtotime(Configure::read('now')) - strtotime($tasksWorkorder['TasksWorkorder']['started']);
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


	/**
	* reject a task and save an activity log
	*
	* @param int $id TasksWorkorder id
	* @param string $reason the reason why the operator does not accept the Task
	*/
	public function reject($id, $reason) {
		$tasksWorkorder = $this->findById($id);
		if (empty($tasksWorkorder)) {
			return __('The task does not exists');
		} elseif ($tasksWorkorder['TasksWorkorder']['operator_id'] != AuthComponent::user('id')) {
			return __('The tasks is not assigned to you');
		} elseif (empty($reason)) {
			return __('Please provide a reason for the rejection');
		}
		$updated = $this->save(array('id' => $id, 'operator_id' => null));
		if ($updated) {
			$this->ActivityLog->saveRejection('TasksWorkorder', $id, $reason);
			return true;
		} else {
			return false;
		}

	}

}