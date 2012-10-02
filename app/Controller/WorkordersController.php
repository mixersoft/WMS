<?php

class WorkordersController extends AppController {

	public $scaffold;


	public function dashboard() {
		$workorders = $this->Workorder->getAll(array('manager_id' => AuthComponent::user('id')));
		$this->set(compact('workorders'));
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