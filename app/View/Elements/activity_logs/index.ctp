<div class="activity_logs">
<?php if (!$activityLogs): ?>
	<p><em>No activity</em></p>
<?php else: ?>
	<ul>
		<?php foreach($activityLogs as $activityLog): ?>
		<li>

			<?php if ($activityLog['ActivityLog']['flag_status']): ?>
			<span class="flagged">FLAG</span>
			<?php elseif ($activityLog['ActivityLog']['flag_status'] === false): ?>
			<span class="cleared">CLEAR</span>
			<?php endif; ?>

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

			if (!empty($activityLog['FlagComment'])) {
				echo $this->element('activity_logs/flag_comments_list', array('data' => $activityLog['FlagComment']));
			}

			if ($activityLog['ActivityLog']['flag_status']) {
				echo $this->element('activity_logs/flag_comments_add', array('flag_id' => $activityLog['ActivityLog']['id']));
			}
			?>
		</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
</div>