<?php

class Editor extends AppModel {

	public $hasMany = array(
		'ActivityLog',
		'Skill',
		'TasksWorkorder' => array('foreignKey' => 'operator_id'),
		'Workorder' => array('foreignKey' => 'manager_id'),
	);

	public $displayField = 'username';


	public function getOperatorsList() {
		return $this->find('list', array('conditions' => array('Editor.role' => 'operator')));
	}

}