<h2>Workorder rejection</h2>
<?php
echo $this->Form->create('Workorder', array('url' => array('action' => 'reject', $workorderId)));
echo $this->Form->input('reason', array('type' => 'textarea'));
?>
<input type="submit" value="Submit">
</form>