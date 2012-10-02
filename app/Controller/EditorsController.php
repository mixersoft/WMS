<?php

class EditorsController extends AppController {

	public $scaffold;

	public function login() {
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


	public function logout() {
		$this->redirect($this->Auth->logout());
	}

}