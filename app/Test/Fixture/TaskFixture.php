<?php
/**
 * TaskFixture
 *
 */
class TaskFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'uuid' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'comment' => 'legacy field for ETL, ignore', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1000, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'target_work_rate' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '9,2'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'uuid' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'target_work_rate' => 1,
			'created' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 2,
			'uuid' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'target_work_rate' => 2,
			'created' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 3,
			'uuid' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'target_work_rate' => 3,
			'created' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 4,
			'uuid' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'target_work_rate' => 4,
			'created' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 5,
			'uuid' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'target_work_rate' => 5,
			'created' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 6,
			'uuid' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'target_work_rate' => 6,
			'created' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 7,
			'uuid' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'target_work_rate' => 7,
			'created' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 8,
			'uuid' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'target_work_rate' => 8,
			'created' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 9,
			'uuid' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'target_work_rate' => 9,
			'created' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 10,
			'uuid' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'target_work_rate' => 10,
			'created' => '2012-10-22 11:57:43'
		),
	);

}
