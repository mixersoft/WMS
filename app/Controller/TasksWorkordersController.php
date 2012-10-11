<?php

class TasksWorkordersController extends AppController {

	public $scaffold;

	public $belongsTo = array('Operator' => array('className' => 'Editor', 'foreignKey' => 'operator_id'));


	/**
	* List all tasks.
	*
	* In the future, the list will be filtered by user role and user permissions.
	*/
	public function all() {
		$tasksWorkorders = $this->TasksWorkorder->getAll();
		$activityLogs = $this->ActivityLog->getAll();
		$this->set(compact('tasksWorkorders', 'activityLogs'));
	}


	/**
	* Dashboard for operators
	*
	* for now is the same as TasksWorkordersController::all(), but in the future it will be different
	*/
	public function dashboard() {
		$tasksWorkorders = $this->TasksWorkorder->getAll();
		$activityLogs = $this->ActivityLog->getAll();
		$this->set(compact('tasksWorkorders', 'activityLogs'));
	}


	/**
	* View a single task_workorder
	*/
	public function view($id) {
		$tasksWorkorders = $this->TasksWorkorder->getAll(array('id' => $id));
		if (empty($tasksWorkorders)) {
			throw new NotFoundException();
		}
		$activityLogs = $this->ActivityLog->getAll(array('tasks_workorder_id' => $id));
		$assets = $this->TasksWorkorder->AssetsTask->getAll(array('tasks_workorder_id' => $id));
		$this->set(compact('tasksWorkorders', 'activityLogs', 'assets'));
	}


	/**
	* view a task and show all operators with stats with the goal to assign a task
	*/
	public function assignments($id) {
		$tasksWorkorders = $this->TasksWorkorder->getAll(array('id' => $id));
		if (empty($tasksWorkorders)) {
			throw new NotFoundException();
		}
		$assets = $this->TasksWorkorder->AssetsTask->getAll(array('tasks_workorder_id' => $id));
		$workorders = $this->TasksWorkorder->Workorder->getAll(array('id' => $tasksWorkorders[0]['TasksWorkorder']['workorder_id']));
		$operators = $this->Editor->getAll();
		$this->set(compact('tasksWorkorders', 'assets', 'workorders', 'operators'));
	}


	/**
	* assign a task to an operator and redirect to the previous page
	*/
	public function assign($id, $operatorId) {
		$result = $this->TasksWorkorder->assign($id, $operatorId);
		if ($result) {
			$this->Session->setFlash(__('Task successfully assigned'), 'flash_success');
		} else {
			$this->Session->setFlash(__('Error assigning Task'), 'flash_error');
		}
		return $this->redirect($this->referer(array('controller' => 'tasks_workorders', 'action' => 'all')));
	}


	/**
	* list of tasks assigned to an operator, called by ajax
	*/
	public function assigned_to($operatorId) {
		$this->layout = 'ajax';
		$tasksWorkorders = $this->TasksWorkorder->assignedTo($operatorId);
		$this->set(compact('tasksWorkorders'));
	}


	/**
	* task_workorder detail, called by ajax
	*/
	public function detail($id) {
		$this->layout = 'ajax';
		$assets = $this->TasksWorkorder->AssetsTask->getAll(array('tasks_workorder_id' => $id));
		$this->set(compact('assets'));
	}



	/**
	* start working on a task
	*/
	public function start($id) {
		$result = $this->TasksWorkorder->startWork($id);
		if ($result === true) {
			$this->Session->setFlash('Task working', 'flash_success');
		} else {
			switch ($result) {
				default:
					$this->Session->setFlash($result, 'flash_error');
				break;
			}
		}
		return $this->redirect($this->referer(array('controller' => 'tasks_workorders', 'action' => 'all')));
	}


}