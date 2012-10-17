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

	public $order = array('ActivityLog.created' => 'desc');

	public $validate = array(
		'comment' => array('rule' => 'notEmpty'),
	);


	public function afterSave($created) {
		$this->updateCacheFields($this->id);
	}


	/**
	* get activity logs filtered by various params
	*/
	public function getAll($params = array()) {
		$findParams = array(
			'conditions' => array(
				'ActivityLog.flag_id' => null,
			),
			'contain' => array(
				'Editor',
				'FlagComment' => array('Editor'),
			),
		);
		$possibleParams = array('id', 'model', 'foreign_key', 'workorder_id', 'tasks_workorder_id');
		foreach ($possibleParams as $param) {
			if (!empty($params[$param])) {
				$findParams['conditions'][] = array('ActivityLog.' . $param => $params[$param]);
			}
		}
		$activityLogs = $this->find('all', $findParams);
		return $activityLogs;
	}


	/**
	* updae the fields workorder_id and task_workorder_id with are a cache for easy later find
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

}