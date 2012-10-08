<?php $workorder = $workorders[0]; ?>
<h2>Workorder</h2>
<?php
echo $this->element('workorders/index', array('actionView' => false));
echo $this->element('assets/index', array('model' => 'AssetsWorkorder'));
?>
<br />

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