<?php
/**
 * EditorFixture
 *
 */
class EditorFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'user_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'comment' => 'foreign key to snappi.users table, Editor belongsTo User', 'charset' => 'utf8'),
		'username' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'password' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'role' => array('type' => 'string', 'null' => false, 'default' => 'operator', 'length' => 10, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'work_week' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 7, 'collate' => 'utf8_unicode_ci', 'comment' => 'each position of the string represents from monday to sunday, ie, works all days: 1111111, works monday to friday: 1111100, works weekends: 0000011, works only tuesdays and sundays: 0100001', 'charset' => 'utf8'),
		'workday_hours' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '4,2', 'comment' => 'hours per day they are scheduled to work'),
		'editor_tasksworkorders_count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'editor_assetstasks_count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'user_id' => 'Lorem ipsum dolor sit amet',
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role' => 'Lorem ip',
			'work_week' => 'Lorem',
			'workday_hours' => 1,
			'editor_tasksworkorders_count' => 1,
			'editor_assetstasks_count' => 1,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 2,
			'user_id' => 'Lorem ipsum dolor sit amet',
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role' => 'Lorem ip',
			'work_week' => 'Lorem',
			'workday_hours' => 2,
			'editor_tasksworkorders_count' => 2,
			'editor_assetstasks_count' => 2,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 3,
			'user_id' => 'Lorem ipsum dolor sit amet',
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role' => 'Lorem ip',
			'work_week' => 'Lorem',
			'workday_hours' => 3,
			'editor_tasksworkorders_count' => 3,
			'editor_assetstasks_count' => 3,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 4,
			'user_id' => 'Lorem ipsum dolor sit amet',
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role' => 'Lorem ip',
			'work_week' => 'Lorem',
			'workday_hours' => 4,
			'editor_tasksworkorders_count' => 4,
			'editor_assetstasks_count' => 4,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 5,
			'user_id' => 'Lorem ipsum dolor sit amet',
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role' => 'Lorem ip',
			'work_week' => 'Lorem',
			'workday_hours' => 5,
			'editor_tasksworkorders_count' => 5,
			'editor_assetstasks_count' => 5,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 6,
			'user_id' => 'Lorem ipsum dolor sit amet',
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role' => 'Lorem ip',
			'work_week' => 'Lorem',
			'workday_hours' => 6,
			'editor_tasksworkorders_count' => 6,
			'editor_assetstasks_count' => 6,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 7,
			'user_id' => 'Lorem ipsum dolor sit amet',
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role' => 'Lorem ip',
			'work_week' => 'Lorem',
			'workday_hours' => 7,
			'editor_tasksworkorders_count' => 7,
			'editor_assetstasks_count' => 7,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 8,
			'user_id' => 'Lorem ipsum dolor sit amet',
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role' => 'Lorem ip',
			'work_week' => 'Lorem',
			'workday_hours' => 8,
			'editor_tasksworkorders_count' => 8,
			'editor_assetstasks_count' => 8,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 9,
			'user_id' => 'Lorem ipsum dolor sit amet',
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role' => 'Lorem ip',
			'work_week' => 'Lorem',
			'workday_hours' => 9,
			'editor_tasksworkorders_count' => 9,
			'editor_assetstasks_count' => 9,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
		array(
			'id' => 10,
			'user_id' => 'Lorem ipsum dolor sit amet',
			'username' => 'Lorem ipsum dolor sit amet',
			'password' => 'Lorem ipsum dolor sit amet',
			'role' => 'Lorem ip',
			'work_week' => 'Lorem',
			'workday_hours' => 10,
			'editor_tasksworkorders_count' => 10,
			'editor_assetstasks_count' => 10,
			'created' => '2012-10-22 11:57:43',
			'modified' => '2012-10-22 11:57:43'
		),
	);

}
