<?php
App::uses('Workorder', 'Model');

/**
 * Workorder Test Case
 *
 */
class WorkorderTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
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

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Workorder = ClassRegistry::init('Workorder');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Workorder);

		parent::tearDown();
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
 * testUpdateStatus method
 *
 * @return void
 */
	public function testUpdateStatus() {
	}

/**
 * testCancel method
 *
 * @return void
 */
	public function testCancel() {
	}

/**
 * testReject method
 *
 * @return void
 */
	public function testReject() {
	}

/**
 * testDeliver method
 *
 * @return void
 */
	public function testDeliver() {
	}

}
