<div class="radioReadOnly">
<?php
$params = array(
	'type' => 'radio',
	'options' => array(
		'New' => 'New',
		'Working' => 'Working',
		'Paused' => 'Paused',
		'Done' => 'Done'
	),
	'value' => $tasksWorkorder['TasksWorkorder']['status'],
);
echo $this->Form->input('Status.status', $params);
?>
</div>