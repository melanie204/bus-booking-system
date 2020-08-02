<?php
	define('TITLE', 'Bus Schedules');
	require('header.php');
	
	//PAGE CONTENT
	echo "<main class='page-content'>";
	echo "<section class='section-60 section-sm-95 bg-image bg-image-1 text-center section-sm-bottom-60'>";

	//SWIPER
	echo "<div data-autoplay='5000' class='swiper-container swiper-slider text-center'>";
	echo "<div data-slide-bg='images/index5.jpg' class='swiper-slide'></div>";
	//SWIPER PAGINATION
	echo "<div class='swiper-pagination'></div>";
	echo "</div>";
	echo "<div class='shell'>";
	echo "<h1 class='txt-white'>BUS SCHEDULES</h1>";
	echo "<div class='range'>";

	//CONTENT STARTS HERE--------------------------------------------------------------------------------------
	
	echo "<div class='cell-lg-8 cell-lg-preffix-2'>";
	
	if (isset($_POST['submitted'])) {
		$day = $_POST['dep-day'];
		$month = $_POST['dep-month']; 
		$year = $_POST['dep-year']; 
		
		echo "<section class='section-71 section-bottom-80'>";
        echo "<form class='rd-mailform text-center form-search2'>";
		
		if (empty($day) || empty($month) || empty($year)) {
			echo "<p>Please select a Departure Date</p>";
		} else if (validateDate($day, $month, $year) == false) {
			echo "<p>Invalid Departure Date selected</p>";
		} else {
			$date = convertToTwoDigits($day) . "-" . convertToTwoDigits($month) . "-" . $year;
			
			require('dbcon.php');
			
			//check whether there's any schedule with the specified departure date
			$haveSchedule = mysqli_query($con, "SELECT * FROM schedule WHERE depDate='".$date."'");
			
			if (mysqli_num_rows($haveSchedule) > 0) {
				echo "<div class='table-bordered'>";
				echo "<center>";
				echo "<table width='750px'>
				<tr>
				<th>Departure Location</th>
				<th>Arrival Location</th>
				<th>Depart At</th>
				<th>Arrive At</th>
				<th>Tickets Left</th>
				<th>Bus Type</th>
				<th>Ticket Price (RM)*</th>
				</tr>";
				
				$count = 0;
				
				while ($row = mysqli_fetch_array($haveSchedule)) {
					$getBusInfo = mysqli_query($con, "SELECT * FROM bus WHERE busID='".$row['busID']."'");
					$busInfo = mysqli_fetch_array($getBusInfo);
					
					if ($count % 2 == 0) {
						echo "<tr style='background-color: #ffe0b3'>";
					}
					else {
						echo "<tr>";
					}
					
					echo "
					<td>".$row['depLocation']."</td>
					<td>".$row['arrLocation']."</td>
					<td>".$row['depTime']."hr<br/>".$row['depDate']."</td>
					<td>".$row['arrTime']."hr<br/>".$row['arrDate']."</td>
					<td>".$row['ticketLeft']."</td>
					<td>".$busInfo['busType']."</td>
					<td>".$busInfo['ticketPrice']."</td>
					</tr>
					";
					
					$count++;
				}
				echo "</table>";
				echo "</center>";
				echo "</div>";
				
				echo "<p style='text-align: left;'><small>* Children and Senior Citizens get a deduction of RM5 off of their tickets.</small></p>";
			}
			else {
				echo "<p>Sorry! No buses scheduled to depart on <tt>$date</tt>...</p>";
			}
			mysqli_close($con);
		}
		
		echo "<br/><p><a href='destinations.php'>Go Back</a></p>";
		
		echo "</form>";
		echo "</section>";
	}
	else {
		echo "<form class='rd-mailform text-left form-search' method='POST' action='destinations.php'>";
		echo "<div class='cell-sm-6 offset-top-45'>";
		echo "<div class='form-group date'>";
		//select departure date
		echo "<label for='datetimepicker1' class='form-label'>Departure Date</label>";
		echo "<div class='select-date'>";
		echo "<select name='dep-day'>";	
		echo "<option value=''>Day</option>";
		displayDropdownOptions(1, 31, 0, 1);
		echo "</select>&nbsp;";
		echo "<select name='dep-month'>";	
		echo "<option value=''>Month</option>";
		displayDropdownOptions(1, 12, 0, 1);
		echo "</select>&nbsp;";	
		echo "<select name='dep-year'>";	
		echo "<option value=''>Year</option>";
		displayDropdownOptions(2020, 2025, 0, 1);
		echo "</select>";
		echo "</div>";
		echo "</div>";
		echo "</div>";                                
		echo "<div class='cell-xs-12 offset-top-37'>";
		echo "<button type='submit' name='submit' data-text='search' class='btn btn-orange btn-fullwidth btn-winona btn-sm'><span>search</span></button>";
		echo "<input type='hidden' name='submitted' value='true' />";
		echo "</div>";
		echo "</form>";
	}
	
	echo "</div>";
	
	//CONTENT ENDS HERE--------------------------------------------------------------------------------------
	echo "</div>";
	echo "</div>";
	echo "</section>";
	echo "</main>";
	require('footer.php');
?>