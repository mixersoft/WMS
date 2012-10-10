<?php

class AssetsWorkorder extends AppModel {

	public $belongsTo = array('Workorder');


	/**
	* get assets, maybe filtered by workorder
	*/
	public function getAll($params = array()) {
		$findParams = array('limit' => 6);
		$possibleParams = array('workorder_id');
		foreach ($possibleParams as $param) {
			if (!empty($params[$param])) {
				$findParams['conditions'][] = array('AssetsWorkorder.' . $param => $params[$param]);
			}
		}
		return $this->find('all', $findParams);
	}

}