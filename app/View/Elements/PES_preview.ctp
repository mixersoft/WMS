<?php
		/**
		 * configure access to PES for desplaying preview Badge
		 * @param $workorder aa, either Workorder record with Contains 'Source', 'Client', from Model->getAll()
		 *	Notes:
		 * 		- this element is called by /workorders/view, /workorders/detail, /tasks_workorders/view, /tasks_workorders/detail
		 * 		- links are to PES site  
		 */
		$host_PES = Configure::read('host.PES');
		$size = "sq";
		$badge_type = $workorder['Source']['model_name'] == ' User' ? 'Person' : $workorder['Source']['model_name'];
		$badge['source'] = $this->Html->image(
			Stagehand::getSrc($workorder['Source']['src_thumbnail'], $size, $badge_type), 
			array(
				'title'=>"source: {$workorder['Source']['label']}, id={$workorder['Source']['id']}",
				'class'=>'badge-tiny source', 
				'width'=>'33px', 'height'=>'33px',
			)
		); 
		$badge['source'] = $this->Html->link(
			$badge['source'],
			"http://{$host_PES}/{$workorder['Source']['controller']}/home/{$workorder['Source']['id']}",
			array('target'=>'_blank', 'escape'=>false)
		);
		if ($workorder['Source']['id'] == $workorder['Client']['id']) {
			$badge['client'] = "";			//client == source			 
		} else {
			$badge['client'] = $this->Html->image(
				Stagehand::getSrc($workorder['Client']['src_thumbnail'], $size, 'Person'), 
				array(
					'title'=>"client: {$workorder['Client']['username']}, id={$workorder['Client']['id']}",
					'class'=>'badge-tiny client', 
					'width'=>'33px', 'height'=>'33px',
					)
			); 
			$badge['client'] = $this->Html->link(
				$badge['client'],
				"http://{$host_PES}/person/home/{$workorder['Client']['id']}",
				array('target'=>'_blank', 'escape'=>false)
			);			
		}
?>
<div class='pes-preview inline'>
	<div class='badges aside'>
		<?php echo $badge['source']; ?> &nbsp; <?php echo $badge['client']; ?>
		</div>
	<?php 
	echo $this->element('assets/index', array('model' => $model));
	?>
</div>

