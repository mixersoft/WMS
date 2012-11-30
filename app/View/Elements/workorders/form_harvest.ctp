<form 
	accept-charset="utf-8" 
	method="post" 
	id="WorkorderHarvestForm" 
	action=<?php   echo  "'".Router::url('/workorders/harvest')."'";   ?>>
		<input type="hidden" id="WorkorderId" value="<?php echo $workorder['id']; ?>" name="data[Workorder][id]">
		<input type="hidden" id="WorkorderSourceModel" value="<?php echo $workorder['source_model']; ?>" name="data[Workorder][source_model]">
		<input type="hidden" id="WorkorderSourceId" value="<?php echo $workorder['source_id']; ?>" name="data[Workorder][source_id]">
		<?php 
			$attr = ($disabled ? "class='disabled' onclick='return false'" : ''); 
			echo "<button type='submit' {$attr} >".__('Sync')."</button>";
		?>
</form>