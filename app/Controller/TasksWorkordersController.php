<?php

class TasksWorkordersController extends AppController {

	public $scaffold;

	public $belongsTo = array('Operator' => array('className' => 'Editor', 'foreignKey' => 'operator_id'));


	public function all() {
		$tasksWorkorders = $this->TasksWorkorder->getAll();
		$activityLogs = $this->ActivityLog->getAll();
		$operators = $this->Editor->getOperatorsList();
		$this->set(compact('tasksWorkorders', 'activityLogs', 'operators'));
	}


	public function dashboard() {
		//for now, same as ::all
		$tasksWorkorders = $this->TasksWorkorder->getAll();
		$activityLogs = $this->ActivityLog->getAll();
		$operators = $this->Editor->getOperatorsList();
		$this->set(compact('tasksWorkorders', 'activityLogs', 'operators'));
	}


	public function view($id) {
		$tasksWorkorders = $this->TasksWorkorder->getAll(array('id' => $id));
		if (empty($tasksWorkorders)) {
			throw new NotFoundException();
		}
		$activityLogs = $this->ActivityLog->getAll(array('tasks_workorder_id' => $id));
		$assets = $this->TasksWorkorder->AssetsTask->getAll(array('tasks_workorder_id' => $id));
		$this->set(compact('tasksWorkorders', 'activityLogs', 'assets'));
	}


	public function assign($id) {
		if ($this->request->is('post')) {
			$result = $this->TasksWorkorder->assign($id, $this->data['TasksWorkorder']['operator_id']);
			if ($result) {
				$this->Session->setFlash(__('Task successfully assigned'), 'flash_success');
			} else {
				$this->Session->setFlash(__('Error assigning Task'), 'flash_error');
			}
		}
		return $this->redirect($this->referer(array('controller' => 'tasks_workorders', 'action' => 'all')));
	}


	public function detail($id) {
		$this->layout = 'ajax';
		$assets = $this->TasksWorkorder->AssetsTask->getAll(array('tasks_workorder_id' => $id));
		$this->set(compact('assets'));
	}


}