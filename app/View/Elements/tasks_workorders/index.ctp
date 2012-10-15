<?php if (!$tasksWorkorders): ?>
	<p><em>No tasks</em></p>
<?php else: ?>
	<table>
		<tr>
			<th>id</th>
			<th>Slack Time</th>
			<th>Status</th>
			<th>Description</th>
			<th>Owner</th>
			<th>Work Time</th>
			<?php if (!empty($showWorkorder)): ?>
			<th>Workorder id</th>
			<?php endif; ?>
			<th>actions</th>
		</tr>
	<?php foreach ($tasksWorkorders as $tasksWorkorder): ?>
		<tr>
			
			<td>
				<?php
				if (!empty($actionExpand)) {
					echo $this->Html->link('&raquo;',
						array('controller' => 'tasks_workorders', 'action' => 'detail', $tasksWorkorder['TasksWorkorder']['id']),
						array('escape' => false, 'class' => 'expand-detail', 'id' => 'expand-detail-' . $tasksWorkorder['TasksWorkorder']['id'])
					) . ' ';
				}
				echo $tasksWorkorder['TasksWorkorder']['id']; ?>
			</td>
			
			<td><?php echo $this->Wms->slackTime($tasksWorkorder['TasksWorkorder']['slack_time']); ?></td>
			
			<td><?php echo $tasksWorkorder['TasksWorkorder']['status']; ?></td>
			
			<td><?php echo $tasksWorkorder['Task']['name']; ?></td>
			
			<td class="actions">
			<?php echo $tasksWorkorder['Operator']['username'] ? '<strong>' . $tasksWorkorder['Operator']['username'] . '</strong>' : '<em>none</em>'; ?>
			<?php echo $this->Html->link(
				$tasksWorkorder['Operator']['username'] ? 'Change' : 'Assign',
				array('controller' => 'tasks_workorders', 'action' => 'assignments', $tasksWorkorder['TasksWorkorder']['id'])
			);
			?></td>
			
			<td><?php echo gmdate('H\h i\m', $tasksWorkorder['TasksWorkorder']['work_time']); ?></td>

			<?php if (!empty($showWorkorder)): ?>
			<td><?php echo $this->Html->link(
				$tasksWorkorder['TasksWorkorder']['workorder_id'], 
				array('controller' => 'workorders', 'action' => 'view', $tasksWorkorder['TasksWorkorder']['workorder_id'])
			); ?></td>
			<?php endif; ?>

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