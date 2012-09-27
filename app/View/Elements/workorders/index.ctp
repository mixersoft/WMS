<table>
	<tr>
		<th>id</th>
		<th>slack_time</th>
		<th>status</th>
		<th>description</th>
		<th>owner</th>
		<th>worktime</th>
	</tr>
<?php foreach ($workorders as $workorder): ?>
	<tr>
		<td><?php echo $workorder['id']; ?></td>
		<td><?php echo gmdate('d\d H\h i\m', $workorder['slack_time']); ?></td>
		<td><?php echo $workorder['status']; ?></td>
		<td><?php echo $workorder['description']; ?></td>
		<td><?php echo $workorder['owner']; ?></td>
		<td><?php echo gmdate('H\h i\m', $workorder['worktime']); ?></td>
	</tr>
<?php endforeach; ?>
</table>