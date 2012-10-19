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
		$workorder = $this->Workorder->getAll(array('id' => $id));
		$workorder = $workorder[0];
		$tasksWorkorders = $this->Workorder->TasksWorkorder->getAll(array('workorder_id' => $id));
		$assets = $this->Workorder->AssetsWorkorder->getAll(array('workorder_id' => $id));
		$this->set(compact('workorder', 'tasksWorkorders', 'assets'));
	}


	/**
	* cancel a workorder
	*/
	public function cancel($id) {
		$result = $this->Workorder->cancel($id);
		if (is_string($result)) {
			$this->Session->setFlash($result, 'flash_error');
		} elseif ($result === true) {
			$this->Session->setFlash('Workorder cancelled', 'flash_success');
		} else {
			$this->Session->setFlash('Error. Try again', 'flash_error');
		}
		return $this->redirect(array('controller' => 'workorders', 'action' => 'all'));
	}


	/**
	* reject a workorder assigned to the manager
	*/
	public function reject($id) {
		if ($this->request->is('post')) {
			$result = $this->Workorder->reject($id, $this->data['Workorder']['reason']);
			if ($result === true) {
				$this->Session->setFlash('Workorder rejected', 'flash_success');
				return $this->redirect(array('controller' => 'workorders', 'action' => 'all'));
			} elseif (is_string($result)) {
				$this->Session->setFlash($result, 'flash_error');
			} else {
				$this->Session->setFlash('Error. Try again', 'flash_error');
			}
		}
		$workorderId = $id;
		$this->set(compact('workorderId'));
	}


	/**
	* after review, the manager delivers a workorder
	*/
	public function deliver($id) {
		$result = $this->Workorder->deliver($id);
		if (is_string($result)) {
			$this->Session->setFlash($result, 'flash_error');
		} elseif ($result === true) {
			$this->Session->setFlash('Workorder delivered', 'flash_success');
		} else {
			$this->Session->setFlash('Error. Try again', 'flash_error');
		}
		return $this->redirect($this->referer(array('controller' => 'workorders', 'action' => 'view', $id)));
	}

}