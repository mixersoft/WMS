<?php

class WorkordersController extends AppController {

	public $scaffold;


	public function index() {
		$this->set(array(
			'workorders' => $this->Workorder->getAll(array('manager_id' => 4)),
		));
		$this->render('/Elements/workorders/index');
	}


}