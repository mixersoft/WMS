<?php

class EditorsController extends AppController {

	public $scaffold;


	public function beforeFilter() {
		$this->Auth->allow('login');
		return parent::beforeFilter();
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


}