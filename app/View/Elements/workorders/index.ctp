<?php if (!$workorders): ?>
	<p><em>No workorders</em></p>
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
	<?php foreach ($workorders as $workorder): ?>
		<tr>
			<td>
				<?php
				if (!empty($actionExpand)) {
					echo $this->Html->link('&raquo;',
						array('controller' => 'workorders', 'action' => 'detail', $workorder['Workorder']['id']),
						array('escape' => false, 'class' => 'expand-detail', 'id' => 'expand-detail-' . $workorder['Workorder']['id'])
					) . ' ';
				}
				echo $workorder['Workorder']['id']; ?>
			</td>
			<td><?php echo gmdate('d\d H\h i\m', $workorder['Workorder']['slack_time']); ?></td>
			<td><?php echo $workorder['Workorder']['status']; ?></td>
			<td><?php echo $workorder['Workorder']['description']; ?></td>
			<td><?php echo $workorder['Manager']['username']; ?></td>
			<td><?php echo gmdate('H\h i\m', $workorder['Workorder']['work_time']); ?></td>
			<td class="actions">
				<?php
				echo $this->Html->link(__('Go'), '#', array('target' => '_blank'));
				if (!empty($actionView)) {
					echo $this->Html->link(__('View'), array('controller' => 'workorders', 'action' => 'view', $workorder['Workorder']['id']));
				}
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>