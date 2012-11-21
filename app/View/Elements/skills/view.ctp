<table class='editor-skills'>
	<tr>
		<th>Task</th>
		<th>Target</th>
		<th>Day</th>
		<th>Week</th>
		<th>Month</th>
	</tr>
	<?php foreach ($skills as $skill) :   ?>
	<tr class='skill-row'>
		<td class='label'><?php echo $skill['Task']['name'] ?></td>
		<td class='work-rate target'><?php echo $skill['Task']['target_work_rate'] ?></td>
		<td class='work-rate'><?php echo $this->Wms->rateAsPercent($skill['Skill']['rate_1_day'], $skill['Task']['target_work_rate'] ); ?></td>
		<td class='work-rate'><?php echo $this->Wms->rateAsPercent($skill['Skill']['rate_7_day'], $skill['Task']['target_work_rate'] ); ?></td>
		<td class='work-rate'><?php echo $this->Wms->rateAsPercent($skill['Skill']['rate_30_day'], $skill['Task']['target_work_rate'] ); ?></td>
	</tr>
	<?php endforeach;  ?>
</table>