<?php

class ActivityLogsController extends AppController {

	public $scaffold;


	/**
	* saves a new activity log in database
	*/
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

	/**
	* list all activity logs
	*/
	public function all() {
		$activityLogs = $this->ActivityLog->getAll();
		
		/*
		 * get/merge slack times for all activity tasks/workorders
		 */
		$workorderIds = array_unique(array_filter(Set::extract('/ActivityLog/workorders_id', $activityLogs))); 
		$tasksWorkorderIds = array_unique(array_filter(Set::extract('/ActivityLog/tasks_workorders_id', $tasksWorkorderIds ))); 
		$tasksWorkorders = $this->ActivityLog->TasksWorkorder->getAll(array('tasks_workorders_id'=>$tasksWorkorderIds));
		$this->ActivityLog->merge_SlackTime($activityLogs, $tasksWorkorders);
		$workorders = $this->ActivityLog->Workorder->getAll(array('workorder_id'=>$workorderIds));
		$this->ActivityLog->merge_SlackTime($activityLogs, $workorders);
		
		$this->set(compact('activityLogs'));
	}


}