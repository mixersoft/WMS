<h2>Operators</h2>

<?php 
	$actionExpand = empty($this->passedArgs['id']);
	foreach ($editors as $editor): ?>
	<?php echo $this->element('editors/view', array('editor' => $editor, 'actionExpand'=>$actionExpand)); ?>
<?php endforeach; ?>