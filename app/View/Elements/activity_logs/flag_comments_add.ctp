<div class="flag comment-form">
	<h4>Add comment to this Flag</h4>
	<?php
	echo $this->Form->create('ActivityLog', array(
		'url' => array('controller' => 'activity_logs', 'action' => 'add', $flag_id),
		'inputDefaults' => array(
			'div' => 'control-group',
			'label' => array('class' => 'control-label'),
			'between' => '<div class="controls">',
			'after' => '</div>',
			'class' => 'span3',
			'error' => array(
				'attributes' => array('wrap' => 'div', 'class' => 'alert alert-error')
			)
		)
	));
	echo $this->Form->input('comment', array(
		'label' => false,
		'after' => '<span class = \'help-inline\'>help</span></div>'
	));
	echo $this->Form->input('flag_id', array(
		'value' => $flag_id, 
		'type' => 'hidden',
		'after' => '<span class = \'help-inline\'>help</span></div>'
	));
	echo $this->Form->input('editor_id', array(
		'value' => AuthComponent::user('id'), 
		'type' => 'hidden',
		'after' => '<span class = \'help-inline\'>help</span></div>'
	));
	?>
	<div class='actions inline'>
	<button type="submit" class="btn btn-primary">Comment</button>
	<?php if ($flag_status == 1): ?>
	<button type="submit" value="0" name="data[ActivityLog][parent_flag_status]" class="btn btn-success">
		<i class="fa fa-flag-o"></i>
		Comment
	</button>
	<?php else: ?>
	<button type="submit" value="1" name="data[ActivityLog][parent_flag_status]" class="btn btn-danger">
		<i class="fa fa-flag"></i> Comment
	</button>
	<?php endif; ?>
	</div>
	</form>
</div>