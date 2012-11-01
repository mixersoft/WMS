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
	public function getAll($params = array()) {
		$findParams = array(
			'contain' => array(
				'User',
				// 'TasksWorkorder',
				'TasksWorkorder'=>array('Task'),
				'Skill'=>array('Task'),
			),		
		);
		$possibleParams = array('id', 'manager_id', 'task_id');
		if (!empty($params['task_id'])) {
			$findParams['contain']['Skill']['conditions'] = array('Skill.task_id'=>$params['task_id']);
			unset($params['task_id']);
		}
		foreach ($possibleParams as $param) {
			if (!empty($params[$param])) {
				$findParams['conditions'][] = array('Editor.' . $param => $params[$param]);
			}
		}
// debug($findParams);
		$editors = $this->find('all', $findParams);
		return $editors;
	}
	
	/**
	 * add all assigned TasksWorkorders with worktime stats for each Editor to Editor->getAll() results  
	 * @param $editors , 
	 */
	public function addAssignedTasks($editors) {
		$assignedTasks = array();
		foreach ($editors as $i=>$editor) {
			if (empty($editor['Editor'])) continue;
			$editorId = $editor['Editor']['id'];
			$tasks = $this->TasksWorkorder->getAll(array('operator_id' => $editorId));
			$assignedTasks[$editorId] = $tasks;
		}
		// $this->calculateBusyStats($editors, $assignedTasks); 
		return $assignedTasks;
	}

	/**
	 * lookup correct skill from an editor's skills array
	 * @param $skills array, from $editor['TasksWorkorder']['Skill']
	 * @param $taskId pk, from  $editor['TasksWorkorder'][0]['task_id']
	 * @return array or false, the correct skill from skills array
	 */
	public function getSkillByTaskId($skills, $taskId) {
		foreach ($skills as $i=>$row){
			if ($row['task_id'] == $taskId) return $row;
		}
		return false;
	}

		
	/**
	* add skill stats and worktime information to editors for given task
	* @param $editors BY REFERENCE, from  $this->Editor->getAll(array('task_id'=>$taskId));
	 * @param $tasksWorkorder, from $this->TasksWorkorder->getAll(array('id' => $id))
	 * 		uses TasksWorkorder.assets_workorder_count to calculate $worktime
	 *  requires: 'contain' => array( 'Skill', )	
	*/
	public function calculateTaskStats(& $editors, $tasksWorkorder = null) {
// debug($tasksWorkorder);		
		foreach ($editors as $i => $row) {
// debug($row);				
			$tw = $tasksWorkorder ? $tasksWorkorder['TasksWorkorder'] : null;
			$target = $tasksWorkorder['Task']['target_work_rate'];
			// $skill = $this->getSkillByTaskId($row['Skill'], $tw['task_id']);
			$skill = $row['Skill'][0];
			$worktime = 3600 * $tw['assets_task_count'] / $skill['rate_7_day'] ;
			$editors[$i]['TaskStat'] = array(
				'target' => $target,
				'work' => $worktime,
				'day' =>  $skill['rate_1_day'],
				'week' => $skill['rate_7_day'],
				'month' => $skill['rate_30_day'],
			);
		}
// debug(Set::extract('/TaskStat', $editors));
		return ;
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
	
	/**
	 * add busy stats to editors 
	 * requires: 'contain'=>array( 'TasksWorkorder', )
	 * @param $editors BY REFERENCE, from  $this->Editor->getAll();
	 * @param $assigned, from $this->Editor->addAssignedTasks($this->Editor->getAll());
	 */
	public function calculateBusyStats(& $editors, $assigned){
		foreach ($editors as $i => $row) {
			if (is_array($row)) {
				$busy24 = $busy = 0;
				$isWorkingToday = $row['Editor']['work_week'][date('N')-1];
				$workday_hours = ($isWorkingToday) ? $row['Editor']['workday_hours'] : 0;
				$count_assigned = $row['Editor']['editor_tasksworkorders_count'];  // TODO: BUG, this value is not updated by counterCache
				$count_assigned = count($row['TasksWorkorder']);
				foreach($row['TasksWorkorder'] as $j=>$tw) {
					$tw_with_worktime_stats = $this->getTaskByTaskId($tw['id'], $assigned[$row['Editor']['id']]);
					// filter workorders due in the next 24 hours
					$busy_time = $tw_with_worktime_stats['TasksWorkorder']['operator_work_time']/3600;
					$busy += $busy_time;
					if ($tw_with_worktime_stats['TasksWorkorder']['slack_time'] < 24*3600) {
						$busy24 += $busy_time;	// in hours
					}
				}
				$editors[$i]['BusyStat'] = array(
					'avail_24' => $workday_hours,
					'busy_24' => $busy24,
					'busy' => $busy,
					'slack' =>  ($row['Editor']['workday_hours'] - $busy24) *3600,
					'after' => "XXXXX",
					'assigned' => $count_assigned
				);
				
			}
		}
	}

}