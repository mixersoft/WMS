<!DOCTYPE HTML>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
	echo $this->Html->meta('icon');
	echo $this->Html->css(array('cake.generic', 'default'));
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
				<?php endif; ?>
			</div>
		</div>
		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			Footer
		</div>
	</div>
</body>
</html>