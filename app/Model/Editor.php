<?php

class Editor extends AppModel {

	public $hasMany = array(
		'ActivityLog',
		'Skill',
		'TasksWorkorder' => array('foreignKey' => 'operator_id'),
		'Workorder' => array('foreignKey' => 'manager_id'),
	);

	public $displayField = 'username';


	public function afterFind($editors) {
		$editors = $this->calculateStats($editors);
		return $editors;
	}


	public function getAll() {
		return $this->find('all');
	}


	public function calculateStats($editors) {
		foreach ($editors as $i => $editor) {
			if (is_array($editor)) {
				$editors[$i]['Stat'] = array(
					'target' => $this->randValue(),
					'work' => $this->randValue(),
					'day' => $this->randValue(),
					'week' => $this->randValue(),
					'month' => $this->randValue(),
					'avail_24' => $this->randValue(),
					'busy_24' => $this->randValue(),
					'slack' => $this->randValue(),
					'after' => $this->randValue(),
					'assigned' => count($this->TasksWorkorder->assignedTo($editor[$this->alias]['id'])),
				);
			}
		}
		return $editors;
	}


}