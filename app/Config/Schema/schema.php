<?php 
class AppSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $activity_logs = array(
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
	public $assets_tasks = array(
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
	public $assets_workorders = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'workorder_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'asset_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_habtm_join' => array('column' => array('workorder_id', 'asset_id'), 'unique' => 1),
			'fk_assets' => array('column' => 'asset_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);
	public $editors = array(
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
	public $skills = array(
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
	public $tasks = array(
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
	public $tasks_workorders = array(
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
	public $workorders = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'uuid' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'comment' => 'legacy field for ETL, ignore', 'charset' => 'utf8'),
		'client_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'customer satisfaction target', 'charset' => 'utf8'),
		'source_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_general_ci', 'comment' => 'User or Circle with ownership over the AssetsWorkorder', 'charset' => 'utf8'),
		'source_model' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'comment' => 'User or Group Model', 'charset' => 'utf8'),
		'manager_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index', 'comment' => 'Manager assignment, references Editor.id'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1000, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'harvest' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'status' => array('type' => 'string', 'null' => true, 'default' => 'New', 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'assets_workorder_count' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'submitted' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'due' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'started' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'finished' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'elapsed' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'total working time, in seconds'),
		'special_instructions' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 1000, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_client_id' => array('column' => 'client_id', 'unique' => 0),
			'fk_manager_id' => array('column' => 'manager_id', 'unique' => 0),
			'fk_source_id' => array('column' => 'source_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);
}
