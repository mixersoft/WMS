<table>
	<tr>
		<th>id</th>
		<th>slack_time</th>
		<th>status</th>
		<th>description</th>
		<th>owner</th>
		<th>work_time</th>
	</tr>
<?php foreach ($workorders as $workorder): ?>
	<tr>
		<td><?php echo $workorder['Workorder']['id']; ?></td>
		<td><?php echo gmdate('d\d H\h i\m', $workorder['Workorder']['slack_time']); ?></td>
		<td><?php echo $workorder['Workorder']['status']; ?></td>
		<td><?php echo $workorder['Workorder']['description']; ?></td>
		<td><?php echo $workorder['Manager']['username']; ?></td>
		<td><?php echo gmdate('H\h i\m', $workorder['Workorder']['work_time']); ?></td>
	</tr>
<?php endforeach; ?>
</table>