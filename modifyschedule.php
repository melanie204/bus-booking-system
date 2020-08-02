<?php
	define('TITLE', 'Modify Schedule');
	//header
	require ('staffheader.php');
	echo "<center>";
	echo "<main class='page-content'>";
	
	echo "<section class='section-sm-95 bg-image bg-image-6 text-center section-sm-bottom-100 section-60'>";
	echo "<div class='shell'>";
	
	//title
	echo "<h1 class='txt-white'>Modify Bus Schedule</h1><br/>";
	
	//if user click the submit button
	if(isset($_POST['submitted'])){
		echo "<div class='cell-lg-8 cell-lg-preffix-2 offset-top-5'>";
		echo "<section class='section-71 section-bottom-80'>";
        echo "<form class='rd-mailform text-center form-search2'>";
		
		//fetch data from the form
		$scheduleId = $_POST['schedule-id'];
		$bus = $_POST['bus'];
		$ticketAmt = $_POST['ticket-amt'];
		$depLoc = $_POST['dep-loc'];
		$depHr = $_POST['dep-hour'];
		$depMin = $_POST['dep-min'];
		$depDay = $_POST['dep-day'];
		$depMonth = $_POST['dep-month'];
		$depYear = $_POST['dep-year'];
		$arrLoc = $_POST['arr-loc'];
		$arrHr = $_POST['arr-hour'];
		$arrMin = $_POST['arr-min'];
		$arrDay = $_POST['arr-day'];
		$arrMonth = $_POST['arr-month'];
		$arrYear = $_POST['arr-year'];
		
		//validation
		$validTicket = false;
		$duplicateLoc = true;
		$validDepAndArr = false;
		
		$emptyDates = true;
		$emptyTimes = true;
		
		//if ticket amount is empty
		if (empty($ticketAmt)) {
			echo "<p>Please enter Ticket Amount</p>";
		}
		else {
			//if ticket amount is not number
			if (!is_numeric($ticketAmt)) {
				echo "<p>Ticket Amount should contain digits only</p>";
			}
			else {
				if ($ticketAmt < 0) {
					echo "<p>Ticket Amount cannot be less than zero</p>";
				}
				else {
					$validTicket = true;
				}
			}
		}
		
		//if departure and arrival location is empty
		if (empty($depLoc) && empty($arrLoc)) {
			echo "<p>Please enter Departure Location and Arrival Location</p>";
		//if departure location is empty
		} else if (empty($depLoc)) {
			echo "<p>Please enter Departure Location</p>";
		//if arrival location is empty
		} else if (empty($arrLoc)) {
			echo "<p>Please enter Arrival Location</p>";
		} else {
			//if departure location and arrival location is same
			if ($depLoc == $arrLoc) {
				echo "<p>Please enter different Departure and Arrival Locations</p>";
			}
			else {
				$duplicateLoc = false;
			}
		}
		
		//if departure time and arrival time is not being choose
		if ((($depHr == -1) || ($depMin == -1)) && (($arrHr == -1) || ($arrMin == -1))) {
			echo "<p>Please select Departure Time and Arrival Time</p>";
		//if departure time is not being choose
		} else if (($depHr == -1) || ($depMin == -1)) {
			echo "<p>Please select Departure Time</p>";
		//if arrival time is not being choose
		} else if (($arrHr == -1) || ($arrMin == -1)) {
			echo "<p>Please select Arrival Time</p>";
		} else {
			$emptyTimes = false;
		}
		
		//if departure and arrival date is empty
		if ((empty($depDay) || empty($depMonth) || empty($depYear)) && (empty($arrDay) || empty($arrMonth) || empty($arrYear))) {
			echo "<p>Please select Departure Date and Arrival Date</p>";
		//if departure date is empty
		} else if (empty($depDay) || empty($depMonth) || empty($depYear)) {
			echo "<p>Please select Departure Date</p>";
		//if arrival date is empty
		} else if (empty($arrDay) || empty($arrMonth) || empty($arrYear)) {
			echo "<p>Please select Arrival Date</p>";
		} else {
			$emptyDates = false;
		}
		
		if (!$emptyDates && !$emptyTimes) {
			$depHr = convertToTwoDigits($depHr);
			$depMin = convertToTwoDigits($depMin);
			$arrHr = convertToTwoDigits($arrHr);
			$arrMin = convertToTwoDigits($arrMin);
			$depDay = convertToTwoDigits($depDay);
			$depMonth = convertToTwoDigits($depMonth);
			$arrDay = convertToTwoDigits($arrDay);
			$arrMonth = convertToTwoDigits($arrMonth);
			
			//combine and save time and date as string
			$depTime = $depHr . ":" . $depMin;
			$arrTime = $arrHr . ":" . $arrMin;
			$depDate = $depDay . "-" . $depMonth . "-" . $depYear;
			$arrDate = $arrDay . "-" . $arrMonth . "-" . $arrYear;
			
			if (strtotime($depDate) > strtotime($arrDate)) {
				echo "<p>Departure Date must not be past Arrival Date</p>";
			} else if (strtotime($depDate) < strtotime($arrDate)) {
				$validDepAndArr = true;
			} else {
				if (strtotime($depTime) > strtotime($arrTime)) {
					echo "<p>Departure Time must not be past Arrival Time if the bus departs and arrives on the same day</p>";
				} else if (strtotime($depTime) == strtotime($arrTime)) {
					echo "<p>Departure Time cannot have the same time as Arrival Time if the bus departs and arrives on the same day</p>";
				}
				else {
					$validDepAndArr = true;
				}
			}
		}
		
		//validation
		if ($validTicket && !$duplicateLoc && $validDepAndArr) {
			require ('dbcon.php');

			//sql query
			$sql = "
			UPDATE schedule 
			SET depLocation='".$depLoc."', arrLocation ='".$arrLoc."', depTime='".$depTime."', arrTime='".$arrTime."', depDate='".$depDate."', arrDate='".$arrDate."', ticketLeft='".$ticketAmt."', busID='".$bus."'
			WHERE scheduleID='".$scheduleId."'";
			
			//if database being update successfully
			if(mysqli_query($con, $sql)) {
				echo "<p>Bus Schedule successfully modified!</p>";
			}
			else {
				//if fail to update
				echo "<p style='color:red;'>Could not modify the entry because:<br/>".mysqli_error($con).".The query was:". $sql.".</p>";
			}
			
			mysqli_close($con);
		}
		
		echo "<p><a href='selectschedule.php'>Go Back</p>";
		
		echo "</form>";
		echo "</section>";
		echo "</div>";
	}
	else {
		if (!empty($_POST['schedule'])) {
			$target = $_POST['schedule'];
			
			require('dbcon.php');
			//sql query
			$sql = "SELECT * FROM `schedule` WHERE scheduleID='".$target."'";
			//send query to the database
			$myData = mysqli_query($con, $sql);
			//check that if the database got the data
			$row = mysqli_fetch_array($myData);
			
			$depTime = explode(":", $row['depTime'], 2);
			$arrTime = explode(":", $row['arrTime'], 2);
			
			$depDate = explode("-", $row['depDate'], 3);
			$arrDate = explode("-", $row['arrDate'], 3);
			
			//start of form
			echo "<div class='range'>";
			echo "<div class='cell-lg-8 cell-lg-preffix-2'>";
			echo "<form class='text-left form-search' action='modifyschedule.php' method='post'>";
			echo "<div class='range offset-top-20'>";
			//BUS & TICKET AMOUNT----------------------------------------------------------------------------
			echo "<div class='bus-table'>";
			echo "<table>";
			echo "<tr>";
			echo "<td width='40%'><h4>Bus</h4></td>";
			echo "<td width='60%'><select name='bus'>";
			echo "<option value=''>Bus ID</option>";
			//to get all buses
			$getBus = "SELECT * FROM `bus`";
			$busData = mysqli_query($con, $getBus);
			while ($busRow = mysqli_fetch_array($busData)) {
				if ($row['busID'] == $busRow['busID']) {
					echo "<option value='".$busRow['busID']."' selected>".$busRow['busID']." (".$busRow['busType'].")</option>";
				}
				else {
					//to check whether the bus has a schedule
					$haveSchedule = mysqli_query($con, "SELECT * FROM `schedule` where busID='".$busRow['busID']."'");
					
					if (mysqli_num_rows($haveSchedule) == 0) {
						echo "<option value='".$busRow['busID']."'>".$busRow['busID']." (".$busRow['busType'].")</option>";
					}
				}
			}
			echo "</select></td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td><h4>Ticket Amt</h4></td>";
			echo "<td><input type='text' name='ticket-amt' size='10' value='".$row['ticketLeft']."' style='height: 50px; padding: 0 15px;' /></td>";
			echo "</tr>";
			echo "</table>";
			echo "</div>";
			echo "<div class='modify-schedule-detail'>";
			//DEPARTURE--------------------------------------------------------------------------------------
			echo "<div class='departure'>";
			//departure location
			echo "<h4>Departure<br/>Location</h4>";
			echo "<input type='text' name='dep-loc' size='20' value='".$row['depLocation']."' style='height: 50px; padding: 0 15px;' /><br/><br/>";
			//departure time
			echo "<h4>Departure Time</h4>";
			echo "<p>";
			echo "<div class='select-time'>";
			echo "<select name='dep-hour'>";	
			echo "<option value=-1>Hour</option>";
			displayDropdownOptions(0, 23, $depTime[0], 1);
			echo "</select>&nbsp;";
			echo "<select name='dep-min'>";	
			echo "<option value=-1>Minutes</option>";
			displayDropdownOptions(0, 55, $depTime[1], 5);
			echo "</select>";
			echo "</div></p><br/>";
			//departure date
			echo "<h4>Departure Date</h4>";
			echo "<p>";
			echo "<div class='select-date'>";
			echo "<select name='dep-day'>";	
			echo "<option value=''>Day</option>";
			displayDropdownOptions(1, 31, $depDate[0], 1);
			echo "</select>&nbsp;";
			echo "<select name='dep-month'>";	
			echo "<option value=''>Month</option>";
			displayDropdownOptions(1, 12, $depDate[1], 1);
			echo "</select>&nbsp;";	
			echo "<select name='dep-year'>";	
			echo "<option value=''>Year</option>";
			displayDropdownOptions(2020, 2025, $depDate[2], 1);
			echo "</select>";
			echo "</div></p><br/>";
			echo "</div>";
			//ARRIVAL----------------------------------------------------------------------------------------
			echo "<div class='departure'>";
			echo "<h4>Arrival<br/>Location</h4>";
			echo "<input type='text' name='arr-loc' size='20' value='".$row['arrLocation']."' style='height: 50px; padding: 0 15px;' /><br/><br/>";
			//arrival time
			echo "<h4>Arrival Time</h4>";
			echo "<p>";
			echo "<div class='select-time'>";
			echo "<select name='arr-hour'>";	
			echo "<option value=-1>Hour</option>";
			displayDropdownOptions(0, 23, $arrTime[0], 1);
			echo "</select>&nbsp;";
			echo "<select name='arr-min'>";	
			echo "<option value=-1>Minutes</option>";
			displayDropdownOptions(0, 55, $arrTime[1], 5);
			echo "</select>";
			echo "</div></p><br/>";
			//arrival date
			echo "<h4>Arrival Date</h4>";
			echo "<div class='select-date'>";
			echo "<select name='arr-day'>";	
			echo "<option value=''>Day</option>";
			displayDropdownOptions(1, 31, $arrDate[0], 1);
			echo "</select>&nbsp;";
			echo "<select name='arr-month'>";	
			echo "<option value=''>Month</option>";
			displayDropdownOptions(1, 12, $arrDate[1], 1);
			echo "</select>&nbsp;";	
			echo "<select name='arr-year'>";	
			echo "<option value=''>Year</option>";
			displayDropdownOptions(2020, 2025, $arrDate[2], 1);
			echo "</select>";
			echo "</div>";
			echo "</div>";
			echo "</div>";
			//SUBMIT BUTTON----------------------------------------------------------------------------------
			echo "<div class='cell-xs-12 offset-top-50'>";
			echo "<button type='submit' data-text='SAVE CHANGES' class='btn btn-orange btn-fullwidth btn-winona btn-sm'><span>SAVE CHANGES</span></button>";
			echo "<input type = 'hidden' name = 'submitted' value='true'/>";
			echo "<input type = 'hidden' name = 'schedule-id' value='".$target."'/>";
			echo "</div>";
			
			echo "</div>";
			echo "</form>";
			echo "</div>";
			echo "</div>";
			mysqli_close($con);
		}
		else {
			echo "<div class='cell-lg-8 cell-lg-preffix-2 offset-top-5'>";
			echo "<section class='section-71 section-bottom-80'>";
			echo "<form class='rd-mailform text-center form-search2'>";
			
			echo "<p>No schedule selected</p>";
			echo "<p><a href='selectschedule.php'>Go Back</p>";
			
			echo "</form>";
			echo "</section>";
			echo "</div>";
		}
	}
	
	echo "</div>";
	echo "</section>";
	echo "</main>";
	echo "</center>";
	require('stafffooter.php');
?>