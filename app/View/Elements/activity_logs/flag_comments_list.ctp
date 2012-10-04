<?php
$comments = array();
foreach ($data as $record) {
	$comments[] = array(
		'ActivityLog' => $record,
		'Editor' => $record['Editor'],
	);
}
echo $this->element('activity_logs/index', array('activityLogs' => $comments));
?>