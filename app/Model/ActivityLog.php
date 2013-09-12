<?php

class ActivityLog extends AppModel {

	public $belongsTo = array(
		'Editor',
		'Workorder',
		'TasksWorkorder',
	);

	public $hasMany = array(
		'FlagComment' => array('className' => 'ActivityLog', 'foreignKey' => 'flag_id')
	);

	public $order = array('ActivityLog.created' => 'desc', 'ActivityLog.id' => 'desc');

	public $validate = array(
		'comment' => array('rule' => 'notEmpty'),
	);


	public function afterSave($created) {
		$this->updateCacheFields($this->id);
	}

	/**
	 * merge any slack_time values to the activity log row
 		* NOTE: for now assume activity log entries for tasks inherit workorder slacktime if task slacktime not available  
	 * @param $activityLogs aa BY REFERENCE, from ActivityLog->find()
	 * @param $slacktimes aa, from Workorder->getAll() or TasksWorkorder->getAll()
	 */
	public function merge_SlackTime(& $activityLogs, $slacktimes) {
		if (isset($slacktimes[0]['Workorder']['slack_time'])) {
			$model = 'Workorder';
			$lookup['Workorder'] = Set::combine($slacktimes, '/Workorder/id', '/Workorder/slack_time');
// debug($lookup);				
			foreach ($activityLogs as & $activityLog) {
				if (empty($activityLog['ActivityLog']['slack_time']) ) {
					// TODO: assume for now, that TasksWorkorders get Workorder.slack_time in /workorders view
					$activityLogWoid = $activityLog['ActivityLog']['workorder_id'];
					if (isset($lookup[ 'Workorder' ][ $activityLogWoid ]))
						$activityLog['ActivityLog']['slack_time'] = $lookup[ 'Workorder' ][ $activityLogWoid ];
				} 
			}
		} else {
			$model = 'TasksWorkorder'; 
			$lookup['TasksWorkorder'] = Set::combine($slacktimes, '/TasksWorkorder/id', '/TasksWorkorder/slack_time');
// debug($lookup);			
			foreach ($activityLogs as & $activityLog) {
				if (empty($activityLog['ActivityLog']['slack_time']) 
					&& $activityLog['ActivityLog']['model']=='TasksWorkorder'
					&& isset($lookup[ 'TasksWorkorder' ][ $activityLog['ActivityLog']['foreign_key'] ])
				) {
					$activityLog['ActivityLog']['slack_time'] = $lookup[ 'TasksWorkorder' ][ $activityLog['ActivityLog']['foreign_key'] ];
				} else if (!isset($activityLog['ActivityLog']['slack_time']))  $activityLog['ActivityLog']['slack_time'] = '';
			}
		}
		return;
	}

	/**
	* get activity logs filtered by various params
	*/
	public function getAll($params = array()) {
		$findParams = array(
			'fields'=>array('ActivityLog.*'),
			'conditions' => array(
				'ActivityLog.flag_id' => null,
			),
			'contain' => array(
				'Editor'=>array(
					'fields'=>array("`Editor`.`id`", "`Editor`.`username`"),
					'User'=>array('fields'=>'`User`.`src_thumbnail`')
				),
				'FlagComment' => array('Editor'=>array(
						'fields'=>array("`Editor`.`id`", "`Editor`.`username`"),
						'User'=>array('fields'=>'`User`.`src_thumbnail`')
					),
				),	// nested comment on the Flagged Comment, plus Editor details
			),
		);
		$possibleParams = array('id', 'model', 'foreign_key');
		foreach ($possibleParams as $param) {
			if (!empty($params[$param])) {
				$findParams['conditions'][] = array('ActivityLog.' . $param => $params[$param]);
			}
		}
		// add as OR clause
		$possibleParams_OR = array('editor_id','workorder_id', 'tasks_workorder_id');
		foreach ($possibleParams_OR as $param) {
			if (!empty($params[$param])) {
				 $findParams['conditions']['OR']['ActivityLog.' . $param] =  $params[$param];
			}
		}	
			
		$activityLogs = $this->find('all', $findParams);
		return $activityLogs;
	}


