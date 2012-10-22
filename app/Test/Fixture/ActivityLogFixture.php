<?php
/**
 * ActivityLogFixture
 *
 */
class ActivityLogFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'editor_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'comment' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'model' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'foreign_key' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_unicode_ci', 'comment' => 'either a UUID, or int primary key', 'charset' => 'utf8'),
		'workorder_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'for Activity Log group by workorder'),
		'tasks_workorder_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'for Activity Log group by tasks_workorder'),
		'flag_status' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => 'raised=1, cleared=0, no flag=NULL'),
		'flag_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index', 'comment' => 'self referencing field, references activity_logs.id'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_editor' => array('column' => 'editor_id', 'unique' => 0),
			'fk_target' => array('column' => array('model', 'foreign_key'), 'unique' => 0),
			'fk_flag_id' => array('column' => 'flag_id', 'unique' => 0)
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
			'editor_id' => 1,
			'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 1,
			'tasks_workorder_id' => 1,
			'flag_status' => 1,
			'flag_id' => 1,
			'created' => '2012-10-22 11:57:42'
		),
		array(
			'id' => 2,
			'editor_id' => 2,
			'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 2,
			'tasks_workorder_id' => 2,
			'flag_status' => 1,
			'flag_id' => 2,
			'created' => '2012-10-22 11:57:42'
		),
		array(
			'id' => 3,
			'editor_id' => 3,
			'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 3,
			'tasks_workorder_id' => 3,
			'flag_status' => 1,
			'flag_id' => 3,
			'created' => '2012-10-22 11:57:42'
		),
		array(
			'id' => 4,
			'editor_id' => 4,
			'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 4,
			'tasks_workorder_id' => 4,
			'flag_status' => 1,
			'flag_id' => 4,
			'created' => '2012-10-22 11:57:42'
		),
		array(
			'id' => 5,
			'editor_id' => 5,
			'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 5,
			'tasks_workorder_id' => 5,
			'flag_status' => 1,
			'flag_id' => 5,
			'created' => '2012-10-22 11:57:42'
		),
		array(
			'id' => 6,
			'editor_id' => 6,
			'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 6,
			'tasks_workorder_id' => 6,
			'flag_status' => 1,
			'flag_id' => 6,
			'created' => '2012-10-22 11:57:42'
		),
		array(
			'id' => 7,
			'editor_id' => 7,
			'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 7,
			'tasks_workorder_id' => 7,
			'flag_status' => 1,
			'flag_id' => 7,
			'created' => '2012-10-22 11:57:42'
		),
		array(
			'id' => 8,
			'editor_id' => 8,
			'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 8,
			'tasks_workorder_id' => 8,
			'flag_status' => 1,
			'flag_id' => 8,
			'created' => '2012-10-22 11:57:42'
		),
		array(
			'id' => 9,
			'editor_id' => 9,
			'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 9,
			'tasks_workorder_id' => 9,
			'flag_status' => 1,
			'flag_id' => 9,
			'created' => '2012-10-22 11:57:42'
		),
		array(
			'id' => 10,
			'editor_id' => 10,
			'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'model' => 'Lorem ipsum dolor sit amet',
			'foreign_key' => 'Lorem ipsum dolor sit amet',
			'workorder_id' => 10,
			'tasks_workorder_id' => 10,
			'flag_status' => 1,
			'flag_id' => 10,
			'created' => '2012-10-22 11:57:42'
		),
	);

}
