<?php if (!$tasksWorkorders): ?>
	<p><em>No tasks</em></p>
<?php else: ?>
	<table class='tasks-workorder'>
		<tr>
			<th>id</th>
			<th>Slack Time</th>
			<th>Status</th>
			<th>Description</th>
			<th>Owner</th>
			<th>Work Time</th>
			<th>actions</th>
		</tr>
	<?php foreach ($tasksWorkorders as $tasksWorkorder): ?>
		
		<tr class='row'>
			<td>
				<?php
				if (!empty($actionExpand)) {
					echo $this->Html->link(
						"<i class='fa fa-lg fa-plus-square'></i>",
						array(
							'controller' => 'tasks_workorders', 
							'action' => 'detail', 
							$tasksWorkorder['TasksWorkorder']['id']),
						array('escape' => false, 
							'class' => 'expand-detail', 
							'id' => 'expand-detail-' . $tasksWorkorder['TasksWorkorder']['id']
							)
					) . ' ';
				}
				echo "<span class='id'>{$tasksWorkorder['TasksWorkorder']['id']}</span>"; ?>
			</td>
			
			<td><?php echo $this->Wms->slackTime($tasksWorkorder['TasksWorkorder']['slack_time']); ?></td>
			
			<td><?php echo $tasksWorkorder['TasksWorkorder']['status']; ?></td>
			
			<td><?php  
					$description = array();
					$description[] = "<span class='tw-type'>{$tasksWorkorder['Task']['name']}</span>"; 
					$description[] = "&nbsp;<span class='wo-type'>".strtolower($tasksWorkorder['Workorder']['source_model']).':</span>';
					$description[] = "<span class='wo-label'>{$tasksWorkorder['Workorder']['Source']['label']}</span>";
					$description[] = "&nbsp;<span class='wo-count'>({$tasksWorkorder['TasksWorkorder']['assets_task_count']})</span>";
					echo implode('',$description);
				?></td>
			
			<td class="actions">
			<?php echo $tasksWorkorder['Operator']['username'] ? '<strong>' . $tasksWorkorder['Operator']['username'] . '</strong>' : '<em>none</em>'; ?>
			<?php echo $this->Html->link(
					$tasksWorkorder['Operator']['username'] ? 'Change' : 'Assign',
					array(
						'controller' => 'tasks_workorders', 
						'action' => 'assignments', 
						$tasksWorkorder['TasksWorkorder']['id']
						),
					array('class'=>'btn btn-info btn-mini')
				);
			?></td>
			
			<td><?php echo $this->Wms->shortTime($tasksWorkorder['TasksWorkorder']['work_time']); ?></td>

			<td class="actions">
				<?php
				$disabled = ($tasksWorkorder['TasksWorkorder']['operator_id'] != AuthComponent::user('id'));
				$target = $disabled ? '' : 'http://' . Configure::read('host.PES') . '/tasks_workorders/photos/' . $tasksWorkorder['TasksWorkorder']['id'] . '/raw:1'; 
				if (!empty($actionView)) {
					echo $this->Html->link(__('View'), 
						array('controller' => 'tasks_workorders', 
							'action' => 'view', 
							$tasksWorkorder['TasksWorkorder']['id']
							),
						array('class'=>'btn btn-small btn-info')
					);
					echo $this->Html->link(__('PES'), 
						$target, 
						array(
							'target' => '_blank', 
							'class'=>'btn btn-small ' . ($disabled ? 'disabled' : ''),  
							'onclick'=>"return !$disabled;"
							)
					);
				}
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>