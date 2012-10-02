<?php

class ActivityLogsController extends AppController {

	public $scaffold;


	public function add() {
		if ($this->request->is('post')) {
			if ($this->ActivityLog->save($this->request->data)) {
				$this->Session->setFlash('Comment saved', 'flash_success');
			} else {
				$this->Session->setFlash('Error saving comment. Try again', 'flash_error');
			}
		}
		$this->redirect($this->referer('/'));
	}

}