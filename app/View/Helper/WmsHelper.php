<?php

class WmsHelper extends AppHelper {


	/**
	* converts a time in seconds to a date in format "1d 10h 45m" with css classes indicating the status
	*/
	public function slackTime($timeInSeconds) {
		if ($timeInSeconds < 0) {
			$class = 'red';
		} elseif ($timeInSeconds < (60 * 60 * YELLOW_STATUS_HOUR_LIMIT) ) {
			$class = 'yellow';
		} else {
			$class = 'green';
		}
		$timeAgo = CakeTime::timeAgoInWords(date('Y-m-d H:i:s', date('U') + $timeInSeconds), array('end' => '10 years'));
		$timeAgo = str_replace(',', '', $timeAgo);
		return '<span class="slack-time slack-' . $class . '"> ' . $timeAgo . '</span>';
	}

	/**
	* converts a time in seconds to a date in format "1d 10h 45m" 
	*/
	public function shortTime($timeInSeconds) {
		if (!$timeInSeconds) return '';
		$timeAgo = CakeTime::timeAgoInWords(date('Y-m-d H:i:s', date('U') + $timeInSeconds), array('end' => '10 years'));
		$timeAgo = str_replace(',', '', $timeAgo);
		return "<span class='work-time'>{$timeAgo}</span>";
	}
	/**
	 * same as rateAsPercent, but result is in ()
	 */
	public function worktimeAsPercent($actual, $target){
		$pct = number_format( -1 * ($actual-$target)/$target*100, 1);
		$pct = sprintf("%+d",$pct);
		$class = $pct > 0 ? 'red' : 'green'; 	// lower is better
		echo " <span class=\"work-time {$class}\">({$pct}%)</span>";
	}
	/**
	 * show productivity rate as percent, color coded, red is bad, green is good 
	 * 	@param actual float, the operator workrate for given task, in same units as target
	 *  @param target float, the target workorder for all operators for given task 	
	 */
	public function rateAsPercent($actual, $target){
		if ($actual==0) echo "<span class=\"work-rate\">--</span>";
		else {
			$pct = number_format( -1 * ($actual-$target)/$target*100, 1);
			$pct = sprintf("%+d%%",$pct);
			$class = $pct > 0 ? 'red' : 'green'; 	// lower is better, takes less time
			echo "<span class=\"work-rate {$class}\">{$pct}</span>";
		}	
	}
	/**
	* converts a string from the format 1111100 to the format of days with checkoxes cheched if that day is available
	*/
	public function schedule($str) {
		$ret = '<div class="schedule"><ul class="checkboxReadOnly">';
		foreach (array('M', 'T', 'W', 'T', 'F', 'S', 'S') as $i => $day) {
			$ret .= '
			<li>
				<input type="checkbox" id="schedule' . $i . '"' . ($str[$i] == '1' ? ' checked' : '' ).'>
				<label for="schedule' . $i . '">' . $day . '</label>
			</li>';
		}
		$ret .= '</ul></div>';
		return $ret;
	}


}