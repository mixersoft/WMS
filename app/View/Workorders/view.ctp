<h2>Workorder</h2>
<?php echo $this->element('workorders/index'); ?>

<h3>Tasks for this workorder</h3>
<?php echo $this->element('tasks_workorders/index', array('actionView' => true)); ?>

<h4>Special instructions</h4>
<p>
<?php
$specialInstructions = $workorders[0]['Workorder']['special_instructions'];
echo ($specialInstructions) ? $specialInstructions : '<em>No special instructions</em>'; ?>
</p>

<h3>Comments and Activity</h3>
<?php echo $this->element('activity_logs/index'); ?>