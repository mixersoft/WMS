<div class="radioReadOnly">
<?php
$params = array(
	'type' => 'radio',
	'options' => array(
		'New' => 'New',
		'Ready' => 'Ready',
		'Working' => 'Working',
		'QA' => 'QA',
		'Done' => 'Done'
	),
	'value' => $workorder['Workorder']['status'],
);
echo $this->Form->input('Status.status', $params);
?>
</div>