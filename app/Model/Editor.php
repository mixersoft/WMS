<?php

class Editor extends AppModel {

	public $hasMany = array(
		'ActivityLog',
		'Skill',
		'TasksWorkorder' => array('foreignKey' => 'operator_id'),
		'Workorder' => array('foreignKey' => 'manager_id'),
	);
	
	public $belongsTo = array(
		// This should be the users table, Alias shoudl change
		'User' => array('foreignKey' => 'user_id', 'className' => 'Client'),
	);

	public $displayField = 'username';


	/**
	* get all editors, it may be more complex in the future
	*/
	public function getAll() {
		$findParams = array(
			'contain' => array(
				'User',
				'TasksWorkorder'=>array('Task'),
				'Skill',
			),		
		);
		$editors = $this->find('all', $findParams);
		$editors = $this->calculateTaskStats($editors);
		return $editors;
	}
	
	public function addAssignedTasks(& $editors) {
		$assignedTasks = array();
		foreach ($editors as $i=>$editor) {
			$editorId = $editor['Editor']['id'];
			$tasks = $this->TasksWorkorder->getAll(array('operator_id' => $editorId));
			$assignedTasks[$editorId] = $tasks;
		}
		$this->calculateBusyStats($editors, $assignedTasks); 
		return $assignedTasks;
	}

	/**
	 * lookup correct skill from an editor's skills array
	 * @param $skills array, from $editor['TasksWorkorder']['Skill']
	 * @param $taskId pk, from  $editor['TasksWorkorder'][0]['task_id']
	 * @return array or false, the correct skill from skills array
	 */
	private function getSkillByTaskId($skills, $taskId) {
		foreach ($skills as $i=>$row){
			if ($row['task_id'] == $taskId) return $row;
		}
		return false;
	}

		
	/**
	* add working stats information to editors
	*/
	public function calculateTaskStats($editors) {
		foreach ($editors as $i => $editor_row) {
			if (is_array($editor_row)) {
				foreach($editor_row['TasksWorkorder'] as $i=>$tw) {
					$target = $tw['Task']['target_work_rate'];
					$skill = $this->getSkillByTaskId($editor_row['Skill'], $tw['task_id']);
					$work = 3600 * $skill['rate_7_day'] / $tw['assets_task_count'];
					$editors[$i]['TaskStat'] = array(
						'target' => $target,
						'work' => $work,
						'day' =>  $skill['rate_1_day'],
						'week' => $skill['rate_7_day'],
						'month' => $skill['rate_30_day'],
					);
				}
			}
		}
		return $editors;
	}
	/**
	 * lookup correct skill from an editor's skills array
	 * @param $taskId pk, from  
	 * @param $assigned array, from Editor::addAssignedTasks()
	 * @return array or false, the correct TasksWorkorder row
	 */
	private function getTaskByTaskId($taskId, $assigned) {
		foreach ($assigned as $i=>$row){
			if ($row['TasksWorkorder']['id'] == $taskId) return $row;
		}
		return false;
	}
	public function calculateBusyStats(& $editors, $assigned){
		foreach ($editors as $i => $editor_row) {
			if (is_array($editor_row)) {
				$busy24 = $busy = 0;
				foreach($editor_row['TasksWorkorder'] as $j=>$tw) {
					$tw_id = $tw['id'];
					$detailed_tw = $this->getTaskByTaskId($tw['id'], $assigned[$tw['operator_id']]);
// debug($detailed_tw)	;				
					// also $detailed_tw['TasksWorkorder'][Operator']['workday_hours']
					// also $detailed_tw['TasksWorkorder'][Operator']['workweek']
					// also $detailed_tw['TasksWorkorder'][Operator']['editor_tasksworkorders_count'] 		// countercache not working
					// also $detailed_tw['TasksWorkorder'][Operator']['Skill']['rate_7_day']
					
					// filter workorders due in the next 24 hours
					$busy_time = $detailed_tw['TasksWorkorder']['operator_work_time']/3600;
					$busy += $busy_time;
					if ($detailed_tw['TasksWorkorder']['slack_time'] < 24*3600) {
						$busy24 += $busy_time;	// in hours
					}
				}
				$editors[$i]['BusyStat'] = array(
					'avail_24' => $editor_row['Editor']['workday_hours'],
					'busy_24' => $busy24,
					'busy' => $busy,
					'slack' =>  ($editor_row['Editor']['workday_hours'] - $busy24) *3600,
					'after' => "XXXXX",
					'assigned' => count($editor_row['TasksWorkorder'])
				);
				
			}
		}
	}

}