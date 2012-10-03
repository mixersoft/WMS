<?php

class ActivityLog extends AppModel {

	public $belongsTo = array('Editor', 'Workorder', 'TasksWorkorder');

	public $order = array('ActivityLog.created' => 'desc');

	public $validate = array(
		'comment' => array('rule' => 'notEmpty'),
	);


	public function afterSave() {
		$this->updateCacheFields($this->id);
	}


	public function getAll($params = array()) {
		$findParams = array(
			'conditions' => array(),
			'contain' => array('Editor'),
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

}