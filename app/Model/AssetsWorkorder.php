<?php

class AssetsWorkorder extends AppModel {

	public $belongsTo = array('Workorder');

	public $actsAs = array('Asset');


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
		/**
		 * manual join to get Asset src string
		 */
		$findParams['fields'] = array("`AssetsWorkorder`.*", "`Asset`.json_src");
		$findParams['joins'][] = array(
					'table'=>'`snappi`.assets',
					'alias'=>'Asset',
					'type'=>'LEFT',
					'conditions'=>array(
						'`Asset`.id = `AssetsWorkorder`.asset_id'
					)
		);		
		return $this->find('all', $findParams);
	}

}