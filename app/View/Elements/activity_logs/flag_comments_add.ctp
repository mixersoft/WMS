<div class="comment-flag">
<h4>Add comment to this Flag</h4>
<?php
echo $this->Form->create('ActivityLog', array('url' => array('controller' => 'activity_logs', 'action' => 'add', $flag_id)));
echo $this->Form->input('comment', array('label' => false));
echo $this->Form->input('flag_id', array('value' => $flag_id, 'type' => 'hidden'));
echo $this->Form->input('editor_id', array('value' => AuthComponent::user('id'), 'type' => 'hidden'));
?>

<button type="submit" value="0" name="data[ActivityLog][clear_flag]">Comment</button>
<button type="submit" value="1" name="data[ActivityLog][clear_flag]" class="clear-flag">Comment and clear flag</button>

</form>
</div>