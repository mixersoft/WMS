<?php

class Workorder extends AppModel {

	public $hasMany = array('TasksWorkorder', 'AssetsWorkorder');

}