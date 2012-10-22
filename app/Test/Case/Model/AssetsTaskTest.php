<?php
App::uses('AssetsTask', 'Model');

/**
 * AssetsTask Test Case
 *
 */
class AssetsTaskTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.assets_task',
		'app.tasks_workorder',
		'app.editor',
		'app.workorder',
		'app.assets_workorder',
		'app.activity_log',
		'app.skill',
		'app.task'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AssetsTask = ClassRegistry::init('AssetsTask');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AssetsTask);

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
