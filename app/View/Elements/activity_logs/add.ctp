<h3>Add comment to this Task</h3>
<?php
echo $this->Form->create('ActivityLog', array('controller' => 'activity_logs', 'action' => 'add'));
echo $this->Form->input('comment', array('label' => false));
echo $this->Form->input('model', array('value' => $model, 'type' => 'hidden'));
echo $this->Form->input('foreign_key', array('value' => $foreign_key, 'type' => 'hidden'));
echo $this->Form->input('editor_id', array('value' => AuthComponent::user('id'), 'type' => 'hidden'));
?>

<button type="submit" value="1" name="data[ActivityLog][flag_status]" class="flag">Comment and flag</button>
<button type="submit" value="0" name="data[ActivityLog][flag_status]">Comment</button>

</form>