<h2>Workorder</h2>
<?php
	echo $this->element('workorders/index', array('actionView' => false));
	echo $this->element('PES_preview', array('model' => 'AssetsWorkorder', 'workorder'=>$workorder));
	$status = $workorder['Workorder']['status'];
	$PES_baseurl = 'http://' . Configure::read('host.PES') ;
	$allowedUsers = array($workorder['Workorder']['manager_id']);
	$hasPermission = in_array(AuthComponent::user('id'), $allowedUsers);
?>
<br />

<div class="sidebar">
	<fieldset>
	<legend>Actions</legend>
	<ul class="actions">
		<li><?php 
			$disabled = in_array($status, array('Done')); 
			echo $this->Html->link(
				__('Cancel'),
				array('controller' => 'workorders', 'action' => 'cancel', $workorder['Workorder']['id']),
				array('class'=>($disabled ? 'disabled' : '') )
			); 
		?>
		</li>
		<li><?php 
			$disabled = in_array($status, array('QA', 'Done')); 
			echo $this->Html->link(
				__('Reject'),
				array('controller' => 'workorders', 'action' => 'reject', $workorder['Workorder']['id']),
				array('class'=>($disabled ? 'disabled' : '') )
			); 
		?></li>
		<li><?php 
			$disabled = $status != 'QA'; 
			echo $this->Html->link(
				__('Deliver'),
				array('controller' => 'workorders', 'action' => 'deliver', $workorder['Workorder']['id']),
				array('class'=>($disabled ? 'disabled' : '') )
			); 
		?></li>
	</ul>
	<ul class="actions">
		<li><?php 
			$disabled = !$hasPermission || $status=='Done'; 
			echo $this->element('workorders/form_harvest', array('workorder'=>$workorder['Workorder'], 'disabled'=>$disabled)); ?></li>
		</ul>
	</fieldset>
	
<?php echo $this->element('workorders/timing'); ?>
<?php echo $this->element('workorders/status'); ?>
</div>

<br>

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