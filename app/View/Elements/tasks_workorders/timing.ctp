<?php
	$started = strtotime($tasksWorkorder['TasksWorkorder']['started']);
	$finished = strtotime($tasksWorkorder['TasksWorkorder']['finished']);
	// TODO: due is not set anywhere. use test value for now
	if (($workorder['Workorder']['due'])) $due = strtotime($workorder['Workorder']['due']);
	else $due = $started;
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
						echo  $this->Wms->shortTime($operator_work_time = $tasksWorkorder['TasksWorkorder']['operator_work_time']); 
						if ($operator_work_time) {
							echo $this->Wms->worktimeAsPercent($operator_work_time, $target_time);
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