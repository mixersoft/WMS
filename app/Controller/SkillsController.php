<?php

class SkillsController extends AppController {

	public $scaffold;
	
	/**
	* list of skills and assigned tasks for editor
	*/
	public function all($editor_id=null) {
		if ($this->request->is('ajax')) $this->layout = 'ajax';
		$editor_id = $editor_id ? $editor_id : $this->passedArgs['editor_id'];
		$skills = $this->Skill->getAll($this->passedArgs);
		$assignedTasks = $this->Skill->Editor->addAssignedTasks($skills);
		$this->Skill->Editor->calculateBusyStats($skills, $assignedTasks);
// debug($skills);		
		$host_PES = Configure::read('host.PES');
		$size='sq';
		$this->set(compact('skills', 'assignedTasks', 'size', 'host_PES'));
	}
	

}