<?php

class Workorder extends AppModel {

	public $hasMany = array('TasksWorkorder', 'AssetsWorkorder', 'ActivityLog');

	public $belongsTo = array(
		'Manager' => array('className' => 'Editor', 'foreignKey' => 'manager_id'),
		'Client' => array('foreignKey' => 'client_id'),
		'Source' => array('foreignKey' => 'source_id'),			// NOTE: this only works because we use UUID for Users/Groups, otherwise we need to join with source_model
	);

	public $displayField = 'id';


	/**
	* get workorders, filterd by various params
	*/
	public function getAll($params = array()) {
		
		$findParams = array(
			'conditions' => array('Workorder.active' => true),
			'contain' => array('Manager', 
				'Source', 
				'Client',
			),		
		);
		$possibleParams = array('id', 'manager_id');
		foreach ($possibleParams as $param) {
			if (!empty($params[$param])) {
				$findParams['conditions'][] = array('Workorder.' . $param => $params[$param]);
			}
		}
		
		$workorders = $this->find('all', $findParams);
		foreach ($workorders as $i => & $workorder) {
			$workorders[$i]['Workorder']['work_time'] = $this->calculateWorkTime($workorder);
			$workorders[$i]['Workorder']['slack_time'] = $this->calculateSlackTime($workorder);
			// reformat to match TasksWorkorder nexted Containable result
			$workorders[$i]['Workorder']['Source'] = & $workorders[$i]['Source'];
			$workorders[$i]['Workorder']['Client'] = & $workorders[$i]['Client'];
		}
		return $workorders;
	}


	/**
	* function to calculate slack time, implementation pending
	*
	* Slack time: time remaining to the task due date
	* NOTE: uses result from TasksWorkorder::calculateWorkTime()
	* @return slack time in seconds
	*/
	public function calculateSlackTime($workorder) {
		$due = strtotime($workorder['Workorder']['due']);
		if ($due===false) {	// for testing with Workorder.due == null
			$due = Configure::read('testing.workorder_due');
			if (!$due) {
				debug("WARNING: Workorder.due is null, using +3 hours for testing");
				$due = strtotime("+3 hours");
				$workorder['Workorder']['due'] = date('Y-m-d H:i:s', $due);
				Configure::write('testing.workorder_due', $due);
			}
		}
		$slack = $due - ($workorder['Workorder']['work_time'] + time());
		return $slack;
	}


	/**
	* function to calculate work time, implementation pending
	* 
	* @return work time in seconds
	*/
	public function calculateWorkTime(& $workorder) {
		$wo_id = $workorder['Workorder']['id'];
		$tasksWorkorder = $this->TasksWorkorder->getAll(array('workorder_id'=>$wo_id));
		$worktime = 0;
		foreach($tasksWorkorder as $i=>$record ) {
			/*
			 * TODO: for now, we assume all Tasks are performed sequentially, 
			 * just add TasksWorkorder.work_time. But this should be updated
			 * with a more sophisticated algorithm
			 * 
			 */ 
			$worktime += $record['TasksWorkorder']['work_time'];
		}
		$workorder['Workorder']['work_time'] = $worktime;
		return $worktime;
	}


	/**
	* update the workorder status based ont the status of its tasks
	*
	* rules:
	* QA: if all the tasks are done
	* Working: if at least one of the tasks is working or paused
	* otherwise, do nothing
	*
	* @return true if the status change is made, false otherwise
	*/
	public function updateStatus($id) {
		$workorder = $this->findById($id);
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
			$newStatus = 'QA';
		}
		if (!empty($newStatus) and $newStatus != $workorder['Workorder']['status']) {
			$this->ActivityLog->saveWorkorderStatusChange($id, $workorder['Workorder']['status'], $newStatus);
			$dataToSave = array('id' => $id, 'status' => $newStatus);
			if (empty($workorder['Workorder']['started'])) {
				$dataToSave['started'] = Configure::read('now');
			}
			return $this->save($dataToSave);
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

	/**
	* reject a workorder and save an activity log
	*
	* @param int $id Workorder id
	* @param string $reason the reason why the manager does not accept the Workorder
	*/
	public function reject($id, $reason) {
		$workorder = $this->findById($id);
		if (empty($workorder)) {
			return __('The workorder does not exists');
		} elseif ($workorder['Workorder']['manager_id'] != AuthComponent::user('id')) {
			return __('The workorder is not assigned to you');
		} elseif (empty($reason)) {
			return __('Please provide a reason for the rejection');
		}
		$updated = $this->save(array('id' => $id, 'manager_id' => null));
		if ($updated) {
			$this->ActivityLog->saveRejection('Workorder', $id, $reason);
			return true;
		} else {
			return false;
		}

	}


	/**
	* deliver a workorder and log the delivery
	*/
	public function deliver($id) {
		$workorder = $this->findById($id);
		if (empty($workorder)) {
			return __('The workorder does not exists');
		} elseif ($workorder['Workorder']['active'] == 0) {
			return __('Workorder not active');
		} elseif ($workorder['Workorder']['status'] == 'Done') {
			return __('Workorder already delivered');
		} elseif ($workorder['Workorder']['status'] != 'QA') {
			return __('Workorder not ready for delivery (must have status QA)');
		}
		$updated = $this->save(array('id' => $id, 'status' => 'Done'));
		if ($updated) {
			$this->ActivityLog->saveWorkorderDelivery($id);
			return true;
		} else {
			return false;
		}
	}


}