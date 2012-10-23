<?php
App::uses('ActivityLog', 'Model');

/**
 * ActivityLog Test Case
 *
 */
class ActivityLogTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.activity_log',
		'app.editor',
		'app.tasks_workorder',
		'app.workorder',
		'app.assets_workorder',
		'app.task',
		'app.skill',
		'app.assets_task'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ActivityLog = ClassRegistry::init('ActivityLog');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ActivityLog);

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
 * testUpdateCacheFields method
 *
 * @return void
 */
	public function testUpdateCacheFields() {
	}

/**
 * testSaveTaskAssigment method
 *
 * @return void
 */
	public function testSaveTaskAssigment() {
	}

/**
 * testUpdateParentFlag method
 *
 * @return void
 */
	public function testUpdateParentFlag() {
	}

/**
 * testSaveTaskStatusChange method
 *
 * @return void
 */
	public function testSaveTaskStatusChange() {
	}

/**
 * testSaveWorkorderStatusChange method
 *
 * @return void
 */
	public function testSaveWorkorderStatusChange() {
	}

/**
 * testSaveWorkorderCancel method
 *
 * @return void
 */
	public function testSaveWorkorderCancel() {
	}

/**
 * testSaveRejection method
 *
 * @return void
 */
	public function testSaveRejection() {
	}

/**
 * testSaveWorkorderDelivery method
 *
 * @return void
 */
	public function testSaveWorkorderDelivery() {
	}

}
