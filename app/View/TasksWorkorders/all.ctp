<h2>Tasks</h2>
<?php
echo $this->element('tasks_workorders/index', array('actionView' => true));
?>

<h2>Activity</h2>
<?php echo $this->element('activity_logs/index'); ?>