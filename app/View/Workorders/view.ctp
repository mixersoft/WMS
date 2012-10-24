<h2>Workorder</h2>
<?php
echo $this->element('workorders/index', array('actionView' => false));
echo $this->element('PES_preview', array('model' => 'AssetsWorkorder', 'workorder'=>$workorder));
?>
<br />

<h3>Actions</h3>
<ul class="actions">
	<li><?php echo $this->Html->link(
		'Cancel',
		array('controller' => 'workorders', 'action' => 'cancel', $workorder['Workorder']['id'])
	); ?></li>
	<li><?php echo $this->Html->link(
		'Reject',
		array('controller' => 'workorders', 'action' => 'reject', $workorder['Workorder']['id'])
	); ?></li>
	<li><?php echo $this->Html->link(
		'Deliver',
		array('controller' => 'workorders', 'action' => 'deliver', $workorder['Workorder']['id'])
	); ?></li>
	<li><?php echo $this->Html->link(
		'Update',
		'#'
	); ?></li>
</ul>

<br>
<?php echo $this->element('workorders/status'); ?>

<h3>Tasks for this workorder</h3>
<?php echo $this->element('tasks_workorders/index', array('actionView' => true, 'actionExpand' => true)); ?>

<h4>Special instructions</h4>
<p>
<?php
$specialInstructions = $workorder['Workorder']['special_instructions'];
echo ($specialInstructions) ? $specialInstructions : '<em>No special instructions</em>'; ?>
</p>

<h3>Comments and Activity</h3>
<?php echo $this->element('activity_logs/index'); ?>
<br />
<?php echo $this->element('activity_logs/add', array('model' => 'Workorder', 'foreign_key' => $workorder['Workorder']['id'])); ?>