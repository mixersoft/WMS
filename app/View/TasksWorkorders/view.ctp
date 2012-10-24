<?php $tasksWorkorder = $tasksWorkorders[0]; ?>
<h2>Task</h2>
<?php
echo $this->element('tasks_workorders/index', array('actionView' => false, 'showWorkorder' => true));
echo $this->element('PES_preview', array('model' => 'AssetsTask', 'workorder'=> $workorder));
?>
<br />

<h3>Actions</h3>

<ul class="actions">
	<li>
		<?php echo $this->Html->link('Go to PES', '#'); ?>
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
	<li>
		<?php echo $this->Html->link(
			'Reject',
			array('controller' => 'tasks_workorders', 'action' => 'reject', $tasksWorkorder['TasksWorkorder']['id'])
		); ?>
	</li>
</ul>
<br />
<?php echo $this->element('tasks_workorders/status', array('tasksWorkorder' => $tasksWorkorder)); ?>

<h3>Comments and Activity</h3>
<?php echo $this->element('activity_logs/index'); ?>
<br />
<?php echo $this->element('activity_logs/add', array('model' => 'TasksWorkorder', 'foreign_key' => $tasksWorkorder['TasksWorkorder']['id'])); ?>