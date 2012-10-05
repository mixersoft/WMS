<?php

class ActivityLogsController extends AppController {

	public $scaffold;


	public function add() {
		if ($this->request->is('post')) {
			if ($this->ActivityLog->save($this->request->data)) {
				$this->Session->setFlash('Comment saved', 'flash_success');
				if (array_key_exists('parent_flag_status', $this->request->data['ActivityLog'])) {
					$this->ActivityLog->updateParentFlag($this->ActivityLog->id, $this->request->data['ActivityLog']['parent_flag_status']);
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