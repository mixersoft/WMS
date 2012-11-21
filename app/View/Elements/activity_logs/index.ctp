<div class="activity_logs">
<?php if (!$activityLogs): ?>
	<p><em>No activity</em></p>
<?php else: ?>
	<ul class='activity-log'>
		<?php foreach($activityLogs as $activityLog): ?>
		<li>

			<?php if ($activityLog['ActivityLog']['flag_status']): ?>
			<span class="flagged">FLAG</span>
			<?php elseif ($activityLog['ActivityLog']['flag_status'] === false): ?>
			<span class="cleared">CLEAR</span>
			<?php endif; ?>

			<?php
			$output = array();
			if (!empty($activityLog['ActivityLog']['slack_time'])) $output['slack_time'] = "<span class='slack-time'>{$this->Wms->slackTime($activityLog['ActivityLog']['slack_time'])}</span>";
			
			switch ($activityLog['ActivityLog']['model']) {
				case 'Workorder':
					$output['Workorder'] = $this->Html->link(
						'Workorder.' . $activityLog['ActivityLog']['foreign_key'],
						array('controller' => 'workorders', 'action' => 'view', $activityLog['ActivityLog']['foreign_key'])
					);
				break;
				case 'TasksWorkorder':
					$output['TasksWorkorder'] =  $this->Html->link(
						'Task.' . $activityLog['ActivityLog']['foreign_key'],
						array('controller' => 'tasks_workorders', 'action' => 'view', $activityLog['ActivityLog']['foreign_key'])
					);
					$output['Workorder'] = $this->Html->link(
						'Workorder.' . $activityLog['ActivityLog']['workorder_id'],
						array('controller' => 'workorders', 'action' => 'view', $activityLog['ActivityLog']['workorder_id'])
					);
				break;
			}
			
			$output['editor'] = "<span class='editor-name'>{$activityLog['Editor']['username']}</span>";
			$output['created'] = "<span class='age' title='added {$activityLog['ActivityLog']['created']}'>{$this->Wms->shortDate($activityLog['ActivityLog']['created'], 'age')}</span>";
			$output['comment'] = "<p class='comment'>{$activityLog['ActivityLog']['comment']}</p>";
			echo implode('&nbsp;', $output);

			if (!empty($activityLog['FlagComment'])) {
				echo $this->element('activity_logs/flag_comments_list', array('data' => $activityLog['FlagComment']));
			}

			if ($activityLog['ActivityLog']['flag_status'] !== NULL) {
				echo $this->element(
					'activity_logs/flag_comments_add',
					array('flag_id' => $activityLog['ActivityLog']['id'], 'flag_status' => $activityLog['ActivityLog']['flag_status'])
				);
			}
			?>
		</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
</div>