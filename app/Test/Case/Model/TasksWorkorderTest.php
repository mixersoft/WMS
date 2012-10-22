<?php
App::uses('TasksWorkorder', 'Model');

/**
 * TasksWorkorder Test Case
 *
 */
class TasksWorkorderTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
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

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->TasksWorkorder = ClassRegistry::init('TasksWorkorder');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->TasksWorkorder);

		parent::tearDown();
	}

/**
 * testAddTimes method
 *
 * @return void
 */
	public function testAddTimes() {
	}

/**
 * testGetAll method
 *
 * @return void
 */
	public function testGetAll() {
	}

/**
 * testCalculateSlackTime method
 *
 * @return void
 */
	public function testCalculateSlackTime() {
	}

/**
 * testCalculateWorkTime method
 *
 * @return void
 */
	public function testCalculateWorkTime() {
	}

/**
 * testRemoveNotActive method
 *
 * @return void
 */
	public function testRemoveNotActive() {
	}

/**
 * testAssign method
 *
 * @return void
 */
	public function testAssign() {
	}

/**
 * testAssignedTo method
 *
 * @return void
 */
	public function testAssignedTo() {
	}

/**
 * testCanChangeStatus method
 *
 * @return void
 */
	public function testCanChangeStatus() {
	}

/**
 * testChangeStatus method
 *
 * @return void
 */
	public function testChangeStatus() {
	}

/**
 * testReject method
 *
 * @return void
 */
	public function testReject() {
	}

}
