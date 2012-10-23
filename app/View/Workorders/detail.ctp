<?php echo $this->element('PES_preview', array('model' => 'AssetsWorkorder', 'workorder'=>$workorder)); ?>
<br>
<h3>Tasks</h3>
<?php echo $this->element('tasks_workorders/index', array('actionView' => true, 'actionExpand' => false)); ?>