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
		$options = $this->addTimeStats($findParams);
		$workorders = $this->find('all', $options);
		$workorders = $this->addTimes($workorders);
		return $workorders;
	}




	/**
	* add joins and derived fields to include time calculations, worktime, slacktime, etc.
	* original SQL:
	*	SELECT
	* sum(3600*TasksWorkorder.assets_task_count/Task.target_work_rate) as target_work_time,
	* sum(3600*TasksWorkorder.assets_task_count/coalesce(Skill.rate_7_day,Task.target_work_rate)) as operator_work_time,
	* UNIX_TIMESTAMP(coalesce(Workorder.due, date_add(now(), interval 3 hour))) as workorder_due, -- using coalesce because testdata has Workorder.due==null
	* UNIX_TIMESTAMP(coalesce(Workorder.due, date_add(now(), interval 3 hour))) - sum(3600*TasksWorkorder.assets_task_count/coalesce(Skill.rate_7_day,Task.target_work_rate)) - UNIX_TIMESTAMP(now()) as slack_time,
	*  TasksWorkorder.*
	* FROM workorders AS Workorder
	* JOIN tasks_workorders AS TasksWorkorder ON TasksWorkorder.workorder_id = Workorder.id
	* JOIN tasks AS Task ON Task.id = TasksWorkorder.task_id
	* LEFT JOIN skills AS Skill ON Skill.task_id = TasksWorkorder.task_id and Skill.editor_id = TasksWorkorder.operator_id
	* GROUP BY Workorder.id
	 * @return $options array for Model->find('all', $options); 
	*/
	public function addTimeStats($options) {
		$time_options = array(
			'fields' => array(
				'sum(3600*TasksWorkorder.assets_task_count/Task.target_work_rate) 
					as target_work_time',
				'sum(3600*TasksWorkorder.assets_task_count/coalesce(Skill.rate_7_day,Task.target_work_rate))
					as operator_work_time',
				'UNIX_TIMESTAMP(coalesce(Workorder.due,
				
					 date_add(now(), interval 3 hour)		
					 
					 )) 				
					as workorder_due', 		// testing with coalesce
				'UNIX_TIMESTAMP(
				coalesce(Workorder.due, 
				
					date_add(now(), interval 3 hour)
					
					))
					- sum(3600*TasksWorkorder.assets_task_count/coalesce(Skill.rate_7_day,Task.target_work_rate)) 
					- UNIX_TIMESTAMP(now())
					as slack_time',			// testing with coalesce
			),
			'joins' => array(
				// WARNING : should not mix contains and joins for the same table
				array(
					'table' => 'tasks_workorders', 'alias' => 'TasksWorkorder', 'type' => 'INNER',
					'conditions' => array(
						'Workorder.id = TasksWorkorder.workorder_id'
					),
				),
				array(
					'table' => 'tasks', 'alias' => 'Task', 'type' => 'INNER',
					'conditions' => array(
						'Task.id = TasksWorkorder.task_id'
					),
				),
				array(
					'table' => 'skills', 'alias' => 'Skill', 'type' => 'LEFT',
					'conditions' => array(
						'Skill.task_id = TasksWorkorder.task_id',
						'Skill.editor_id = TasksWorkorder.operator_id',
					),
				),
			),
			'group'=>array('Workorder.id'),
			'order' => array('slack_time'=>'ASC'),
		);
		// merge
		if (empty($options['fields'])) $options['fields'][] = '*';
		$options = Set::merge($options, $time_options);
		return $options;		
	}


	/**
	* add slack_time and work_time as virtual fields from derived values
	*/
	public function addTimes($records) {
		foreach ($records as $i => $record) {
			if ($records[$i][0]['operator_work_time']) {
				$records[$i]['Workorder']['work_time'] = $records[$i][0]['operator_work_time'];
				$records[$i]['Workorder']['operator_work_time'] = $records[$i][0]['operator_work_time'];
			} else {
				$records[$i]['Workorder']['work_time'] = $records[$i][0]['target_work_time'];
				$records[$i]['Workorder']['operator_work_time'] = '';
			}
			$records[$i]['Workorder']['target_work_time'] = $records[$i][0]['target_work_time'];	
			$records[$i]['Workorder']['slack_time'] = $records[$i][0]['slack_time'];
			
			// reformat to match TasksWorkorder nexted Containable result
			$records[$i]['Workorder']['Source'] = & $records[$i]['Source'];
			$records[$i]['Workorder']['Client'] = & $records[$i]['Client'];			
		}
		return $records;
	}


	/**
	 * * @deprecated use  addTimeStats join instead
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
	 * * @deprecated use  addTimeStats join instead
	* function to calculate work time, implementation pending
	 * @param $workorder BY REFERENCE
	* @return work time in seconds
	*/
	public function calculateWorkTime(& $workorder) {
		$wo_id = $workorder['Workorder']['id'];
		$tasksWorkorder = $this->TasksWorkorder->getAll(array('workorder_id'=>$wo_id));
		$operator_work_time = $target_work_time = 0;
		$at_least_one_assigned = false;
		foreach($tasksWorkorder as $i=>$record ) {
			/*
			 * TODO: for now, we assume all Tasks are performed sequentially,
			 * just add TasksWorkorder.work_time. But this should be updated
			 * with a more sophisticated algorithm
			 *
			 */
			$target_work_time += $record['TasksWorkorder']['target_work_time'];
			$operator_work_time += isset($record['TasksWorkorder']['operator_work_time']) ? $record['TasksWorkorder']['operator_work_time'] : $record['TasksWorkorder']['target_work_time'];
			$at_least_one_assigned = $at_least_one_assigned || isset($record['TasksWorkorder']['operator_work_time']);
		}
		$workorder['Workorder']['target_work_time'] = $target_work_time;
		if ($at_least_one_assigned) {
			$workorder['Workorder']['operator_work_time'] = $operator_work_time;
			$workorder['Workorder']['work_time'] = $operator_work_time;
		} else $workorder['Workorder']['work_time'] = $target_work_time;
		return ;
	}


	/**
	* update the workorder status based on the status of its tasks
	* called by TasksWorkorder::changeStatus
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
		
		$allowedUsers = array($workorder['Workorder']['manager_id']) + Set::extract('/TasksWorkorder/operator_id', $tasksWorkorders);
		$hasPermission = in_array(AuthComponent::user('id'), $allowedUsers);
		if (!$hasPermission) return false;
		
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
		} elseif ($workorder['Workorder']['manager_id'] != AuthComponent::user('id')) {
			return __('The workorder is not assigned to you');			
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
		} elseif ($workorder['Workorder']['manager_id'] != AuthComponent::user('id')) {
			return __('The workorder is not assigned to you');			
		} elseif ($workorder['Workorder']['active'] == 0) {
			return __('Workorder not active');
		} elseif ($workorder['Workorder']['status'] == 'Done') {
			return __('Workorder already delivered');
		} elseif ($workorder['Workorder']['status'] != 'QA') {
			return __('Workorder not ready for delivery (must have status QA)');
		}
		$data = array(
			'id' => $id,
			'status' => 'Done',
			'finished' => date('Y-m-d H:i:s'),
			'elapsed' => date('U') - strtotime($workorder['Workorder']['started']),
		);
		$updated = $this->save($data);
		if ($updated) {
			$this->ActivityLog->saveWorkorderDelivery($id);
			return true;
		} else {
			return false;
		}
	}

		
	/**
	 * get Assets/AssetsGroup to add to WorkorderAssets
	 * @param $task_id, FK to Task
	 * @param $woid, FK to Workorder 
	 * @param $filter string [NEW|ALL]
	 */
	 
	public function harvestAssets($data){
		// User: Assets.owner_id = $data['Workorder']['source_id']
		// Group: AssetsGroup.group_id = $data['Workorder']['source_id']
		$SOURCE_MODEL = $data['Workorder']['source_model'];
		$SOURCE_ID = $data['Workorder']['source_id'];
		switch ($SOURCE_MODEL){
			case 'User':
				$options = array(
					'recursive' => -1,
					'conditions'=>array(
						'AssetsWorkorder.asset_id IS NULL',
						'`Asset`.owner_id' => $SOURCE_ID
					)
				);  
				$options['fields'] = array('`Asset`.id AS asset_id');
				$joins[] = array(
					'table'=>'`snappi`.assets',
					'alias'=>'Asset',
					'type'=>'RIGHT',
					'conditions'=>array("`AssetsWorkorder`.asset_id = `Asset`.id"),
				);
				$model_name = 'Asset';
				break;
			case 'Group':
				$options = array(
					'recursive' => -1,
					'conditions'=>array(
						'AssetsWorkorder.asset_id IS NULL',
						'`AssetsGroup`.group_id' => $SOURCE_ID
					)
				);  
				$options['fields'] = array('`AssetsGroup`.asset_id AS asset_id');
				$joins[] = array(
					'table'=>'`snappi`.assets_groups',
					'alias'=>'AssetsGroup',
					'type'=>'RIGHT',
					'conditions'=>array("`AssetsWorkorder`.asset_id = `AssetsGroup`.asset_id"),
				);
				$model_name = 'AssetsGroup';				break;
		}
// ?? add already rated photos? NO, depends on task.
		$options['joins'] = $joins; 
		$data2 = $this->AssetsWorkorder->find('all', $options);
		$assets = Set::extract("/{$model_name}/asset_id", $data2);		
		return $assets;
	}	

	/**
	 * add assets to an existing Workorder, i.e. harvest new photos from Assets/AssetsGroup
	 * @param $data array, from workorder->find('first')
	 * @param $assets, array optional, array of asset Ids 
	 * 		default 'NEW' assets by LEFT JOIN using harvest()
	 */
	public function addAssets($data, $assets = 'NEW'){
		if ($assets == 'NEW') {
			$assets = $this->harvestAssets($data);
		} else if (isset($assets['id'])) {
			$assets = Set::extract("/id", $assets);
		} else if (is_string($assets)) {
			$assets = explode(',', $assets);
		}
		$assetsWorkorder = array();
		$woid = $data['Workorder']['id'];
		foreach ($assets as $aid) {
			if (!$aid) continue;
			$assetsWorkorder[]  = array(
				'workorder_id'=>$woid,
				'asset_id'=>$aid,
			);
		}
		// $data['AssetsWorkorder'] = $assetsWorkorder;
		$count = count($assetsWorkorder);
		if ($count) {
			$ret = $this->AssetsWorkorder->saveAll($assetsWorkorder, array('validate'=>'first'));
			if ($ret) {
				$this->ActivityLog->saveAddAssets('Workorder', $woid, $count);
				$this->resetStatus($woid);
				$this->updateAllCounts();	// TODO: limit update to $woid
			}
			return $ret ? $count : false;
		} else return true;  	// nothing new to add;
	}
	

}