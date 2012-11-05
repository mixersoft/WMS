<?php echo $this->element('PES_preview', array('model' => 'AssetsWorkorder', 'workorder'=>$workorder)); ?>
<br>
<h4>Special instructions</h4>
<p>
<?php
$specialInstructions = $workorder['Workorder']['special_instructions'];
echo ($specialInstructions) ? $specialInstructions : '<em>No special instructions</em>'; ?>
</p>

<br>
<h3>Tasks</h3>
<?php echo $this->element('tasks_workorders/index', array('actionView' => true, 'actionExpand' => false)); ?>