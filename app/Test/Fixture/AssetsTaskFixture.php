<?php
/**
 * AssetsTaskFixture
 *
 */
class AssetsTaskFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'tasks_workorder_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'asset_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'edit_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4, 'comment' => 'for fast access to unedited Assets'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_habtm_join' => array('column' => array('tasks_workorder_id', 'asset_id'), 'unique' => 1),
			'fk_assets' => array('column' => 'asset_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'tasks_workorder_id' => 1,
			'asset_id' => 'Lorem ipsum dolor sit amet',
			'edit_count' => 1,
			'created' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 2,
			'tasks_workorder_id' => 2,
			'asset_id' => 'Lorem ipsum dolor sit amet',
			'edit_count' => 2,
			'created' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 3,
			'tasks_workorder_id' => 3,
			'asset_id' => 'Lorem ipsum dolor sit amet',
			'edit_count' => 3,
			'created' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 4,
			'tasks_workorder_id' => 4,
			'asset_id' => 'Lorem ipsum dolor sit amet',
			'edit_count' => 4,
			'created' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 5,
			'tasks_workorder_id' => 5,
			'asset_id' => 'Lorem ipsum dolor sit amet',
			'edit_count' => 5,
			'created' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 6,
			'tasks_workorder_id' => 6,
			'asset_id' => 'Lorem ipsum dolor sit amet',
			'edit_count' => 6,
			'created' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 7,
			'tasks_workorder_id' => 7,
			'asset_id' => 'Lorem ipsum dolor sit amet',
			'edit_count' => 7,
			'created' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 8,
			'tasks_workorder_id' => 8,
			'asset_id' => 'Lorem ipsum dolor sit amet',
			'edit_count' => 8,
			'created' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 9,
			'tasks_workorder_id' => 9,
			'asset_id' => 'Lorem ipsum dolor sit amet',
			'edit_count' => 9,
			'created' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 10,
			'tasks_workorder_id' => 10,
			'asset_id' => 'Lorem ipsum dolor sit amet',
			'edit_count' => 10,
			'created' => '2012-10-22 11:57:43'
		),
	);

}
