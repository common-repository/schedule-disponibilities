<?php
/**
 * Class: Schedule Opening Hours
 * Author: Jeremy Jamar
 * Author URI: http://www.hellomoon.be
 * License: GPL2
 */
class ScheduleOpeningHours{
	
	private $days = array();
	private $daysName = array('Monday', 'Tuesday','Wednsday','Thursday','Friday','Saturday','Sunday');
	private $hours = array('07h00-07h30','07h30-08h00','08h00-08h30','08h30-09h00','09h00-09h30','09h30-10h00','10h00-10h30','10h30-11h00','11h00-11h30','11h30-12h00','12h00-12h30','12h30-13h00','13h00-13h30','13h30-14h00','14h00-14h30','14h30-15h00','15h00-15h30','15h30-16h00','16h00-16h30','16h30-17h00','17h00-17h30','17h30-18h00','18h00-18h30','18h30-19h00','19h00-19h30','19h30-20h00','20h00-20h30','20h30-21h00','21h00-21h30','21h30-22h00','22h00-22h30','22h30-23h00','23h00-23h30','23h30-00h00');
	private $daysShorcuts = array('mo','tu','we','th','fr','sa','su');
	private $color = null;
	public  $schedule = array();

	private function getHoursFromRanges($hoursRange){
		$begin = false;
		$hoursAvailable = null;
		$hoursRange = explode('|',$hoursRange);

		foreach($hoursRange as $ranges) {
			$ranges = explode('-',$ranges);	
			foreach ($this->hours as $hour) {
				$hour = explode('-',$hour);
				if($hour[0] == $ranges[0]){
					$begin = true;
				}
				if( $begin ){
					$hoursAvailable[] = $hour[0] . '-' . $hour[1];
				}
				if($hour[1] == $ranges[1]){
					$begin = false;
					break;
				}
			}
		}
		return $hoursAvailable;
	}

	public function getDaysShorcuts(){
		return $this->daysShorcuts;
	}

	public function displayAllDays(){
		$this->schedule[0] = null;
		$this->schedule[1] = null;
		$this->schedule[2] = null;
		$this->schedule[3] = null;
		$this->schedule[4] = null;
		$this->schedule[5] = null;
		$this->schedule[6] = null;
		return $this;
	}
	public function displayWeekDays(){
		$this->schedule[0] = null;
		$this->schedule[1] = null;
		$this->schedule[2] = null;
		$this->schedule[3] = null;
		$this->schedule[4] = null;
		return $this;
	}
	public function setDaysName( $daysName ){
		$this->daysName = $daysName;
		return $this;
	}
	public function setColor( $color ){
		$this->color = $color;
	}
	public function setSchedule($days, $range){
		$days = explode('|',$days);
		foreach($days as $day){
			$dayKey = array_search($day, $this->daysShorcuts);
			if( isset($range) && $range != null){
				$this->schedule[$dayKey] = $this->getHoursFromRanges($range);
			}
			else {
				$this->schedule[$dayKey] = null;
			}
		}
		ksort($this->schedule);
		return $this;
	}

	public function getSchedule(){

		$totalDays = count($this->schedule) -1;

		$html .= 
		'<div class="schedule-wrapper">'.
		'	<div class="schedule-sub-wrapper">'.
		'		<table class="schedule">'.
		'			<thead>'.
		'				<tr class="even">'.
		'				<th colspan="1"></th>';
		for($j = 7; $j < 23; $j++){
			$html .= '<th colspan="2">'. $j . '</th>';
		}
		$html .=
		'				</tr>'.
		'			</thead>'.
		'			<tbody>';
		// Days Loop
		$i = 0;
		foreach($this->schedule as $dayKey => $day){
			$html .= 
			'<tr class="day-'. $day .'">'.
			'	<th>'. $this->daysName[$dayKey] .'</th>';
				for ($h = 0; $h <= 31; $h++){
					$currentTime = $this->hours[$h];
					$hoursAvailable = $this->schedule[$dayKey];
					if($hoursAvailable != null && in_array($currentTime, $hoursAvailable)){
						$status = 'filled';
					}
					else {
						$status = 'empty';
					}
					$html .=
					'<td class="'. $status .'" data-id="'. $currentTime .'"'.($this->color != null && $status == 'filled' ? 'style="background:'. $this->color .';"' : null).'></td>';
				}
			$html .= '</tr>';
			if( $i == 0 || $i != $totalDays ){
				$html .= 
				'<tr class="white even">'.
				'	<th></th>';
				for($e = 1; $e <= 15; $e++){
					$html .=
					'<td><div></div></td>'.
					'<td class="odd"><div></div></td>';
				}
				$html .=
				'	<td class="fake"><div></div></td>'.
				'</tr>';
				$i++;
			}
		}
		$html .= 
		'			</tbody>'.
		'		</table>'.
		'	</div>'.
		'</div>';

		return $html;
	}
	public function showSchedule(){
		echo $this->getSchedule();
	}
}