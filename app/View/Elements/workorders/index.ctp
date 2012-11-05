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
	<?php foreach ($workorders as $workorder):   ?>
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
			<td><?php echo $this->Wms->slackTime($workorder['Workorder']['slack_time']); ?></td>
			<td><?php echo $workorder['Workorder']['status']; ?></td>
			<td><?php
				echo $workorder['Workorder']['name'] . ' ' . $workorder['Workorder']['source_model'] . ': ' . $workorder['Source']['label'];
			?></td>
			<td><?php echo $workorder['Manager']['username']; ?></td>
			<td><?php echo $this->Wms->shortTime($workorder['Workorder']['work_time']);  ?></td>
			<td class="actions">
				<?php
				echo $this->Html->link(
					__('Go'),
					'http://' . Configure::read('host.PES') . '/workorders/photos/' . $workorder['Workorder']['uuid'] . '/raw:1',
					array('target' => '_blank')
				);
				if (!empty($actionView)) {
					echo $this->Html->link(__('View'), array('controller' => 'workorders', 'action' => 'view', $workorder['Workorder']['id']));
				}
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>