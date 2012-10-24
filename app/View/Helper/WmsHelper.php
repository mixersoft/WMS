<?php

//App::uses('Helper', 'View');
App::uses('Helper/Time', 'View');

class WmsHelper extends AppHelper {

	public $_view;

	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		$this->_view = $view;
	}

	public function slackTime($timeInSeconds) {
		$Time = New TimeHelper($this->_view);
		if ($timeInSeconds < 0) {
			$class = 'red';
		} elseif ($timeInSeconds < (60 * 60 * YELLOW_STATUS_HOUR_LIMIT) ) {
			$class = 'yellow';
		} else {
			$class = 'green';
		}
		$timeAgo = $Time->timeAgoInWords(date('Y-m-d H:i:s', date('U') + $timeInSeconds), array('end' => '10 years'));
		$timeAgo = str_replace(',', '', $timeAgo);
		return '<span class="slack-time-' . $class . '"> ' . $timeAgo . '</span>';
	}

}