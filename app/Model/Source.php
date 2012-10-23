<?php

class Source extends AppModel {
	public $useTable = 'workorder_sources';		// set to 'users' or 'groups' depending on Workorder.source_model
	public $displayField = 'label';
	

}