	/**
	* update the fields workorder_id and task_workorder_id with are a cache for easy later find
	*/
	public function updateCacheFields($id) {
		$log = $this->findById($id);
		$forSave = array('id' => $id);
		switch ($log['ActivityLog']['model']) {
			case 'Workorder':
				$forSave['workorder_id'] = $log['ActivityLog']['foreign_key'];
			break;
			case 'TasksWorkorder':
				$forSave['tasks_workorder_id'] = $log['ActivityLog']['foreign_key'];
				$task = $this->TasksWorkorder->findById($log['ActivityLog']['foreign_key']);
				$forSave['workorder_id'] = $task['TasksWorkorder']['workorder_id'];
			break;
		}
		return $this->save($forSave, array('callbacks' => false));
	}


	/**
	* log when a task is assigned to an operator
	*/
	public function saveTaskAssigment($taskId, $operatorId) {
		$operator = $this->Editor->findById($operatorId);
		return $this->save(array(
			'id' => null,
			'model' => 'TasksWorkorder',
			'foreign_key' => $taskId,
			'editor_id' => AuthComponent::user('id'),
			'comment' => 'assigned to ' . $operator['Editor']['username']
		));
	}


	/**
	* update the parent's flag status of a recently comment saved.
	*
	* when a comment is made into a flagged or cleared activity log, we must update the
	* flag status of the parent comment.
	*/
	public function updateParentFlag($childrenId, $newFlagStatus) {
		$comment = $this->findById($childrenId);
		return $this->save(array('id' => $comment['ActivityLog']['flag_id'], 'flag_status' => $newFlagStatus));
	}


	/**
	* Log when a task changes the status
	*/
	public function saveTaskStatusChange($taskId, $statusOld, $statusNew) {
		return $this->save(array(
			'id' => null,
			'model' => 'TasksWorkorder',
			'foreign_key' => $taskId,
			'editor_id' => AuthComponent::user('id'),
			'comment' => 'changed the status from ' . $statusOld . ' to ' . $statusNew,
		));
	}


	/**
	* Log when a Workorder changes the status
	*/
	public function saveWorkorderStatusChange($workorderId, $statusOld, $statusNew) {
		return $this->save(array(
			'id' => null,
			'model' => 'Workorder',
			'foreign_key' => $workorderId,
			'editor_id' => AuthComponent::user('id'),
			'comment' => 'changed the status from ' . $statusOld . ' to ' . $statusNew,
		));
	}


	/**
	* Log when a Workorder is canceled
	*/
	public function saveWorkorderCancel($workorderId) {
		return $this->save(array(
			'id' => null,
			'model' => 'Workorder',
			'foreign_key' => $workorderId,
			'editor_id' => AuthComponent::user('id'),
			'comment' => 'workorder canceled',
		));
	}

	/**
	* log when an editor rejects an assigment
	*
	* @param string $model the model with the assigment (Workorder or TasksWorkorder)
	* @param int $foreignKey the id of the record in the model
	* @param string $reason the reason why the editor rejects the assigment
	*/
	public function saveRejection($model, $foreignKey, $reason) {
		if (!in_array($model, array('Workorder', 'TasksWorkorder'))) {
			return false;
		}
		return $this->save(array(
			'id' => null,
			'model' => $model,
			'foreign_key' => $foreignKey,
			'editor_id' => AuthComponent::user('id'),
			'comment' => ($model == 'Workorder' ? 'Workorder' : 'Task') . ' rejected. Reason: ' . $reason,
			'flag_status' => 1,
		));
	}


	/**
	* log workorder delivery
	*/
	public function saveWorkorderDelivery($workorderId) {
		return $this->save(array(
			'id' => null,
			'model' => 'Workorder',
			'foreign_key' => $workorderId,
			'editor_id' => AuthComponent::user('id'),
			'comment' => 'workorder delivered',
		));
	}
	
	/**
	* log sync workorder/tasks_workorder assets
	*/
	public function saveAddAssets($model, $foreignKey, $count) {
		if (!$count) return;
		return $this->save(array(
			'id' => null,
			'model' => $model,
			'foreign_key' => $foreignKey,
			'editor_id' => AuthComponent::user('id'),
			'comment' => "Sync {$model}: {$count} new Snaps added.",
		));
	}
	
}