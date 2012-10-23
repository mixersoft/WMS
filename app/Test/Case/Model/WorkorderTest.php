<?php
App::uses('Workorder', 'Model');
App::uses('AuthComponent', 'Controller/Component');
App::uses('CakeSession', 'Model/Datasource');


class WorkorderTest extends CakeTestCase {


	public $fixtures = array(
		'app.workorder',
		'app.editor',
		'app.tasks_workorder',
		'app.task',
		'app.skill',
		'app.assets_task',
		'app.activity_log',
		'app.assets_workorder'
	);


	public function __construct() {
		CakeSession::write('Auth.User', array('id' => 1, 'role' => 'operator', 'username' => 'manager'));
	}


	public function setUp() {
		parent::setUp();
		$this->Workorder = ClassRegistry::init('Workorder');
	}


	public function tearDown() {
		unset($this->Workorder);
		parent::tearDown();
	}


	public function testGetAll() {
		$workorders = $this->Workorder->getAll();
		$this->assertArrayHasKey('Workorder', $workorders[0]);
		$this->assertArrayHasKey('Manager', $workorders[0]);
	}


	public function testCalculateSlackTime() {
		$slackTime = $this->Workorder->calculateSlackTime(1);
		$this->assertTrue(is_integer($slackTime));
	}


	public function testCalculateWorkTime() {
		$workTime = $this->Workorder->calculateWorkTime(1);
		$this->assertTrue(is_integer($workTime));
	}


	public function testUpdateStatus() {
		$result = $this->Workorder->updateStatus(1);
	}


	public function testCancel() {
		$result = $this->Workorder->cancel(1);
	}


	public function testReject() {
		$result = $this->Workorder->reject(1, 'reason');
	}


	public function testDeliver() {
		$result = $this->Workorder->deliver(1);
	}

}
