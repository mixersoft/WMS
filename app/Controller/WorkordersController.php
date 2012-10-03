<?php

class WorkordersController extends AppController {

	public $scaffold;


	public function beforeFilter() {
		//here check for permissions, operators cannot see actions dashboard and all
		// for operators: ok to see action=all, action=dashboard will redirect to /tasks_workorders/dashboard
	}


	public function dashboard() {
		$workorders = $this->Workorder->getAll(array('manager_id' => AuthComponent::user('id')));
		$activityLogs = $this->ActivityLog->getAll();
		$this->set(compact('workorders', 'activityLogs'));
	}


	public function all() {
		$workorders = $this->Workorder->getAll(array('manager_id' => AuthComponent::user('id')));
		$activityLogs = $this->ActivityLog->getAll();
		$this->set(compact('workorders', 'activityLogs'));
	}


	public function view($id) {
		$workorders = $this->Workorder->getAll(array('id' => $id));
		if (empty($workorders)) {
			throw new NotFoundException();
		}
		$tasksWorkorders = $this->Workorder->TasksWorkorder->getAll(array('workorder_id' => $id));
		$activityLogs = $this->ActivityLog->getAll(array('workorder_id' => $id));
		$this->set(compact('workorders', 'tasksWorkorders', 'activityLogs'));
	}



}