<?php
App::uses('AssetsWorkorder', 'Model');

/**
 * AssetsWorkorder Test Case
 *
 */
class AssetsWorkorderTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.assets_workorder',
		'app.workorder',
		'app.editor',
		'app.tasks_workorder',
		'app.task',
		'app.skill',
		'app.assets_task',
		'app.activity_log'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AssetsWorkorder = ClassRegistry::init('AssetsWorkorder');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AssetsWorkorder);

		parent::tearDown();
	}

/**
 * testGetAll method
 *
 * @return void
 */
	public function testGetAll() {
	}

}
