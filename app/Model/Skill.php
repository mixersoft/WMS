<?php

class Skill extends AppModel {

	public $belongsTo = array('Editor', 'Task');
	/**
	* get all skills for a given editor
	*/
	public function getAll($params = array()) {
		$findParams = array(
			'contain' => array(
				'Editor',
				'Task'=>array(
					// 'TasksWorkorder'
				),
			),		
		);
		$possibleParams = array('id', 'editor_id', 'task_id');
		// if (!empty($params['editor_id'])) {
			// $findParams['contain']['Task']['TasksWorkorder']['conditions'] = array('TasksWorkorder.operator_id'=>$params['editor_id']);
			// unset($params['task_id']);
		// }
		foreach ($possibleParams as $param) {
			if (!empty($params[$param])) {
				$findParams['conditions'][] = array('Skill.' . $param => $params[$param]);
			}
		}
		$skills = $this->find('all', $findParams);
// debug($skills);		
		return $skills;
	}
	
	// /**
	 // * add busy stats to skill tasks 
	 // * @param $skills BY REFERENCE, from  $this->Skill->getAll();
	 // * @param $assigned, from $this->Editor->addAssignedTasks($this->Skill->getAll());
	 // */
	// public function calculateBusyStats(& $editors, $assigned){
// // debug($editors);		
		// foreach ($editors as $i => $row) {
			// if (is_array($row)) {
				// $busy24 = $busy = 0;
				// $isWorkingToday = $row['Editor']['work_week'][date('N')-1];
				// $workday_hours = ($isWorkingToday) ? $row['Editor']['workday_hours'] : 0;
				// $count_assigned = $row['Editor']['editor_tasksworkorders_count'];  // TODO: BUG, this value is not updated by counterCache
				// $tw_rows = $assigned[$row['Editor']['id']];
				// $count_assigned = count($tw_rows);
				// foreach($tw_rows as $j=>$tw) {
					// // filter workorders due in the next 24 hours
					// $busy_time = $tw['TasksWorkorder']['operator_work_time']/3600;
					// $busy += $busy_time;
					// if ($tw['TasksWorkorder']['slack_time'] < 24*3600) {
						// $busy24 += $busy_time;	// in hours
					// }
				// }
				// $editors[$i]['BusyStat'] = array(
					// 'avail_24' => $workday_hours,
					// 'busy_24' => $busy24,
					// 'busy' => $busy,
					// 'slack' =>  ($row['Editor']['workday_hours'] - $busy24) *3600,
					// 'after' => "XXXXX",
					// 'assigned' => $count_assigned
				// );
// 				
			// }
		// }
		// $this->Editor->sortBySlackTime($editors);
		// // debug($editors);	
	// }	
	
}