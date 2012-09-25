<?php

class TasksWorkorder extends AppModel {

	public $belongsTo = array('Workorder', 'Task');

	public $hasMany = array('AssetsTask');

}