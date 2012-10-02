<?php if (!$activityLogs): ?>
	<p><em>No activity</em></p>
<?php else: ?>
	<ul>
		<?php foreach($activityLogs as $activityLog): ?>
		<li>
			<?php
			if ($activityLog['ActivityLog']['model'] == 'Workorder') {
				echo $this->Html->link(
					'Workorder.' . $activityLog['ActivityLog']['foreign_key'],
					array('controller' => 'workorders', 'action' => 'view', $activityLog['ActivityLog']['foreign_key'])
				) . ' ';
			}
			echo '<em>' . $activityLog['Editor']['username'] . '</em> '
				. '<strong>' . $this->Time->timeAgoInWords($activityLog['ActivityLog']['created']) . '</strong> '
				. $activityLog['ActivityLog']['comment'];
			?>
		</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>