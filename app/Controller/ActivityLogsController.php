<?php

class ActivityLogsController extends AppController {

	public $scaffold;


	public function add() {
		if ($this->request->is('post')) {
			if ($this->ActivityLog->save($this->request->data)) {
				$this->Session->setFlash('Comment saved', 'flash_success');
				if (!empty($this->request->data['ActivityLog']['clear_flag'])) {
					$this->ActivityLog->clearFlag($this->ActivityLog->id);
				}
			} else {
				$this->Session->setFlash('Error saving comment. Try again', 'flash_error');
			}
		}
		$this->redirect($this->referer('/'));
	}


	public function all() {
		$activityLogs = $this->ActivityLog->getAll();
		$this->set(compact('activityLogs'));
	}


}