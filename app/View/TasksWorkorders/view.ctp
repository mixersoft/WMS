<?php $tasksWorkorder = $tasksWorkorders[0]; ?>
<h2>Workorder</h2>
<?php
	// debug($tasksWorkorder);			echo $this->element('tasks_workorders/workorder_parent', array('actionView' => true, 'wo_parent'=>$tasksWorkorder));
	$status = $tasksWorkorder['TasksWorkorder']['status'];
	$PES_baseurl = 'http://' . Configure::read('host.PES') ;
	$allowedUsers = array($tasksWorkorder['TasksWorkorder']['operator_id'], $tasksWorkorder['Workorder']['manager_id']);
	$hasPermission = in_array(AuthComponent::user('id'), $allowedUsers);
?>

<div class="sidebar">
	<fieldset>
	<legend>Actions</legend>
	<ul class="actions">
		<li>
			<?php
				$disabled = $status=='Working'; 
				echo $this->Html->link(
					__('Start work'),
					array('controller' => 'tasks_workorders', 'action' => 'change_status', $tasksWorkorder['TasksWorkorder']['id'], 'Working'), 
					array('class'=>($disabled ? 'disabled' : '') )
				); ?>
		</li>
		<li>
			<?php 
				$disabled = $status!='Working'; 
				echo $this->Html->link(
					__('Pause work'),
					array('controller' => 'tasks_workorders', 'action' => 'change_status', $tasksWorkorder['TasksWorkorder']['id'], 'Paused'), 
					array('class'=>($disabled ? 'disabled' : '') )
				); ?>			
		</li>
		<li>
			<?php 
				$disabled = in_array($status, array('New', 'Done')); 
				echo $this->Html->link(
					__('Done'),
					array('controller' => 'tasks_workorders', 'action' => 'change_status', $tasksWorkorder['TasksWorkorder']['id'], 'Done'), 
					array('class'=>($disabled ? 'disabled' : '') )
				); ?>			
			
		</li>
		<li>
			<?php echo $this->Html->link(
				'Reject',
				array('controller' => 'tasks_workorders', 'action' => 'reject', $tasksWorkorder['TasksWorkorder']['id'])
			); ?>
		</li>
	</ul>
	<ul class="actions">
		<li>
		<?php 
			$disabled = !$hasPermission || $status!='Working'; 
			$target = $hasPermission ? "{$PES_baseurl}/tasks_workorders/shots/" . $tasksWorkorder['TasksWorkorder']['id'] . '/wide:1' : '' ; 
			$link = $this->Html->link(
				__('Review Shots'), 
				$target, 
				array('target' => '_blank', 'class'=>($disabled ? 'disabled' : '') , 'onclick'=>"return !$disabled;")
			);	
			echo $link; 
		?>
		</li>
		<li>
		<?php 
			$disabled = !$hasPermission || $status!='Working'; 
			$target = $hasPermission ? "{$PES_baseurl}/tasks_workorders/photos/" . $tasksWorkorder['TasksWorkorder']['id'] . '/wide:1' : ''; 
			$link = $this->Html->link(
				__('Add Shots'), 
				$target, 
				array('target' => '_blank', 'class'=>($disabled ? 'disabled' : '') , 'onclick'=>"return !$disabled;")
			);	
			echo $link; 
		?>
		</li>		
		<li>
		<?php 
			$disabled = !$hasPermission || $status!='Working'; 
			$target = $hasPermission ? "{$PES_baseurl}/tasks_workorders/photos/" . $tasksWorkorder['TasksWorkorder']['id'] . '/wide:1/raw:1' : ''; 
			$link = $this->Html->link(
				__('Rate Snaps'), 
				$target, 
				array('target' => '_blank', 'class'=>($disabled ? 'disabled' : '') , 'onclick'=>"return !$disabled;")
			);	
			echo $link; 
		?>
		</li>		
		<li><?php
				$disabled = !$hasPermission || $status=='Done';  
				echo $this->element('tasks_workorders/form_harvest', array('tasksWorkorder'=>$tasksWorkorder, 'disabled'=>$disabled)); 
			?></li>
	</ul>
	</fieldset>	
<?php echo $this->element('tasks_workorders/timing', array('tasksWorkorder' => $tasksWorkorder)); ?>
<?php echo $this->element('tasks_workorders/status', array('tasksWorkorder' => $tasksWorkorder)); ?>
</div>

<br />

<h3>Comments and Activity</h3>
<?php echo $this->element('activity_logs/index'); ?>
<br />
<?php echo $this->element('activity_logs/add', array('model' => 'TasksWorkorder', 'foreign_key' => $tasksWorkorder['TasksWorkorder']['id'])); ?>