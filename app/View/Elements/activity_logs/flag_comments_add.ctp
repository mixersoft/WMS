<h3>Add comment</h3>
<?php
echo $this->Form->create('ActivityLog', array('controller' => 'activity_logs', 'action' => 'add_flag_comment'));
echo $this->Form->input('comment', array('label' => false));
echo $this->Form->input('flag_id', array('value' => $flag_id));
echo $this->Form->input('editor_id', array('value' => AuthComponent::user('id'), 'type' => 'hidden'));
?>

<button type="submit" value="1" name="data[ActivityLog][flag_status]" class="flag">Comment and flag</button>
<button type="submit" value="0" name="data[ActivityLog][flag_status]">Comment</button>

</form>