<?php

class WorkordersController extends AppController {

	public $scaffold;


	public function beforeFilter() {
		//here check for permissions, operators cannot see actions dashboard and all
		// for operators: ok to see action=all, action=dashboard will redirect to /tasks_workorders/dashboard
	}


	/**
	* Managers dashboard
	*/
	public function dashboard() {
		if (AuthComponent::user('role') == 'operator') {
			$this->redirect(array('controller' => 'tasks_workorders', 'action' => 'dashboard'));
		}
		$workorders = $this->Workorder->getAll(array('manager_id' => AuthComponent::user('id')));
		$activityLogs = $this->ActivityLog->getAll();
		$this->set(compact('workorders', 'activityLogs'));
	}


	/**
	* list of all workorders, filtered by current logged manager
	*/
	public function all() {
		$workorders = $this->Workorder->getAll(array('manager_id' => AuthComponent::user('id')));
		$activityLogs = $this->ActivityLog->getAll();
		$this->set(compact('workorders', 'activityLogs'));
	}


	/**
	* view a single workorders, with all its tasks, activity logs and some assets
	*/
	public function view($id) {
		$workorders = $this->Workorder->getAll(array('id' => $id));
		if (empty($workorders)) {
			throw new NotFoundException();
		}
		$tasksWorkorders = $this->Workorder->TasksWorkorder->getAll(array('workorder_id' => $id));
		$activityLogs = $this->ActivityLog->getAll(array('workorder_id' => $id));
		$assets = $this->Workorder->AssetsWorkorder->getAll(array('workorder_id' => $id));
		$this->set(compact('workorders', 'tasksWorkorders', 'activityLogs', 'assets'));
	}


	/**
	* workorder details, called by ajax
	*/
	public function detail($id) {
		$this->layout = 'ajax';
		$tasksWorkorders = $this->Workorder->TasksWorkorder->getAll(array('workorder_id' => $id));
		$assets = $this->Workorder->AssetsWorkorder->getAll(array('workorder_id' => $id));
		$this->set(compact('tasksWorkorders', 'assets'));
	}


}