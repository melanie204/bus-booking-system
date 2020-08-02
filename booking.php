<?php
	define('TITLE', 'Bus Booking');
	require('header.php');
	echo "<main class='page-content'>";
	
	echo "<section class='section-sm-95 bg-image bg-image-6 text-center section-sm-bottom-100 section-60'>";
	echo "<div class='shell'>";
	
	if (isset($_POST['submitted'])) {
		echo "<h1 class='txt-white'>SELECT A BUS</h1><br>";
		
		echo "<div class='cell-lg-8 cell-lg-preffix-2 offset-top-5'>";
		echo "<section class='section-71 section-bottom-80'>";
        echo "<form class='rd-mailform text-center form-search2'>";
		
		if (empty($_POST['from']) && empty($_POST['to']) && empty($_POST['date'])) {
			echo "<p>Please select Departure Location, Arrival Location and Departure Date</p>";
		} else if (empty($_POST['from']) && empty($_POST['to'])) {
			echo "<p>Please select Departure Location and Arrival Location</p>";
		} else if (empty($_POST['from']) && empty($_POST['date'])) {
			echo "<p>Please select Departure Location and Departure Date</p>";
		} else if (empty($_POST['to']) && empty($_POST['date'])) {
			echo "<p>Please select Arrival Location and Departure Date</p>";
		} else if (empty($_POST['from'])) {
			echo "<p>Please select Departure Location</p>";
		} else if (empty($_POST['to'])) {
			echo "<p>Please select Arrival Location</p>";
		} else if (empty($_POST['date'])) {
			echo "<p>Please select Departure Date</p>";
		} else {
			$from = $_POST['from'];
			$to = $_POST['to'];
			$depDate = $_POST['date'];
			
			echo "<h2>From $from To $to</h2>";
			
			require('dbcon.php');
			$query = "SELECT * FROM `schedule` where depLocation='".$from."' AND arrLocation='".$to."' AND depDate='".$depDate."'";
			$myData = mysqli_query($con, $query);
			
			$count = 0;
			
			while ($row = mysqli_fetch_array($myData)) {
				if ($row['ticketLeft'] > 0) {
					if ($count == 0) {
						echo "<div class='table-bordered'>";
						echo "<center>";
						echo "<table width='1000px' style='margin-top: 25px;'>
						<tr>
						<th>Departure</th>
						<th>Arrival</th>
						<th>Tickets Left</th>
						<th>Bus Type</th>
						<th>Adult Ticket Price (RM)</th>
						<th>Child / Senior Citizen Ticket Price (RM)</th>
						<th>Action</th>
						</tr>";
					}
					
					$getBusInfo = mysqli_query($con, "SELECT * FROM bus WHERE busID='".$row['busID']."'");
					$busInfo = mysqli_fetch_array($getBusInfo);
					
					if ($count % 2 == 0) {
						echo "<tr style='background-color: #ffe0b3'>";
					}
					else {
						echo "<tr>";
					}
					
					echo "
					<td>".$row['depTime']."hr<br/>".$row['depDate']."</td>
					<td>".$row['arrTime']."hr<br/>".$row['arrDate']."</td>
					<td>".$row['ticketLeft']."</td>
					<td>".$busInfo['busType']."</td>
					<td>".$busInfo['ticketPrice']."</td>
					<td>".number_format(($busInfo['ticketPrice'] - 5), 2)."</td>
					<td><a href='enterbookinginfo.php?schedule=".$row['scheduleID']."'>Select</a></td>
					</tr>
					";
					
					$count++;
				}
			}
			
			if ($count > 0) {
				echo "</table>";
				echo "</center>";
				echo "</div>";
			}
			
			if ($count == 0) {
				echo "<p>Sorry! There doesn't seem to be any tickets left for buses running on <tt>$depDate</tt>...</p>";
			}
		}
		echo "<br/><p><a href='booking.php'>Go Back</a></p>";
		
		echo "</form>";
		echo "</section>";
		echo "</div>";
	}
	else {
		require('dbcon.php');
		
		echo "<h1 class='txt-white'>BOOKING</h1><br>";
		echo "<h5 class='txt-white'>Plan your journey and book with us now!</h5>";
		
		echo "<div class='range'>";
		echo "<div class='cell-lg-8 cell-lg-preffix-2'>";
		echo "<form class='text-left form-search' action='booking.php' method='post'>";
		echo "<div class='range offset-top-50'>";
		
		//TO
		echo "<div class='cell-sm-6'>";
		echo "<div class='form-group'>";
		echo "<label for='from' class='form-label'>From</label>";
		echo "<select id='dep' onchange='reload1(this.form)' name='from'>";
		echo "<option value=''>Departure Location</option>";
		$query1 = "SELECT DISTINCT(depLocation) as depLocation FROM `schedule`";
		$locData1 = mysqli_query($con, $query1);
		while($row1 = mysqli_fetch_array($locData1)) {
			if (!empty($_GET['dep'])) {
				$dep = $_GET['dep'];
				
				if ($row1['depLocation'] == $dep) {
					echo "<option value='".$row1['depLocation']."' selected>".$row1['depLocation']."</option>";
				}
				else {
					echo "<option value='".$row1['depLocation']."'>".$row1['depLocation']."</option>";
				}
			}
			else {
				echo "<option value='".$row1['depLocation']."'>".$row1['depLocation']."</option>";
			}
		}
		echo "</select>";
		echo "</div>";
		echo "</div>";
		
		//FROM
		echo "<div class='cell-sm-6'>";
		echo "<div class='form-group'>";
		echo "<label for='to' class='form-label'>To</label>";
		echo "<select id='arr' onchange='reload2(this.form)' name='to'>";
		echo "<option value=''>Arrival Location</option>";
		if (!empty($_GET['dep'])) {
			$dep = $_GET['dep'];
			$query2 = "SELECT DISTINCT(arrLocation) as arrLocation FROM `schedule` where depLocation='".$dep."'";
			$locData2 = mysqli_query($con, $query2);
			while($row2 = mysqli_fetch_array($locData2)) {
				if (!empty($_GET['arr'])) {
					$arr = $_GET['arr'];
					
					if ($row2['arrLocation'] == $arr) {
						echo "<option value='".$row2['arrLocation']."' selected>".$row2['arrLocation']."</option>";
					}
					else {
						echo "<option value='".$row2['arrLocation']."'>".$row2['arrLocation']."</option>";
					}
				}
				else {
					echo "<option value='".$row2['arrLocation']."'>".$row2['arrLocation']."</option>";
				}
			}
		}
		echo "</select>";
		echo "</div>";
		echo "</div>";
		
		//DEPARTURE TIME AND DATE
		echo "<div class='range offset-top-50'>";
		echo "<div class='cell-xs-12'>";
		echo "<div class='form-group select2-custom'>";
		echo "<label for='date' class='form-label'>Departure Date</label>";
		echo "<select id='date' name='date'>";
		echo "<option value=''>Date and Time</option>";
		if (!empty($_GET['dep']) && !empty($_GET['arr'])) {
			$dep = $_GET['dep'];
			$arr = $_GET['arr'];
			$query3 = "SELECT DISTINCT(depDate) as depDate FROM `schedule` where depLocation='".$dep."' AND arrLocation='".$arr."'";
			$locData3 = mysqli_query($con, $query3);
			while($row3 = mysqli_fetch_array($locData3)) {
				echo "<option value='".$row3['depDate']."'>".$row3['depDate']."</option>";
			}
		}
		echo "</select>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
		
		//BUTTON
		echo "<div class='cell-xs-12 offset-top-50'>";
		echo "<button type='submit' data-text='PROCEED' class='btn btn-orange btn-fullwidth btn-winona btn-sm'><span>PROCEED</span></button>";
		echo "<input type = 'hidden' name = 'submitted' value='true'/>";
		echo "</div>";
		
		echo "</div>";
		echo "</form>";
		echo "</div>";
		echo "</div>";
	}
	
	echo "</div>";
	echo "</section>";
	echo "</main>";
?>

<script>
	function reload1(form) {
		var v1 = form.dep.options[form.dep.options.selectedIndex].value;
		self.location='booking.php?dep=' + v1;
	}
	
	function reload2(form) {
		var v1 = form.dep.options[form.dep.options.selectedIndex].value;
		var v2 = form.arr.options[form.arr.options.selectedIndex].value;
		self.location='booking.php?dep=' + v1 + '&arr=' + v2;
	}
</script>

<?php
	require('footer.php');
?>