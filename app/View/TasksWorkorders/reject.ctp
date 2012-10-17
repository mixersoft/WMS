<h2>Task rejection</h2>
<?php
echo $this->Form->create('TasksWorkorder', array('url' => array('action' => 'reject', $taskWorkorderId)));
echo $this->Form->input('reason', array('type' => 'textarea'));
?>
<input type="submit" value="Submit">
</form>