<?php $tasksWorkorder = $tasksWorkorders[0]; ?>
<h2>Workorder</h2>
<?php
echo $this->element('tasks_workorders/workorder_parent', array('actionView' => true, 'wo_parent'=>$tasksWorkorder));
?>

<div class="sidebar">
<?php echo $this->element('tasks_workorders/timing', array('tasksWorkorder' => $tasksWorkorder)); ?>
<?php echo $this->element('tasks_workorders/status', array('tasksWorkorder' => $tasksWorkorder)); ?>
</div>

<h3>Actions</h3>

<ul class="actions">
	<?php 
	// debug($tasksWorkorder);		$disabled = ($tasksWorkorder['TasksWorkorder']['operator_id'] != AuthComponent::user('id'));
		$target = $disabled ? '' : 'http://' . Configure::read('host.PES') . '/tasks_workorders/photos/' . $tasksWorkorder['TasksWorkorder']['uuid'] . '/raw:1'; 
		$link_Go = $this->Html->link(
			__('Go'), 
			$target, 
			array('target' => '_blank', 'class'=>($disabled ? 'disabled' : ''), 'onclick'=>"return !$disabled;")
		);	
	?>
	<li>
		<?php echo $link_Go; ?>
	</li>
	<li>
		<?php echo $this->Html->link(
			'Start work',
			array('controller' => 'tasks_workorders', 'action' => 'change_status', $tasksWorkorder['TasksWorkorder']['id'], 'Working')
		); ?>
	</li>
	<li>
		<?php echo $this->Html->link(
			'Pause work',
			array('controller' => 'tasks_workorders', 'action' => 'change_status', $tasksWorkorder['TasksWorkorder']['id'], 'Paused')
		); ?>
	</li>
	<li>
		<?php echo $this->Html->link(
			'Done',
			array('controller' => 'tasks_workorders', 'action' => 'change_status', $tasksWorkorder['TasksWorkorder']['id'], 'Done')
		); ?>
	</li>
	<li><?php echo $this->element('tasks_workorders/form_harvest', array('tasksWorkorder'=>$tasksWorkorder)); ?></li>
	<li>
		<?php echo $this->Html->link(
			'Reject',
			array('controller' => 'tasks_workorders', 'action' => 'reject', $tasksWorkorder['TasksWorkorder']['id'])
		); ?>
	</li>
</ul>
<br />

<h3>Comments and Activity</h3>
<?php echo $this->element('activity_logs/index'); ?>
<br />
<?php echo $this->element('activity_logs/add', array('model' => 'TasksWorkorder', 'foreign_key' => $tasksWorkorder['TasksWorkorder']['id'])); ?>