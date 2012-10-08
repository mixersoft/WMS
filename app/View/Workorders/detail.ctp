<?php echo $this->element('assets/index', array('model' => 'AssetsWorkorder')); ?>
<h3>Tasks</h3>
<?php echo $this->element('tasks_workorders/index', array('actionView' => true, 'actionExpand' => false)); ?>