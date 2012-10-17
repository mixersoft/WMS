<?php

class Workorder extends AppModel {

	public $hasMany = array('TasksWorkorder', 'AssetsWorkorder', 'ActivityLog');

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
	*
	* Slack time: time remaining to the task due date
	*
	* @return slack time in seconds
	*/
	public function calculateSlackTime($workorder) {
		$sixHours = 60 * 60 * 6;
		return rand (-1 * $sixHours, $sixHours);
	}


	/**
	* function to calculate work time, implementation pending
	*
	* @return work time in seconds
	*/
	public function calculateWorkTime($workorder) {
		return rand(0, 90000);
	}


	/**
	* update the workorder status based ont the status of its tasks
	*
	* rules:
	* Done: if all the tasks are done
	* Working: if at least one of the tasks is working or paused
	* otherwise, do nothing
	*
	* @return true if the status change is made, false otherwise
	*/
	public function updateStatus($id) {
		$tasksWorkorders = $this->TasksWorkorder->find('all', array('conditions' => array('TasksWorkorder.workorder_id' => $id)));
		$countDone = 0;
		foreach ($tasksWorkorders as $tasksWorkorder) {
			switch ($tasksWorkorder['TasksWorkorder']['status']) {
				case 'Working': case 'Paused':
					$newStatus = 'Working';
				break;
				case 'Done':
					$countDone++;
				break;
			}
		}
		if ($countDone != 0  and count($tasksWorkorders) == $countDone) {
			$newStatus = 'Done';
		}
		if (!empty($newStatus)) {
			return $this->save(array('id' => $id, 'status' => $newStatus));
		} else {
			return false;
		}
	}


	/**
	* cancel a Workorder and save an activity log
	*/
	public function cancel($id) {
		$workorder = $this->findById($id);
		if (empty($workorder)) {
			return __('The workorder does not exists');
		} elseif ($workorder['Workorder']['active'] == 0) {
			return __('Workorder already canceled');
		}
		$updated = $this->save(array('id' => $id, 'active' => 0));
		if ($updated) {
			$this->ActivityLog->saveWorkorderCancel($id);
			return true;
		} else {
			return false;
		}
	}

}