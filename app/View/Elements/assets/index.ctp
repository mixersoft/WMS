<div class='preview'>
	<ul class='inline'>
	<?php foreach ($assets as $asset): ?>
		<li>
			<img src="<?php echo $asset[$model]['URL']; ?>" title="asset id: <?php echo $asset[$model]['asset_id']; ?>">
		</li>
	<?php endforeach; ?>
	</ul>
</div>