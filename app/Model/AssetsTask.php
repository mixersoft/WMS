<?php

class AssetsTask extends AppModel {

	public $belongsTo = array('TasksWorkorder');


	public function getAll($params = array()) {
		$findParams = array('limit' => 6);
		$possibleParams = array('tasks_workorder_id');
		foreach ($possibleParams as $param) {
			if (!empty($params[$param])) {
				$findParams['conditions'][] = array('AssetsTask.' . $param => $params[$param]);
			}
		}
		return $this->find('all', $findParams);
	}


}