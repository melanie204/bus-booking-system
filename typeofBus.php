<?php
	define('TITLE', 'Bus Types');
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
	echo "<h1 class='txt-white'>BUS TYPES</h1>";
	echo "<div class='range'>";

	//CONTENT STARTS HERE--------------------------------------------------------------------------------------
	
	echo "<div class='cell-lg-8 cell-lg-preffix-2'>";
	echo "<section class='section-71 section-bottom-80'>";
    echo "<form class='rd-mailform text-center form-search2'>";
		
	require('dbcon.php');
	$sql = "SELECT * FROM `bus`";
	$myData = mysqli_query($con, $sql);
	
	if (mysqli_num_rows($myData) > 0) {
		echo "<div class='table-bordered'>";
		echo "<center>";
		echo "<table width='750'>
		<tr>
		<th>Bus ID</th>
		<th>Bus Type</th>
		<th>Ticket Price (RM)</th>
		<th>Total Seats Per Bus</th>
		</tr>";
		
		$count = 0;
		
		while ($row = mysqli_fetch_array($myData)) {
			$getBusInfo = mysqli_query($con, "SELECT * FROM bus WHERE busID='".$row['busID']."'");
			$busInfo = mysqli_fetch_array($getBusInfo);
			
			if ($count % 2 == 0) {
				echo "<tr style='background-color: #ffe0b3'>";
			}
			else {
				echo "<tr>";
			}
			
			echo "
			<td>".$row['busID']."</td>
			<td>".$row['busType']."</td>
			<td>".$row['ticketPrice']."</td>
			<td>".$row['totalTicketPerBus']."</td>
			</tr>
			";
			
			$count++;
		}
		echo "</table>";
		echo "</center>";
		echo "</div>";
	}
	else {
		echo "<p>Sorry! No bus information available at the moment...</p>";
	}
	
	echo "</form>";
	echo "</section>";
	echo "</div>";
	
	//CONTENT ENDS HERE--------------------------------------------------------------------------------------
	echo "</div>";
	echo "</div>";
	echo "</section>";
	echo "</main>";
	require('footer.php');
?>