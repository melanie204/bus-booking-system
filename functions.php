<?php
	/*
		validateDate - check whether date given is valid and returns true/false
	*/
	function validateDate ($day, $month, $year) {
		$valid = false;
		$isLeapYear = false;
		
		//check if year selected is leap year
		if ($year % 400 == 0) {
			$isLeapYear = true;
		} else if ($year % 100 == 0) {
			$isLeapYear = false;
		} else if($year % 4 == 0) {
			$isLeapYear = true;
		} else {
			$isLeapYear = false;
		}
		
		//switch case to determine how range of day based on month
		switch ($month) {
			case 1:
			case 3:
			case 5:
			case 7:
			case 8:
			case 10:
			case 12:
				//Jan, Mar, May, Jul, Aug, Oct and Dec have 1 - 31 days
				if ($day >= 1 && $day <= 31) {
					$valid = true;
				}
				break;
			case 4:
			case 6:
			case 9:
			case 11:
				//Apr, Jun, Sept and Nov have 1 - 30 days
				if ($day >= 1 && $day <= 30) {
					$valid = true;
				}
				break;
			case 2:
				//On leap years, Feb has 1 - 29 days
				if ($isLeapYear) {
					if ($day >= 1 && $day <= 29) {
						$valid = true;
					}
				}
				//On non leap years, Feb has 1 - 28 days
				else {
					if ($day >= 1 && $day <= 28) {
						$valid = true;
					}
				}
				break;
		}
		
		return $valid;
	}
	
	/*
		displayDropdownOptions - display the options of a dropdown list
	*/
	function displayDropdownOptions($start, $end, $selected, $increment) {
		if ($start < $end) {
			for ($i = $start; $i <= $end; $i += $increment) {
				if ($i == $selected) {
					echo "<option value='$i' selected>$i</option>";
				}
				else {
					echo "<option value='$i'>$i</option>";
				}
			}
		} else if ($start > $end) {
			for ($i = $start; $i >= $end; $i -= $increment) {
				if ($i == $selected) {
					echo "<option value='$i' selected>$i</option>";
				}
				else {
					echo "<option value='$i'>$i</option>";
				}
			}
		}
	}
	
	/*
		convertToTwoDigits - check if a number has 2 digits. If not, add a "0" in front of it
	*/
	function convertToTwoDigits($num) {
		if (strlen($num) < 2) {
			$num = "0" . $num;
		}
		
		return $num;
	}
?>