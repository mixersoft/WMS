<h3><?php echo $editor['Editor']['username']; ?></h3>
<div class='editor-profile-badge'>
<?php   	
			$badge['editor'] = $this->Html->image(
				Stagehand::getSrc($editor['User']['src_thumbnail'], $size, 'Person'), 
				array(
					'title'=>"editor: {$editor['User']['username']}",
					'width'=>'75px', 'height'=>'75px',
					)
			); 
			$badge['editor'] = $this->Html->link(
				$badge['editor'],
				"http://{$host_PES}/person/home/{$editor['User']['id']}",
				array('target'=>'_blank', 'escape'=>false)
			);
			echo $badge['editor'];
?>
</div>
<table>
	<tr>
		<th>Avail</th>
		<th>Busy 24/+</th>
		<th>Slack</th>
		<th>Assigned</th>
		<th>Schedule</th>
	</tr>
	<tr>
		<td><?php echo $editor['BusyStat']['avail_24'] ?></td>
		<td><?php echo number_format($editor['BusyStat']['busy_24'],1). " / " . number_format($editor['BusyStat']['busy'],1)  ?></td>
		<td><?php echo $this->Wms->slackTime($editor['BusyStat']['slack']) ?></td>
		<td><?php echo $editor['BusyStat']['assigned'] ?></td>
		<td><?php echo $this->Wms->schedule($editor['Editor']['work_week']); ?></td>
	</tr>
</table>

<table>
	<tr>
		<th>Task</th>
		<th>Target</th>
		<th>Work</th>
		<th>Day</th>
		<th>Week</th>
		<th>Month</th>
	</tr>
	<tr>
		<td>(Task Workorder description)</td>
		<td><?php echo $editor['TaskStat']['target'] ?></td>
		<td><?php echo $this->Wms->shortTime($editor['TaskStat']['work']) ?></td>
		<td><?php echo $this->Wms->rateAsPercent($editor['TaskStat']['day'], $editor['TaskStat']['target']); ?></td>
		<td><?php echo $this->Wms->rateAsPercent($editor['TaskStat']['week'], $editor['TaskStat']['target']); ?></td>
		<td><?php echo $this->Wms->rateAsPercent($editor['TaskStat']['month'], $editor['TaskStat']['target']); ?></td>
	</tr>
</table>