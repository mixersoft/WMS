<div id="assets">
	<ul>
	<?php foreach ($assets as $asset): ?>
		<li>
			<img src="http://lorempixel.com/105/70/people/<?php echo rand(1, 10); ?>"
				title="asset id: <?php echo $asset[$model]['asset_id']; ?>">
		</li>
	<?php endforeach; ?>
	</ul>
</div>