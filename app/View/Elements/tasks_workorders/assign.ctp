<?php
echo $this->Form->create('TasksWorkorder', array('url' => array('controller' => 'tasks_workorders', 'action' => 'assign', $tasks_workorder_id)));
echo $this->Form->input('TasksWorkorder.operator_id', array('label' => false, 'empty' => '- choose', 'div' => null));
?>

<input type="submit" value="Assign">
</form>