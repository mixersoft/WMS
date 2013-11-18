<!DOCTYPE HTML>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
	echo $this->Html->meta('icon');
	echo $this->Html->css(array('cake.generic', 'wms'));
	echo $this->Html->script(array('jquery-1.8.2.min', 'wms'));
	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link('WMS', '/'); ?></h1>
			<div id="editor-data">
				<?php if (AuthComponent::user('id')): ?>
				Welcome <?php echo AuthComponent::user('username'); ?> (role: <?php echo AuthComponent::user('role'); ?>)
				<?php echo $this->Html->link('Logout', array('controller' => 'editors', 'action' => 'logout')); ?>
				<?php elseif (isset($this->request->query['auto'])): ?>
					<p class="actions">
						<?php echo $this->Html->link('Login as manager', array('controller' => 'editors', 'action' => 'login', 'editor_id' => 4)); ?>
						<?php echo $this->Html->link('Login as operator', array('controller' => 'editors', 'action' => 'login', 'editor_id' => 3)); ?>
					</p>
				<?php endif; ?>
			</div>
		</div>
		<?php if (AuthComponent::user('id')): ?>
		<div id="menu" class="editor-<?php echo AuthComponent::user('role')?>">
			<ul class="actions inline">
				<li><?php echo $this->Html->link(__('Dashboard'), array('controller' => 'workorders', 'action' => 'dashboard')); ?></li>
				<li><?php echo $this->Html->link(__('Workorders'), array('controller' => 'workorders', 'action' => 'all')); ?></li>
				<li><?php echo $this->Html->link(__('Tasks'), array('controller' => 'tasks_workorders', 'action' => 'all')); ?></li>
				<li><?php echo $this->Html->link(__('Activity'), array('controller' => 'activity_logs', 'action' => 'all')); ?></li>
				<li><?php echo $this->Html->link(__('Team'), array('controller' => 'editors', 'action' => 'all')); ?></li>
			</ul>
		</div>
		<?php endif; ?>
		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<p>Footer</p>
		</div>
	</div>
</body>
</html>