<h2>Workorders</h2>
<?php
	// use actionView = ($workorder['Workorder']['manager_id']==AuthComponent::user(id) );
	echo $this->element('workorders/index', array('actionView' => true)); 
?>

<h2>Activity</h2>
<?php echo $this->element('activity_logs/index'); ?>