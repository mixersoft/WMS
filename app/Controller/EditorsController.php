<?php

class EditorsController extends AppController {

	public $scaffold;


	public function beforeFilter() {
		$this->Auth->allow('login');
		return parent::beforeFilter();
	}


	public function login() {
		$this->_hardCodedDebugLogin();

		if (AuthComponent::user('id')) {
			// if role=manager, go to /workorders/dashboard, if role=operator, go to /tasks_workorders/dashboard
			$this->redirect(array('controller' => 'workorders', 'action' => 'dashboard'));
		}

		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(__('Username or password is incorrect'));
			}
		}
	}


	//remove this method after testing
	public function _hardCodedDebugLogin() {
		if (!empty($this->params['named']['editor_id'])) {
			$editor = $this->Editor->findById($this->params['named']['editor_id']);
			if ($editor) {
				$result = $this->Auth->login($editor['Editor']);
				return $this->redirect($this->Auth->redirect());
			}
		}
	}


	public function logout() {
		$this->redirect($this->Auth->logout());
	}


}