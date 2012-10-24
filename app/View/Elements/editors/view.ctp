<h3><?php echo $editor['Editor']['username']; ?></h3>
<div class='editor-profile-badge'>
<?php   	
			$badge['editor'] = $this->Html->image(
				Stagehand::getSrc($editor['Client']['src_thumbnail'], $size, 'Person'), 
				array(
					'title'=>"editor: {$editor['Client']['username']}",
					'width'=>'75px', 'height'=>'75px',
					)
			); 
			$badge['editor'] = $this->Html->link(
				$badge['editor'],
				"http://{$host_PES}/person/home/{$editor['Client']['id']}",
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
		<td><?php echo $editor['Stat']['avail_24'] ?></td>
		<td><?php echo $editor['Stat']['busy_24'] ?></td>
		<td><?php echo $editor['Stat']['slack'] ?></td>
		<td><?php echo $editor['Stat']['assigned'] ?></td>
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
		<td>xxxxxxxxxxx</td>
		<td><?php echo $editor['Stat']['target'] ?></td>
		<td><?php echo $editor['Stat']['work'] ?></td>
		<td><?php echo $editor['Stat']['day'] ?></td>
		<td><?php echo $editor['Stat']['week'] ?></td>
		<td><?php echo $editor['Stat']['month'] ?></td>
	</tr>
</table>