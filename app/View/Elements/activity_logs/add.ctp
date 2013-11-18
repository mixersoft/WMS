<div class='comment-form'>
	<h3>Add comment to this <?php echo ($model == 'Workorder') ? 'Workorder' : 'Task'; ?></h3>
	
	<?php
	echo $this->Form->create('ActivityLog', array(
		'controller' => 'activity_logs', 
		'action' => 'add',
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
	echo $this->Form->input('model', array(
		'value' => $model, 
		'type' => 'hidden',
		'after' => '<span class = \'help-inline\'>help</span></div>'
	));
	echo $this->Form->input('foreign_key', array(
		'value' => $foreign_key, 
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
	<button type="submit" value="1" name="data[ActivityLog][flag_status]" class="btn btn-danger">
		<i class="fa fa-flag"></i> 
		Comment
	</button>
	</div>
	</form>
</div>