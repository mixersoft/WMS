<?php $tasksWorkorder = $tasksWorkorders[0]; ?>
<h2>Task assigment</h2>
<h3>Workorder</h3>
<?php echo $this->element('workorders/index', array('actionView' => true)); ?>

<br />

<h3>Task</h3>
<?php
echo $this->element('tasks_workorders/index', array('actionView' => true));
echo $this->element('assets/index', array('model' => 'AssetsTask'));
?>

<br />

<h3>Operators</h3>
<table>
	<tr>
		<th>id</th>
		<th>Username</th>
		<th>Target</th>
		<th>Work</th>
		<th>Day</th>
		<th>Week</th>
		<th>Month</th>
		<th>Aval 24</th>
		<th>Busy 24/+</th>
		<th>Slack</th>
		<th>After</th>
		<th>Assigned</th>
		<th>Assign</th>
	</tr>
<?php foreach ($operators as $operator): ?>
	<tr>
		<td><?php echo $operator['Editor']['id']; ?></td>
		<td><h4><?php echo $operator['Editor']['username']; ?></h4></td>
		<td><?php echo $operator['Editor']['id']; ?></td>
		<td><?php echo $operator['Editor']['id']; ?></td>
		<td><?php echo $operator['Editor']['id']; ?></td>
		<td><?php echo $operator['Editor']['id']; ?></td>
		<td><?php echo $operator['Editor']['id']; ?></td>
		<td><?php echo $operator['Editor']['id']; ?></td>
		<td><?php echo $operator['Editor']['id']; ?></td>
		<td><?php echo $operator['Editor']['id']; ?></td>
		<td><?php echo $operator['Editor']['id']; ?></td>
		<td><?php echo $operator['Editor']['id']; ?></td>
		<td class="actions"><?php
		echo $this->Html->link('Assign', array(
			'controller' => 'tasks_workorders', 'action' => 'assign', $tasksWorkorder['TasksWorkorder']['id'], $operator['Editor']['id']
		));
		?></td>
	</tr>
<?php endforeach; ?>
</table>
