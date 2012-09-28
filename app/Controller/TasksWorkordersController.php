<?php

class TasksWorkordersController extends AppController {

	public $scaffold;


	public function index() {
		$tasksWorkorders = $this->TasksWorkorder->getAll(array('workorder_id' => 1));
		$this->set(compact('tasksWorkorders'));
		$this->render('/Elements/tasks_workorders/index');
	}


	public function view($id) {
		$tasksWorkorders = $this->TasksWorkorder->getAll(array('id' => $id));
		$this->set(compact('tasksWorkorders'));
		$this->render('/Elements/tasks_workorders/index');
	}


}