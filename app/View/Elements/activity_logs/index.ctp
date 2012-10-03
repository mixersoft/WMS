<?php if (!$activityLogs): ?>
	<p><em>No activity</em></p>
<?php else: ?>
	<ul>
		<?php foreach($activityLogs as $activityLog): ?>
		<li>
			<?php
			switch ($activityLog['ActivityLog']['model']) {
				case 'Workorder':
					echo $this->Html->link(
						'Workorder.' . $activityLog['ActivityLog']['foreign_key'],
						array('controller' => 'workorders', 'action' => 'view', $activityLog['ActivityLog']['foreign_key'])
					) . ' ';
				break;
				case 'TasksWorkorder':
					echo $this->Html->link(
						'Task.' . $activityLog['ActivityLog']['foreign_key'],
						array('controller' => 'tasks_workorders', 'action' => 'view', $activityLog['ActivityLog']['foreign_key'])
					) . ' ';
				break;
			}
			echo '<em>' . $activityLog['Editor']['username'] . '</em> '
				. '<strong title="' . $activityLog['ActivityLog']['created'] . '">'
				. $this->Time->timeAgoInWords($activityLog['ActivityLog']['created'])
				. '</strong> ' . $activityLog['ActivityLog']['comment'];
			?>
		</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>