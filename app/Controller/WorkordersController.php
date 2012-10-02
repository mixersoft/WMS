<?php

class WorkordersController extends AppController {

	public $scaffold;


	public function dashboard() {
		$workorders = $this->Workorder->getAll(array('manager_id' => 4));
		$this->set(compact('workorders'));
	}


	public function index() {
		$workorders = $this->Workorder->getAll(array('manager_id' => 4));
		$this->set(compact('workorders'));
		$this->render('/Elements/workorders/index');
	}


}