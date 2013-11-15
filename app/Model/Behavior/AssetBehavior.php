<?php

class AssetBehavior extends ModelBehavior {


	public function afterFind(Model $Model, $records, $primary = false) {
		$records = $this->addImagesURL($Model, $records);
		return $records;
	}

	/**
	* add asset's URL to the return data;
	*/
	public function addImagesURL($Model, $records) {
		if (!isset($records[0]['Asset']['json_src'])) return $records;
		// configure access to PES
		if (Stagehand::$stage_baseurl === null) {
			$host_PES = Configure::read('host.PES');
			Stagehand::$stage_baseurl = "http://{$host_PES}/svc/STAGING/";
			Stagehand::$badge_baseurl = "http://{$host_PES}/";
			Stagehand::$default_badges = Configure::read('path.default_badges');
		}
		$size = "lm";
		foreach ($records as $i => $record) {
			$asset_id = $record[$Model->alias]['asset_id'];
			$json_src = json_decode($record['Asset']['json_src'], true);
			$records[$i][$Model->alias]['URL'] = Stagehand::getSrc($json_src['root'], $size, 'Asset');
		}
		return $records;
	}

}