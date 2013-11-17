<h2>Workorder rejection</h2>
<?php
echo $this->Form->create('Workorder', array(
	'url' => array('action' => 'reject', $workorderId),
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
echo $this->Form->input('reason', array(
	'type' => 'textarea',
	'after' => '<span class = \'help-inline\'>help</span></div>'
));
?>
<input type="submit" value="Submit">
</form>