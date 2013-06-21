<?php
/*
 * NOTE: add ?auto to get login buttons. see /layouts/default.ctp
 */
echo $this->Form->create();
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->end(__('Login'));
?>