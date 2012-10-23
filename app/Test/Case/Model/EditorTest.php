<?php
App::uses('Editor', 'Model');

/**
 * Editor Test Case
 *
 */
class EditorTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.editor',
		'app.tasks_workorder',
		'app.workorder',
		'app.assets_workorder',
		'app.activity_log',
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
		$this->Editor = ClassRegistry::init('Editor');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Editor);

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
 * testCalculateStats method
 *
 * @return void
 */
	public function testCalculateStats() {
	}

}
