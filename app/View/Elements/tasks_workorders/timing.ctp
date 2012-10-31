<fieldset>
	<legend>Timing</legend>
	<ul>
		<li>
			Start Time: xxxxx
			<ul>
				<li>Slack: xxxxxx</li>
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
			Finish Time: xxxxxxx
			<ul>
				<li>Slack: xxxxxx</li>
			</ul>
		</li>
	</ul>
</fieldset>