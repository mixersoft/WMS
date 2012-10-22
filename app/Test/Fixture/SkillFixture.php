<?php
/**
 * SkillFixture
 *
 */
class SkillFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'editor_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'task_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'rate_1_day' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '9,2'),
		'rate_7_day' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '9,2'),
		'rate_30_day' => array('type' => 'float', 'null' => false, 'default' => '0.00', 'length' => '9,2'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_habtm_join' => array('column' => array('editor_id', 'task_id'), 'unique' => 0)
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
			'editor_id' => 1,
			'task_id' => 1,
			'rate_1_day' => 1,
			'rate_7_day' => 1,
			'rate_30_day' => 1,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 2,
			'editor_id' => 2,
			'task_id' => 2,
			'rate_1_day' => 2,
			'rate_7_day' => 2,
			'rate_30_day' => 2,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 3,
			'editor_id' => 3,
			'task_id' => 3,
			'rate_1_day' => 3,
			'rate_7_day' => 3,
			'rate_30_day' => 3,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 4,
			'editor_id' => 4,
			'task_id' => 4,
			'rate_1_day' => 4,
			'rate_7_day' => 4,
			'rate_30_day' => 4,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 5,
			'editor_id' => 5,
			'task_id' => 5,
			'rate_1_day' => 5,
			'rate_7_day' => 5,
			'rate_30_day' => 5,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 6,
			'editor_id' => 6,
			'task_id' => 6,
			'rate_1_day' => 6,
			'rate_7_day' => 6,
			'rate_30_day' => 6,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 7,
			'editor_id' => 7,
			'task_id' => 7,
			'rate_1_day' => 7,
			'rate_7_day' => 7,
			'rate_30_day' => 7,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 8,
			'editor_id' => 8,
			'task_id' => 8,
			'rate_1_day' => 8,
			'rate_7_day' => 8,
			'rate_30_day' => 8,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 9,
			'editor_id' => 9,
			'task_id' => 9,
			'rate_1_day' => 9,
			'rate_7_day' => 9,
			'rate_30_day' => 9,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 10,
			'editor_id' => 10,
			'task_id' => 10,
			'rate_1_day' => 10,
			'rate_7_day' => 10,
			'rate_30_day' => 10,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
	);

}
