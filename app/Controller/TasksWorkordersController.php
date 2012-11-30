<?php

class TasksWorkordersController extends AppController {

	public $scaffold;

	public $belongsTo = array('Operator' => array('className' => 'Editor', 'foreignKey' => 'operator_id'));

	public function beforeFilter() {
		parent::beforeFilter();
		$host_PES = Configure::read('host.PES');
		Stagehand::$stage_baseurl = "http://{$host_PES}/svc/STAGING/";
		Stagehand::$badge_baseurl = "http://{$host_PES}/";
		Stagehand::$default_badges = Configure::read('path.default_badges');

		//here check for permissions, operators cannot see actions dashboard and all
		// for operators: ok to see action=all, action=dashboard will redirect to /tasks_workorders/dashboard
	}
	/**
	* List all tasks.
	*
	* In the future, the list will be filtered by user role and user permissions.
	*/
	public function all() {
		$tasksWorkorders = $this->TasksWorkorder->getAll();
		// show activity for TasksWorkorders on current page
		$visibleTasksWorkorders = array_unique(Set::extract('/TasksWorkorder/id', $tasksWorkorders));
		$activityLogs = $this->ActivityLog->getAll(array('tasks_workorder_id'=>$visibleTasksWorkorders));		
		$this->ActivityLog->merge_SlackTime($activityLogs, $tasksWorkorders);
		$this->set(compact('tasksWorkorders', 'activityLogs'));
	}


	/**
	* Dashboard for operators
	*
	* for now is the same as TasksWorkordersController::all(), but in the future it will be different
	*/
	public function dashboard() {
		$tasksWorkorders = $this->TasksWorkorder->getAll(array('operator_id' => AuthComponent::user('id')));
		$tasksWorkorderIds = Set::extract('/TasksWorkorder/id', $tasksWorkorders);		
		$activityLogs = $this->ActivityLog->getAll(array(
			'editor_id' => AuthComponent::user('id'),
			'tasks_workorder_id' => $tasksWorkorderIds,
		));
		$this->ActivityLog->merge_SlackTime($activityLogs, $tasksWorkorders);
		
		/*
		 * get/merge slack times for all activity tasks/workorders
		 */
		$workorderIds = array_unique(array_filter(Set::extract('/ActivityLog/workorders_id', $activityLogs))); 
		$new_twids = array_diff(Set::extract('/ActivityLog/tasks_workorders_id', $tasksWorkorderIds ), $tasksWorkorderIds);
		$tasksWorkorderIds = array_unique(array_filter($new_twids)); 
		$tasksWorkorders = $this->ActivityLog->TasksWorkorder->getAll(array('tasks_workorders_id'=>$tasksWorkorderIds));
		$this->ActivityLog->merge_SlackTime($activityLogs, $tasksWorkorders);
		$workorders = $this->ActivityLog->Workorder->getAll(array('workorder_id'=>$workorderIds));
		$this->ActivityLog->merge_SlackTime($activityLogs, $workorders);
		
				
		$this->set(compact('tasksWorkorders', 'activityLogs'));
	}


	/**
	* View a single task_workorder
	*/
	public function view($id) {
		$tasksWorkorders = $this->TasksWorkorder->getAll(array('id' => $id));
		if (empty($tasksWorkorders)) {
			throw new NotFoundException();
		}
		// for /element/PES_preview
		$workorder = & $tasksWorkorders[0]['Workorder'];
		$activityLogs = $this->ActivityLog->getAll(array('tasks_workorder_id' => $id));
		$assets = $this->TasksWorkorder->AssetsTask->getAll(array('tasks_workorder_id' => $id));
		$this->set(compact('tasksWorkorders', 'activityLogs', 'assets', 'workorder'));
	}


	/**
	* view a task and show all operators with stats with the goal to assign a task
	*/
	public function assignments($id) {
		$tasksWorkorders = $this->TasksWorkorder->getAll(array('id' => $id));
		if (empty($tasksWorkorders)) {
			throw new NotFoundException();
		}
		$tasksWorkorder = & $tasksWorkorders[0];
		// NOTE: Workorder from Containable does not call calculateWorkTime
		$workorders = $this->TasksWorkorder->Workorder->getAll(array('id' => $tasksWorkorder['TasksWorkorder']['workorder_id']));
		$workorder = & $workorders[0];
		$assets = $this->TasksWorkorder->AssetsTask->getAll(array('tasks_workorder_id' => $id));

		// get operators with the matching skill for task
		$taskId = $tasksWorkorder['Task']['id'];
		$operators = $this->Editor->getAll(array('task_id'=>$taskId));
		$this->Editor->calculateTaskStats($operators, $tasksWorkorder);

		// get skills by Editor.id for the given task from the Skills Containable results
		$skills = array();
		foreach ($operators as $operator) {
			$skills[$operator['Editor']['id']] = $this->Editor->getSkillByTaskId($operator['Skill'], $taskId);
		}
		$assignedTasks = $this->Editor->addAssignedTasks($operators);
		$this->Editor->calculateBusyStats($operators, $assignedTasks);
		$this->set(compact('tasksWorkorder', 'tasksWorkorders', 'assets', 'workorder', 'workorders', 'operators', 'skills'));
	}


