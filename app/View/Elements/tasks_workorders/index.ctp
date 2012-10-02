<table>
	<tr>
		<th>id</th>
		<th>slack_time</th>
		<th>status</th>
		<th>description</th>
		<th>owner</th>
		<th>work_time</th>
		<th>actions</th>
	</tr>
<?php foreach ($tasksWorkorders as $tasksWorkorder): ?>
	<tr>
		<td><?php echo $tasksWorkorder['TasksWorkorder']['id']; ?></td>
		<td><?php echo gmdate('d\d H\h i\m', $tasksWorkorder['TasksWorkorder']['slack_time']); ?></td>
		<td><?php echo $tasksWorkorder['TasksWorkorder']['status']; ?></td>
		<td><?php echo $tasksWorkorder['Task']['name']; ?></td>
		<td><?php echo $tasksWorkorder['Operator']['username']; ?></td>
		<td><?php echo gmdate('H\h i\m', $tasksWorkorder['TasksWorkorder']['work_time']); ?></td>
		<td>
			<ul>
				<li>
					<?php echo $this->Html->link(__('Go'), '#'); ?>
				</li>
				<li>
					<?php echo $this->Html->link(
						__('View'),
						array('controller' => 'tasks_workorders', 'action' => 'view', $tasksWorkorder['TasksWorkorder']['id'])
					); ?>
				</li>
			</ul>
		</td>
	</tr>
<?php endforeach; ?>
</table>