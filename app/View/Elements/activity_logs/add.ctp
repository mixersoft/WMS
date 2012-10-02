<h3>Add comment</h3>
<?php
echo $this->Form->create('ActivityLog', array('controller' => 'activity_logs', 'action' => 'add'));
echo $this->Form->input('comment', array('label' => false));
echo $this->Form->input('model', array('value' => $model, 'type' => 'hidden'));
echo $this->Form->input('foreign_key', array('value' => $foreign_key, 'type' => 'hidden'));
echo $this->Form->input('editor_id', array('value' => AuthComponent::user('id'), 'type' => 'hidden'));
echo $this->Form->end('Add Comment');
?>