<?php

class AssetBehavior extends ModelBehavior {


	public function afterFind($Model, $records) {
		$records = $this->addImagesURL($Model, $records);
		return $records;
	}

	/**
	* add asset's URL to the return data;
	*/
	public function addImagesURL($Model, $records) {
		// configure access to PES
		$host_PES = Configure::read('isLocal') ? 'snappi-dev' : 'dev.snaphappi.com';	// move to config file
		Configure::write('host.PES', $host_PES);
		Stagehand::$stage_baseurl = "http://{$host_PES}/svc/STAGING/";
		
		// configure thumbnail preview params
		$size = "lm";
		
		foreach ($records as $i => $record) {
			$asset_id = $record[$Model->alias]['asset_id'];
			$json_src = json_decode($record['Asset']['json_src'], true);
			$records[$i][$Model->alias]['URL'] = Stagehand::getSrc($json_src['root'], $size);
		}
		return $records;
	}

}