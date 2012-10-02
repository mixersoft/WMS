<?php

class ActivityLog extends AppModel {

	public $belongsTo = array('Editor');


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
		/*foreach ($workorders as $i => $workorder) {
			$workorders[$i]['Workorder']['slack_time'] = $this->calculateSlackTime($workorder);
			$workorders[$i]['Workorder']['work_time'] = $this->calculateWorkTime($workorder);
		}*/
		return $activityLogs;

	}

}