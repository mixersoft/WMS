<?php
/**
 * TasksWorkorderFixture
 *
 */
class TasksWorkorderFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'uuid' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'comment' => 'legacy field for ETL, ignore', 'charset' => 'utf8'),
		'workorder_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'task_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'task_sort' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 5),
		'operator_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index', 'comment' => 'Operator assignment, references Editor.id'),
		'status' => array('type' => 'string', 'null' => true, 'default' => 'New', 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'assets_task_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'started' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'finished' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'elapsed' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'total working time, in seconds'),
		'paused_at' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'paused' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'time the task was paused, in seconds'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_operator_id' => array('column' => 'operator_id', 'unique' => 0),
			'fk_habtm_join' => array('column' => array('workorder_id', 'task_id'), 'unique' => 0)
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
			'workorder_id' => 1,
			'task_id' => 1,
			'task_sort' => 1,
			'operator_id' => 1,
			'status' => 'Lorem ip',
			'assets_task_count' => 1,
			'started' => '2012-10-22 11:57:43',
			'finished' => '2012-10-22 11:57:43',
			'elapsed' => 1,
			'paused_at' => '2012-10-22 11:57:43',
			'paused' => 1,
			'active' => 1,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 2,
			'uuid' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 2,
			'task_id' => 2,
			'task_sort' => 2,
			'operator_id' => 2,
			'status' => 'Lorem ip',
			'assets_task_count' => 2,
			'started' => '2012-10-22 11:57:43',
			'finished' => '2012-10-22 11:57:43',
			'elapsed' => 2,
			'paused_at' => '2012-10-22 11:57:43',
			'paused' => 2,
			'active' => 1,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 3,
			'uuid' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 3,
			'task_id' => 3,
			'task_sort' => 3,
			'operator_id' => 3,
			'status' => 'Lorem ip',
			'assets_task_count' => 3,
			'started' => '2012-10-22 11:57:43',
			'finished' => '2012-10-22 11:57:43',
			'elapsed' => 3,
			'paused_at' => '2012-10-22 11:57:43',
			'paused' => 3,
			'active' => 1,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 4,
			'uuid' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 4,
			'task_id' => 4,
			'task_sort' => 4,
			'operator_id' => 4,
			'status' => 'Lorem ip',
			'assets_task_count' => 4,
			'started' => '2012-10-22 11:57:43',
			'finished' => '2012-10-22 11:57:43',
			'elapsed' => 4,
			'paused_at' => '2012-10-22 11:57:43',
			'paused' => 4,
			'active' => 1,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 5,
			'uuid' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 5,
			'task_id' => 5,
			'task_sort' => 5,
			'operator_id' => 5,
			'status' => 'Lorem ip',
			'assets_task_count' => 5,
			'started' => '2012-10-22 11:57:43',
			'finished' => '2012-10-22 11:57:43',
			'elapsed' => 5,
			'paused_at' => '2012-10-22 11:57:43',
			'paused' => 5,
			'active' => 1,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 6,
			'uuid' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 6,
			'task_id' => 6,
			'task_sort' => 6,
			'operator_id' => 6,
			'status' => 'Lorem ip',
			'assets_task_count' => 6,
			'started' => '2012-10-22 11:57:43',
			'finished' => '2012-10-22 11:57:43',
			'elapsed' => 6,
			'paused_at' => '2012-10-22 11:57:43',
			'paused' => 6,
			'active' => 1,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 7,
			'uuid' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 7,
			'task_id' => 7,
			'task_sort' => 7,
			'operator_id' => 7,
			'status' => 'Lorem ip',
			'assets_task_count' => 7,
			'started' => '2012-10-22 11:57:43',
			'finished' => '2012-10-22 11:57:43',
			'elapsed' => 7,
			'paused_at' => '2012-10-22 11:57:43',
			'paused' => 7,
			'active' => 1,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 8,
			'uuid' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 8,
			'task_id' => 8,
			'task_sort' => 8,
			'operator_id' => 8,
			'status' => 'Lorem ip',
			'assets_task_count' => 8,
			'started' => '2012-10-22 11:57:43',
			'finished' => '2012-10-22 11:57:43',
			'elapsed' => 8,
			'paused_at' => '2012-10-22 11:57:43',
			'paused' => 8,
			'active' => 1,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 9,
			'uuid' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 9,
			'task_id' => 9,
			'task_sort' => 9,
			'operator_id' => 9,
			'status' => 'Lorem ip',
			'assets_task_count' => 9,
			'started' => '2012-10-22 11:57:43',
			'finished' => '2012-10-22 11:57:43',
			'elapsed' => 9,
			'paused_at' => '2012-10-22 11:57:43',
			'paused' => 9,
			'active' => 1,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 10,
			'uuid' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 10,
			'task_id' => 10,
			'task_sort' => 10,
			'operator_id' => 10,
			'status' => 'Lorem ip',
			'assets_task_count' => 10,
			'started' => '2012-10-22 11:57:43',
			'finished' => '2012-10-22 11:57:43',
			'elapsed' => 10,
			'paused_at' => '2012-10-22 11:57:43',
			'paused' => 10,
			'active' => 1,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
	);

}
