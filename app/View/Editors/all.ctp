<h2>Operators</h2>

<?php foreach ($editors as $editor): ?>
	<?php echo $this->element('editors/view', array('editor' => $editor)); ?>
	<h4>Current tasks</h4>
	<?php echo $this->element(
		'tasks_workorders/index',
		array('tasksWorkorders' => $assignedTasks[$editor['Editor']['id']], 'actionView' => true)
	); ?>
	<br>
<?php endforeach; ?>