<?php if (!$tasksWorkorders): ?>
	<p><em>No tasks</em></p>
<?php else: ?>
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
			<td>
				<?php echo $this->Html->link('&raquo;',
					array('controller' => 'tasks_workorders', 'action' => 'detail', $tasksWorkorder['TasksWorkorder']['id']),
					array('escape' => false, 'class' => 'expand-detail', 'id' => 'expand-detail-' . $tasksWorkorder['TasksWorkorder']['id'])
				); ?>
				<?php echo $tasksWorkorder['TasksWorkorder']['id']; ?>
			</td>
			<td><?php echo gmdate('d\d H\h i\m', $tasksWorkorder['TasksWorkorder']['slack_time']); ?></td>
			<td><?php echo $tasksWorkorder['TasksWorkorder']['status']; ?></td>
			<td><?php echo $tasksWorkorder['Task']['name']; ?></td>
			<td><?php
			if (!empty($tasksWorkorder['Operator']['username'])) {
				echo $tasksWorkorder['Operator']['username'];
			} else {
				echo $this->element('tasks_workorders/assign', array('tasks_workorder_id' => $tasksWorkorder['TasksWorkorder']['id']));
			}
			?></td>
			<td><?php echo gmdate('H\h i\m', $tasksWorkorder['TasksWorkorder']['work_time']); ?></td>
			<td class="actions">
				<?php
				echo $this->Html->link(__('Go'), '#', array('target' => '_blank'));
				if (!empty($actionView)) {
					echo $this->Html->link(__('View'), array('controller' => 'tasks_workorders', 'action' => 'view', $tasksWorkorder['TasksWorkorder']['id']));
				}
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>