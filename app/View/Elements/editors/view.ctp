<div class='editor inline'>
<?php   	
			$editor['link'] = Router::url("/editors/all/editor_id:{$editor['Editor']['id']}");
			$editor['badge'] = $this->Html->image(
				Stagehand::getSrc($editor['User']['src_thumbnail'], 'sq', 'Person'), 
				array(
					'title'=>"{$editor['User']['username']}",
					'width'=>'48px', 'height'=>'48px',
				)
			); 
			$output['badge'] = "<div class='badge aside'><a href='{$editor['link']}'>{$editor['badge']}</a></div>";
			$output['label'] = "<h3 class='label'>{$editor['Editor']['username']}</h3>";
			echo "{$output['badge']}{$output['label']}";
?>
</div>

<table class='editor-slack-time'>
	<tr>
		<th></th>
		<th>Avail</th>
		<th>Busy 24/+</th>
		<th>Slack</th>
		<th>Assigned</th>
		<th>Schedule</th>
	</tr>
	<tr class='editor-row'>
		<td><?php if (!empty($actionExpand)) {
					echo $this->Html->link(
						"<i class='fa fa-lg fa-plus-square'></i>",
						array('controller' => 'skills', 'action' => 'all', 'editor_id'=>$editor['Editor']['id']),
						array('escape' => false, 'class' => 'expand-detail', 'id' => 'expand-detail-' . $editor['Editor']['id'])
					) . ' ';
				};
				?></td>
		<td class='available'><?php echo $editor['BusyStat']['avail_24'] ?></td>
		<td class='busy'><?php echo number_format($editor['BusyStat']['busy_24'],1). " / " . number_format($editor['BusyStat']['busy'],1)  ?></td>
		<td class='slack-time'><?php echo $this->Wms->slackTime($editor['BusyStat']['slack']) ?></td>
		<td class='assignments'><?php echo $editor['BusyStat']['assigned'] ?></td>
		<td class='work-week'><?php echo $this->Wms->schedule($editor['Editor']['work_week']); ?></td>
	</tr>
<?php if (empty($actionExpand)) : ?>
<tr><td id="<?php echo 'expand-detail-' . $editor['Editor']['id'];  ?>" class="expanded-detail" colspan="8">
	<h3>Skills</h3>
	<table class='editor-skills'>
		<tr>
			<th>Task</th>
			<th>Target</th>
			<th>Day</th>
			<th>Week</th>
			<th>Month</th>
		</tr>
		<?php foreach ($editor['Skill'] as $skill) :   ?>
		<tr class='skill-row'>
			<td class='label'><?php echo $skill['Task']['name'] ?></td>
			<td class='work-rate target'><?php echo $skill['Task']['target_work_rate'] ?></td>
			<td class='work-rate'><?php echo $this->Wms->rateAsPercent($skill['rate_1_day'], $skill['Task']['target_work_rate'] ); ?></td>
			<td class='work-rate'><?php echo $this->Wms->rateAsPercent($skill['rate_7_day'], $skill['Task']['target_work_rate'] ); ?></td>
			<td class='work-rate'><?php echo $this->Wms->rateAsPercent($skill['rate_30_day'], $skill['Task']['target_work_rate'] ); ?></td>
		</tr>
		<?php endforeach;  ?>
	</table>
	
	<h4>Current tasks</h4>
	<?php 
	echo $this->element(
		'tasks_workorders/index',
		array('tasksWorkorders' => $assignedTasks[$editor['Editor']['id']], 
		'actionView' => true)
	); ?>
	<br>
	</td>
</tr>
<?php endif; ?>	
</table>

