<?php

class EditorsController extends AppController {

	public $scaffold;


	public function beforeFilter() {
		$this->Auth->allow('login');
		parent::beforeFilter();
		
		$host_PES = Configure::read('host.PES');
		Stagehand::$stage_baseurl = "http://{$host_PES}/svc/STAGING/";
		Stagehand::$badge_baseurl = "http://{$host_PES}/";
		Stagehand::$default_badges = Configure::read('path.default_badges');
		
		//here check for permissions, operators cannot see actions dashboard and all
		// for operators: ok to see action=all, action=dashboard will redirect to /tasks_workorders/dashboard
	}


	/**
	* Login method
	*/
	public function login() {
		$this->_hardCodedDebugLogin();

		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('Username or password is incorrect'));
			}
		}

		if (AuthComponent::user('id')) {
			$redirectController = (AuthComponent::user('role') == 'manager') ? 'workorders' : 'tasks_workorders';
			$this->redirect(array('controller' => $redirectController, 'action' => 'dashboard'));
		}

	}


	/**
	* method for debug testing login. Remove before put in production mode
	*/
	public function _hardCodedDebugLogin() {
		if (!empty($this->params['named']['editor_id'])) {
			$editor = $this->Editor->findById($this->params['named']['editor_id']);
			if ($editor) {
				$result = $this->Auth->login($editor['Editor']);
				return $this->redirect($this->Auth->redirect());
			}
		}
	}

	/**
	*  Logout method
	*/
	public function logout() {
		$this->redirect($this->Auth->logout());
	}


	/**
	* list of editors
	*/
	public function all() {
		$editors = $this->Editor->getAll();
		$assignedTasks = array();
		foreach ($editors as $editor) {
			$editorId = $editor['Editor']['id'];
			$tasks = $this->Editor->TasksWorkorder->getAll(array('operator_id' => $editorId));
			$assignedTasks[$editorId] = $tasks;
		}
		$host_PES = Configure::read('host.PES');
		$size='sq';
		$this->set(compact('editors', 'assignedTasks', 'size', 'host_PES'));
	}


}