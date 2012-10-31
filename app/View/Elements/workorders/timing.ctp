<?php
	$started = strtotime($workorder['Workorder']['started']);
	$finished = strtotime($workorder['Workorder']['finished']);
	$due = strtotime($workorder['Workorder']['due']);
?>
<fieldset>
	<legend>Timing</legend>
	<ul>
		<li>
			Start Time: <?php if ($started) echo $workorder['Workorder']['started']; ?>
			<ul>
				<li>Slack: <?php if ($started) {
							$slack_time =  $due -  ($started + $workorder['Workorder']['target_work_time']);
							echo  $this->Wms->slackTime($slack_time);
				} ?></li>
			</ul>
		</li>
		<li>
			Work Time: 
			<ul>
				<li>Target: <?php echo  $this->Wms->shortTime($target_time = $workorder['Workorder']['target_work_time']); ?></li>
				<li>Assigned: <?php 
						echo  $this->Wms->shortTime($operator_work_time = $workorder['Workorder']['operator_work_time']); 
						if ($operator_work_time) {
							echo $this->Wms->worktimeAsPercent($operator_work_time, $target_time);
						}
					?></li>
				
			</ul>
		</li>
		<li>
			Finish Time: <?php if ($finished) echo $workorder['Workorder']['finished']; ?>
			<ul>
				<li>Slack: <?php if ($finished) echo  $this->Wms->slackTime($due - $finished); ?></li>
			</ul>
		</li>
	</ul>
</fieldset>