	/**
	* assign a task to an operator and redirect to the previous page
	*/
	public function assign($id, $operatorId) {
		$result = $this->TasksWorkorder->assign($id, $operatorId);
		if ($result) {
			$this->Session->setFlash(__('Task successfully assigned'), 'flash_success');
		} else {
			$this->Session->setFlash(__('Error assigning Task'), 'flash_error');
		}
		return $this->redirect($this->referer(array('controller' => 'tasks_workorders', 'action' => 'all')));
	}


	/**
	* list of tasks assigned to an operator, called by ajax
	*/
	public function assigned_to($operatorId) {
		$this->layout = 'ajax';
		$tasksWorkorders = $this->TasksWorkorder->assignedTo($operatorId);
		$this->set(compact('tasksWorkorders'));
	}


	/**
	* task_workorder detail, called by ajax
	*/
	public function detail($id) {
		$this->layout = 'ajax';
		$tasksWorkorders = $this->TasksWorkorder->getAll(array('id' => $id));
		if (empty($tasksWorkorders)) {
			throw new NotFoundException();
		}
		$tasksWorkorder = & $tasksWorkorders[0];
		$workorder = & $tasksWorkorders[0]['Workorder'];
		$assets = $this->TasksWorkorder->AssetsTask->getAll(array('tasks_workorder_id' => $id));
		$this->set(compact('assets', 'tasksWorkorder', 'workorder'));
	}


	/**
	* change the status of a task
	*/
	public function change_status($id, $newStatus) {
		$result = $this->TasksWorkorder->changeStatus($id, $newStatus);
		if (is_string($result)) {
			$this->Session->setFlash($result, 'flash_error');
		} if ($result === true) {
			$this->Session->setFlash(__('Task %s', $newStatus), 'flash_success');
		} elseif ($result === false) {
			$this->Session->setFlash(__('Error, please try again'), 'flash_error');
		}
		return $this->redirect($this->referer(array('controller' => 'tasks_workorders', 'action' => 'all')));
	}


	/**
	* reject a task assigned to the operator
	*/
	public function reject($id) {
		if ($this->request->is('post')) {
			$result = $this->TasksWorkorder->reject($id, $this->data['TasksWorkorder']['reason']);
			if ($result === true) {
				$this->Session->setFlash('Task rejected', 'flash_success');
				return $this->redirect(array('controller' => 'tasks_workorders', 'action' => 'all'));
			} elseif (is_string($result)) {
				$this->Session->setFlash($result, 'flash_error');
			} else {
				$this->Session->setFlash('Error. Try again', 'flash_error');
			}
		}
		$taskWorkorderId = $id;
		$this->set(compact('taskWorkorderId'));
	}

	/**
	 * harvest new Assets to existing workorder
	 */
	function harvest() {
		if (empty($this->data)) {
			throw new Exception("Error: HTTP POST required", 1);
		} else {
			// debug($this->data);
			// return;		}

		//TODO: add TasksWorkorder.in_batches Boolean. better field name??? realtime? 
		// to specify if new Assets should be added as a NEW TasksWorkorder for same Task
		$add_to_new_tasks_workorder = !empty($this->data['add_to_new_tasks_workorder']);	// default false
		$NEW_assets = $this->TasksWorkorder->harvestAssets($this->data['TasksWorkorder']['task_id'], $this->data['Workorder']['id'], 'NEW');
		// NEW assets found, create NEW TasksWorkorder for NEW assets (realtime wo processing)
		if ($add_to_new_tasks_workorder) {
			$options = array(
				'recursive'=>-1,
				'conditions'=>array('`TasksWorkorder`.id'=>$this->data['TasksWorkorder']['id']),
				'fields'=>array('`TasksWorkorder`.workorder_id', '`TasksWorkorder`.task_id', '`TasksWorkorder`.task_sort')
			);
			$data = $this->TasksWorkorder->find('first', $options);
			$taskWorkorder = $this->TasksWorkorder->createNew($data);
			$count = $this->TasksWorkorder->addAssets($this->data, $NEW_assets);
			if (!$count) throw new Exception("Error adding new Assets to AssetsTasks, twoid={$id}", 1);
		} else { // add NEW Assets to existing TasksWorkorder
			$count = $this->TasksWorkorder->addAssets($this->data, $NEW_assets);
			if (!$count) throw new Exception("Error harvesting new Assets to AssetsTasks, twoid={$id}", 1);
		}
		
		/**
		 * should offer switch to add to TasksWorkorders in batches or not 
		 */
		$this->Session->setFlash(is_numeric($count) ? $count : 0 ." new Snaps found.");
		$this->redirect(env('HTTP_REFERER'), null, true);
		// $this->render('/elements/sql_dump');
	}	
	
	/**
	 * image_group
	 * calls PES /workorders/image_group for workorder or tasksWorkorder
	 * then show workorders/shots/
	 */

}