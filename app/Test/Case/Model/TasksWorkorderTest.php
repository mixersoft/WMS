<?php
App::uses('TasksWorkorder', 'Model');
App::uses('AuthComponent', 'Controller/Component');
App::uses('CakeSession', 'Model/Datasource');


class TasksWorkorderTest extends CakeTestCase {

	public $fixtures = array(
		'app.tasks_workorder',
		'app.editor',
		'app.workorder',
		'app.assets_workorder',
		'app.activity_log',
		'app.skill',
		'app.task',
		'app.assets_task'
	);


	public function __construct() {
		CakeSession::write('Auth.User', array('id' => 1, 'role' => 'operator', 'username' => 'manager'));
	}


	public function setUp() {
		parent::setUp();
		$this->TasksWorkorder = ClassRegistry::init('TasksWorkorder');
	}


	public function tearDown() {
		unset($this->TasksWorkorder);
		parent::tearDown();
	}


	public function testAddTimes() {
		$tasksWorkorders = $this->TasksWorkorder->addTimes($this->TasksWorkorder->getAll());
		$this->assertArrayHasKey('slack_time', $tasksWorkorders[0]['TasksWorkorder']);
		$this->assertArrayHasKey('work_time', $tasksWorkorders[0]['TasksWorkorder']);

	}


	public function testGetAll() {
		$tasksWorkorders = $this->TasksWorkorder->getAll();
		$this->assertArrayHasKey('TasksWorkorder', $tasksWorkorders[0]);
		$this->assertArrayHasKey('Operator', $tasksWorkorders[0]);
	}


	public function testCalculateSlackTime() {
		$slackTime = $this->TasksWorkorder->calculateSlackTime(1);
		$this->assertTrue(is_integer($slackTime));
	}


	public function testCalculateWorkTime() {
		$workTime = $this->TasksWorkorder->calculateWorkTime(1);
		$this->assertTrue(is_integer($workTime));
	}


	public function testRemoveNotActive() {
		$tasksWorkorders = $this->TasksWorkorder->removeNotActive($this->TasksWorkorder->getAll());
		$ids = Set::extract('{n}.TasksWorkorder.id', $tasksWorkorders);
		$this->assertTrue(in_array(1, $ids));
		$this->assertFalse(in_array(2, $ids));
		$this->assertFalse(in_array(3, $ids));
	}


	public function testAssign() {
		$this->TasksWorkorder->assign(1, 2);
		$tasksWorkorder = $this->TasksWorkorder->findById(1);
		$this->assertEqual($tasksWorkorder['TasksWorkorder']['operator_id'], 2);
	}


	public function testAssignedTo() {
		$tasksWorkorders = $this->TasksWorkorder->assignedTo(1);
		$ids = Set::extract('{n}.TasksWorkorder.id', $tasksWorkorders);
		$this->assertTrue(in_array(1, $ids));
		$this->assertFalse(in_array(2, $ids)); //task assigned to another operator
		$this->assertFalse(in_array(3, $ids)); //task not active
	}


	public function testCanChangeStatus() {
		$result = $this->TasksWorkorder->canChangeStatus(1, 'Working');
		$this->assertEqual('The workorder is not ready to start work', $result);

		$result = $this->TasksWorkorder->canChangeStatus(2, 'Working');
		$this->assertEqual($result, 'Task not active or does not exists');

		$result = $this->TasksWorkorder->canChangeStatus(4, 'Working');
		$this->assertTrue($result);
	}


	public function testChangeStatus() {
		$result = $this->TasksWorkorder->changeStatus(4, 'Working');
		$this->assertTrue($result);
		$tasksWorkorder = $this->TasksWorkorder->findById(4);
		$this->assertEqual($tasksWorkorder['TasksWorkorder']['status'], 'Working');
	}


	public function testReject() {
		$this->TasksWorkorder->reject(1, 'reason');
	}


	public function testGetWithTimes() {
		pr($this->TasksWorkorder->getWithTimes());
	}

}
