<table class='table editor-skills'>
	<thead>
	<tr class=''>
		<th>Task</th>
		<th>Target</th>
		<th>Day</th>
		<th>Week</th>
		<th>Month</th>
	</tr>
	</thead>
		<tbody>
	<?php foreach ($skills as $skill) :   ?>
	<tr class='skill-row'>
		<td>
			<span class='label label-small'><?php echo $skill['Task']['name'] ?></span>
		</td>
		<td class='work-rate target'><?php echo $skill['Task']['target_work_rate'] ?></td>
		<td class='work-rate'><?php echo $this->Wms->rateAsPercent($skill['Skill']['rate_1_day'], $skill['Task']['target_work_rate'] ); ?></td>
		<td class='work-rate'><?php echo $this->Wms->rateAsPercent($skill['Skill']['rate_7_day'], $skill['Task']['target_work_rate'] ); ?></td>
		<td class='work-rate'><?php echo $this->Wms->rateAsPercent($skill['Skill']['rate_30_day'], $skill['Task']['target_work_rate'] ); ?></td>
	</tr>
	<?php endforeach;  ?>
		</tbody>
</table>