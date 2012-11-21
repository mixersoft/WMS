<h3>Skills</h3>
<?php foreach ($skills as $skill): ?>
	<?php echo $this->element('skills/view', array('editor' => $skill, 'actionExpand'=>true)); ?>
	<h4>Current tasks</h4>
	<?php 
	echo $this->element(
		'tasks_workorders/index',
		array('tasksWorkorders' => $assignedTasks[$skill['Editor']['id']], 
		'actionView' => true)
	); ?>
	<br>
<?php endforeach; ?>