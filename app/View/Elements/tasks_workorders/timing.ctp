<?php
	$started = strtotime($tasksWorkorder['TasksWorkorder']['started']);
	$finished = strtotime($tasksWorkorder['TasksWorkorder']['finished']);
	$due = strtotime($tasksWorkorder['Workorder']['due']);
?>
<fieldset>
	<legend>Timing</legend>
	<ul>
		<li>
			Start Time: <?php if ($started) echo $tasksWorkorder['TasksWorkorder']['started']; ?>
			<ul>
				<li>Slack: <?php if ($started) {
							$slack_time =  $due -  ($started + $tasksWorkorder['TasksWorkorder']['target_work_time']);
							echo  $this->Wms->slackTime($slack_time);
				} ?></li>
			</ul>
		</li>
		<li>
			Work Time: 
			<ul>
				<li>Target: <?php echo  $this->Wms->shortTime($target_time = $tasksWorkorder['TasksWorkorder']['target_work_time']); ?></li>
				<li>Assigned: <?php 
						echo  $this->Wms->shortTime($assigned_time = $tasksWorkorder['TasksWorkorder']['operator_work_time']); 
						if ($assigned_time) {
							$pct = ($assigned_time - $target_time)/$target_time*100;
							$class = $pct>0 ? 'red' : 'green';
							echo " <span class=\"work-time-{$class}\">({$pct}%)</span>";
						}
					?></li>
				
			</ul>
		</li>
		<li>
			Finish Time: <?php if ($finished) echo $tasksWorkorder['TasksWorkorder']['finished']; ?>
			<ul>
				<li>Slack: <?php if ($finished) echo  $this->Wms->slackTime($due - $finished); ?></li>
			</ul>
		</li>
	</ul>
</fieldset>