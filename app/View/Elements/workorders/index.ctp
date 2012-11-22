<?php if (!$workorders): ?>
	<p><em>No workorders</em></p>
<?php else: ?>
	<table class='workorder'>
		<tr>
			<th>id</th>
			<th>slack_time</th>
			<th>status</th>
			<th>description</th>
			<th>owner</th>
			<th>work_time</th>
			<th>actions</th>
		</tr>
	<?php foreach ($workorders as $workorder):    ?>
		<tr class='row'>
			<td>
				<?php
				if (!empty($actionExpand)) {
					echo $this->Html->link('&raquo;',
						array('controller' => 'workorders', 'action' => 'detail', $workorder['Workorder']['id']),
						array('escape' => false, 'class' => 'expand-detail', 'id' => 'expand-detail-' . $workorder['Workorder']['id'])
					) . ' ';
				}
				echo "<span class='wo-id'>{$workorder['Workorder']['id']}</span>"; ?>
			</td>
			<td><?php echo $this->Wms->slackTime($workorder['Workorder']['slack_time']); ?></td>
			<td><?php echo $workorder['Workorder']['status']; ?></td>
			<td><?php
				$description = array($workorder['Workorder']['name']);
				$description[] = "&nbsp;<span class='wo-type'>".strtolower($workorder['Workorder']['source_model']).':</span>';
				$description[] = "<span class='wo-label'>{$workorder['Source']['label']}</span>";
				$description[] = "&nbsp;<span class='wo-count'>({$workorder['Workorder']['assets_workorder_count']})</span>";
				echo implode('',$description);
			?></td>
			<td><?php echo $workorder['Manager']['username']; ?></td>
			<td><?php echo $this->Wms->shortTime($workorder['Workorder']['work_time']);  ?></td>
			<td class="actions">
				<?php
				$disabled = ($workorder['Workorder']['manager_id'] != AuthComponent::user('id'));
				$target = $disabled ? '' : 'http://' . Configure::read('host.PES') . '/workorders/photos/' . $workorder['Workorder']['uuid'] . '/raw:1'; 
				echo $this->Html->link(
					__('Go'), 
					$target, 
					array('target' => '_blank', 'class'=>($disabled ? 'disabled' : ''), 'onclick'=>"return !$disabled;")
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