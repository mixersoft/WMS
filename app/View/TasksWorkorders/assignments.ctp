<h2>Task assigment</h2>
<h3>Workorder</h3>
<?php
echo $this->element('tasks_workorders/workorder_parent', array('actionView' => true, 'wo_parent'=>$tasksWorkorder));
?>

<h3>Operators</h3>
<table class="operator-list">
	<tr>
		<th>id</th>
		<th>Username</th>
		<th>Target</th>
		<th>Work</th>
		<th>Day</th>
		<th>Week</th>
		<th>Month</th>
		<th>Avail 24</th>
		<th>Busy 24/+</th>
		<th>Slack</th>
		<th>After</th>
		<th>Assigned</th>
		<th>Assign</th>
	</tr>
<?php foreach ($operators as $operator): 
		$assigned = $operator['Editor']['id'] == $tasksWorkorder['TasksWorkorder']['operator_id'];
	?>
	<tr  class="<?php echo 'row ' . ($assigned ? 'assigned' : ''); ?>">
		<td><?php echo $operator['Editor']['id']; ?></td>
		<td><h4><?php echo $operator['Editor']['username']; ?></h4></td>
		<td><?php echo $operator['TaskStat']['target']; ?></td>
		<td><?php echo $this->Wms->shortTime($operator['TaskStat']['work']); ?></td>
		<td><?php echo $this->Wms->rateAsPercent($operator['TaskStat']['day'], $operator['TaskStat']['target']); ?></td>
		<td><?php echo $this->Wms->rateAsPercent($operator['TaskStat']['week'], $operator['TaskStat']['target']); ?></td>
		<td><?php echo $this->Wms->rateAsPercent($operator['TaskStat']['month'], $operator['TaskStat']['target']); ?></td>
		<td><?php echo $operator['BusyStat']['avail_24']; ?></td>
		<td><?php echo number_format($operator['BusyStat']['busy_24'],1). " / " . number_format($operator['BusyStat']['busy'],1)  ?></td>
		<td><?php echo $this->Wms->slackTime($operator['BusyStat']['slack']) ?></td>
		<td><?php
		 	if (!$assigned && $tasksWorkorder['TasksWorkorder']['assets_task_count']){
				// work_time for this operator
				$work_rate = $skills[$operator['Editor']['id']]['rate_7_day'];
				if ($tasksWorkorder['TasksWorkorder']['assets_task_count']) $operator_work_time = 3600 * $work_rate / $tasksWorkorder['TasksWorkorder']['assets_task_count'];
				$slack_after_assignment = $operator['BusyStat']['slack'] - $operator_work_time;
				echo $this->Wms->slackTime($slack_after_assignment);
			} ?>
				</td>
		<td><?php
		if ($operator['BusyStat']['assigned']) {
			echo $this->Html->link(
				"<i class='fa fa-lg fa-plus-square'></i>",
				array('controller' => 'tasks_workorders', 
					'action' => 'assigned_to',
					 $operator['Editor']['id']
				),
				array(
					'id' => 'expand-assigned-'. $operator['Editor']['id'],
					'class' => 'expand-assigned', 
					'escape' => false,
				)
			);
		} else {
			echo '<em>none</em>';
		}
		?></td>
		<td class="actions"><?php
		if (!$assigned){
			echo $this->Html->link('Assign', 
				array(
					'controller' => 'tasks_workorders', 
					'action' => 'assign', 
					$tasksWorkorder['TasksWorkorder']['id'], 
					$operator['Editor']['id']
				),
				array('class'=>'btn btn-small btn-info')
			);
		}
		?></td>
	</tr>
<?php endforeach; ?>
</table>