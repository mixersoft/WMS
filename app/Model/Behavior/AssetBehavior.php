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
		foreach ($records as $i => $record) {
			$records[$i][$Model->alias]['URL'] = 'http://lorempixel.com/105/70/people/' . rand(1, 10);
		}
		return $records;
	}

}