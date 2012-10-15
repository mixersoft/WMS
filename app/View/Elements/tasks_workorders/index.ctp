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
	<?php foreach ($tasksWorkorders as $tasksWorkorder): 
			/*
			 * add PES link to go button, 
			 * 	NOTE: this link redirects to a different cakephp app
			 */
			$host_PES = Configure::read('isLocal') ? 'snappi-dev' : 'dev.snaphappi.com';	// move to config file
			Configure::write('host.PES', $host_PES);
			// TODO: update PES to use snappi_wms schema and TasksWorkorder.id, deprecate TasksWorkorder.uuid  
			$go_link = "http://{$host_PES}".Router::url(array('action'=>'photos', $tasksWorkorder['TasksWorkorder']['uuid'], 'raw'=>1, 'base'=>false));
		?>
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
			<td class="actions">
				<?php
				echo $this->Html->link(__('Go'), $go_link, array('target' => '_blank'));
				if (!empty($actionView)) {
					echo $this->Html->link(__('View'), array('controller' => 'tasks_workorders', 'action' => 'view', $tasksWorkorder['TasksWorkorder']['id']));
				}
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>