<?php

class TasksWorkordersController extends AppController {

	public $scaffold;


	public function all() {
		$tasksWorkorders = $this->TasksWorkorder->getAll();
		$activityLogs = $this->ActivityLog->getAll();
		$this->set(compact('tasksWorkorders', 'activityLogs'));
	}


	public function view($id) {
		$tasksWorkorders = $this->TasksWorkorder->getAll(array('id' => $id));
		if (empty($tasksWorkorders)) {
			throw new NotFoundException();
		}
		$activityLogs = $this->ActivityLog->getAll(array('tasks_workorder_id' => $id));
		$this->set(compact('tasksWorkorders', 'activityLogs'));
	}


}