<?php
//echo AuthComponent::password('123');
echo $this->Form->create();
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->end(__('Login'));
?>