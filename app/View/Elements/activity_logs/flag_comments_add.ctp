<div class="flag comment-form">
	<h4>Add comment to this Flag</h4>
	<?php
	echo $this->Form->create('ActivityLog', array('url' => array('controller' => 'activity_logs', 'action' => 'add', $flag_id)));
	echo $this->Form->input('comment', array('label' => false));
	echo $this->Form->input('flag_id', array('value' => $flag_id, 'type' => 'hidden'));
	echo $this->Form->input('editor_id', array('value' => AuthComponent::user('id'), 'type' => 'hidden'));
	?>
	
	<button type="submit" class="gray">Comment</button>
	<?php if ($flag_status == 1): ?>
	<button type="submit" value="0" name="data[ActivityLog][parent_flag_status]" class="green">Comment and clear flag</button>
	<?php else: ?>
	<button type="submit" value="1" name="data[ActivityLog][parent_flag_status]" class="red">Comment and raise flag</button>
	<?php endif; ?>
	</form>
</div>