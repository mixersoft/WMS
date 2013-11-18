	<table class='table workorder'>
		<thead>
		<tr class='row'>
			<th>id</th>
<!-- 			<th>slack_time</th> -->
			<th>status</th>
			<th>description</th>
			<th>owner</th>
<!-- 			<th>work_time</th> -->
			<th>actions</th>
		</tr>
		</thead>
		<tbody>
		<tr class='row'>
			<td>
				<?php 
				if (!empty($actionExpand)) {
					echo $this->Html->link(
						"<i class='fa fa-lg fa-plus-square'></i>",
						array('controller' => 'workorders', 'action' => 'detail', $wo_parent['Workorder']['id']),
						array('escape' => false, 'class' => 'expand-detail', 'id' => 'expand-detail-' . $wo_parent['Workorder']['id'])
					) . ' ';
				}
				echo "<span class='wo-id'>{$wo_parent['Workorder']['id']}</span>"; ?>
			</td>
<!-- 			// <td><?php echo $this->Wms->slackTime($wo_parent['Workorder']['slack_time']); ?></td> -->
			<td><?php echo $wo_parent['Workorder']['status']; ?></td>
			<td><?php
				$description = array($wo_parent['Workorder']['name']);
				$description[] = "&nbsp;<span class='wo-type'>".strtolower($wo_parent['Workorder']['source_model']).':</span>';
				$description[] = "<span class='wo-label'>{$wo_parent['Workorder']['Source']['label']}</span>";
				$description[] = "&nbsp;<span class='wo-count'>({$wo_parent['Workorder']['assets_workorder_count']})</span>";
				echo implode('',$description);
			?></td>
			<td><?php echo $wo_parent['Workorder']['Manager']['username']; ?></td>
<!-- 			// <td><?php echo $this->Wms->shortTime($wo_parent['Workorder']['work_time']);  ?></td> -->
			<td class="actions">
				<?php
				$disabled = ($wo_parent['Workorder']['manager_id'] != AuthComponent::user('id'));
				$target = $disabled ? '' : 'http://' . Configure::read('host.PES') . '/workorders/photos/' . $wo_parent['Workorder']['id'] . '/raw:1'; 
				if (!empty($actionView)) {
					echo $this->Html->link(__('View'), 
						array(
							'controller' => 'workorders', 
							'action' => 'view', 
							$wo_parent['Workorder']['id']),
						array('class'=>'btn btn-small btn-info')
					);
				}
				echo $this->Html->link(__('PES'), 
					$target, 
					array('target' => '_blank', 
						'class'=>'btn btn-small ' . ($disabled ? 'disabled' : ''), 
						'onclick'=>"return !$disabled;")
				);
				?>
			</td>
		</tr>
		<tr><td id="<?php echo 'expand-detail-' . $wo_parent['Workorder']['id'];  ?>" class="expanded-detail" colspan="8">
			<h3>Task</h3>
<?php
echo $this->element('tasks_workorders/index', array('actionView' => ($this->view != 'view'), 'showWorkorder' => false));
echo $this->element('PES_preview', array('model' => 'AssetsTask', 'workorder'=> $workorder));
?>
<br />
		</td></tr>
		</tbody>
	</table>
