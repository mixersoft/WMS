<?php 
$host_PES = Configure::read('host.PES');
?>

<div class="activity-log">
<?php if (!$activityLogs): ?>
	<p><em>No activity</em></p>
<?php else: ?>
	<ul class='activity-log'>
		<?php foreach($activityLogs as $activityLog): ?>
		<li class='inline'>
			<?php
			$header = $output = array();
			if ($activityLog['ActivityLog']['flag_status']!== null) {
				$header['flagged'] = "<span class='flag ". ($activityLog['ActivityLog']['flag_status'] ? 'flagged' : 'cleared') ."'>F</span>"; 
			} else $header['flagged'] = '';
			if (!empty($activityLog['ActivityLog']['slack_time'])) $output['slack_time'] = "<span class='slack-time'>{$this->Wms->slackTime($activityLog['ActivityLog']['slack_time'])}</span>";
			
			switch ($activityLog['ActivityLog']['model']) {
				case 'Workorder':
					$header['Workorder'] = $this->Html->link(
						'Workorder.' . $activityLog['ActivityLog']['foreign_key'],
						array('controller' => 'workorders', 'action' => 'view', $activityLog['ActivityLog']['foreign_key'])
					);
				break;
				case 'TasksWorkorder':
					$header['TasksWorkorder'] =  $this->Html->link(
						'Task.' . $activityLog['ActivityLog']['foreign_key'],
						array('controller' => 'tasks_workorders', 'action' => 'view', $activityLog['ActivityLog']['foreign_key'])
					);
					$header['Workorder'] = $this->Html->link(
						'Workorder.' . $activityLog['ActivityLog']['workorder_id'],
						array('controller' => 'workorders', 'action' => 'view', $activityLog['ActivityLog']['workorder_id'])
					);
				break;
			}
			$header['created'] = "<span class='age' title='added {$activityLog['ActivityLog']['created']}'>{$this->Wms->shortDate($activityLog['ActivityLog']['created'], 'age')}</span>";
			
			
			$editor['link'] = "/editors/all/editor_id:{$activityLog['Editor']['id']}";
			$editor['badge'] = $this->Html->image(
				Stagehand::getSrc($activityLog['Editor']['User']['src_thumbnail'], 'sq', 'Person'), 
				array(
					'title'=>"{$activityLog['Editor']['username']}",
					'width'=>'48px', 'height'=>'48px',
				)
			); 
			$output['badge'] = "<div class='aside'><a href='{$editor['link']}'>{$editor['badge']}</a></div>";
			$output['header'] = "<div class='header'>".implode('&nbsp;', $header)."</div>"; 
			$output['body'] = "<div class='comment'>{$activityLog['ActivityLog']['comment']}</div>";
			
			if (!empty($activityLog['FlagComment'])) {
				$output['child'] =  $this->element('activity_logs/flag_comments_list', array('data' => $activityLog['FlagComment']));
			} else $output['child'] = "";
			
			if ($activityLog['ActivityLog']['flag_status'] !== NULL) {
				$output['flag-comment'] = $this->element(
					'activity_logs/flag_comments_add',
					array('flag_id' => $activityLog['ActivityLog']['id'], 'flag_status' => $activityLog['ActivityLog']['flag_status'])
				);
			} else $output['flag-comment'] = "";
			
			
			
			echo "{$output['badge']}<div class='body'>{$output['header']}{$output['body']}{$output['child']}{$output['flag-comment']}</div>"; 
			?>
		</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
</div>