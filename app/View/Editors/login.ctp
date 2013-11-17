<?php
/*
 * NOTE: add ?auto to get login buttons. see /layouts/default.ctp
 */
echo $this->Form->create(null, array(
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
echo $this->Form->input('username', array(
		'label' => false,
		'after' => '<span class = \'help-inline\'>Username</span></div>'
	));
echo $this->Form->input('password', array(
		'label' => false,
		'after' => '<span class = \'help-inline\'>Password</span></div>'
	));
echo $this->Form->end(__('Login'));
?>