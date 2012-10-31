<fieldset>
	<legend>Timing</legend>
	<ul>
		<li>
			Start Time: <?php echo $workorder['Workorder']['started']; ?>
			<ul>
				<li>Slack: <?php echo $workorder['Workorder']['slack_time']; ?></li>
			</ul>
		</li>
		<li>
			Work Time: 
			<ul>
				<li>Target: <?php echo  $this->Wms->shortTime($target_time = $workorder['Workorder']['target_work_time']); ?></li>
				<li>Assigned: <?php 
						echo  $this->Wms->shortTime($assigned_time = $workorder['Workorder']['operator_work_time']); 
						if ($assigned_time) {
							$pct = ($assigned_time - $target_time)/$target_time*100;
							$class = $pct>0 ? 'red' : 'green';
							echo " <span class=\"work-time-{$class}\">({$pct}%)</span>";
						}
					?></li>
				
			</ul>
		</li>
		<li>
			Finish Time: <?php echo $workorder['Workorder']['finished']; ?>
			<ul>
				<li>Slack: xxxxxx</li>
			</ul>
		</li>
	</ul>
</fieldset>