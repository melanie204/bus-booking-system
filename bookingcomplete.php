<?php
	define('TITLE', 'Bus Booking');
	require('header.php');
	echo "<main class='page-content'>";
	echo "<section class='section-sm-95 bg-image bg-image-6 text-center section-sm-bottom-100 section-60'>";
	echo "<div class='shell'>";
	
	
	
	if (empty($_POST['payment-method'])) {
		echo "<h1 class='txt-white'>PAYMENT ERROR</h1><br>";
		
		echo "<div class='cell-lg-8 cell-lg-preffix-2 offset-top-5'>";
		echo "<section class='section-71 section-bottom-80'>";
		echo "<form class='rd-mailform text-center form-search2'>";
		
		echo "<p>Error: A problem occurred during the payment process</p>";
	}
	else {
		echo "<h1 class='txt-white'>BOOKING COMPLETE</h1><br>";
		
		echo "<div class='cell-lg-8 cell-lg-preffix-2 offset-top-5'>";
		echo "<section class='section-71 section-bottom-80'>";
		echo "<form class='rd-mailform text-center form-search2'>";
		
		$scheduleID = $_POST['schedule'];
		$totalPayment = $_POST['price'];
		$paymentMethod = $_POST['payment-method'];
		$numAdults = $_POST['adult'];
		$numChildren = $_POST['child'];
		$numSeniors = $_POST['senior'];
		
		require('dbcon.php');
		$sql = "SELECT * FROM schedule WHERE scheduleID='".$scheduleID."'";
		$mydata = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($mydata);
		
		$busID = $row['busID'];
		
		$sql2 = "SELECT * FROM bus WHERE busID='".$busID."'";
		$mydata2 = mysqli_query($con, $sql2);
		$row2 = mysqli_fetch_array($mydata2);
		
		$busType = $row2['busType'];
		$depLoc = $row['depLocation'];
		$arrLoc = $row['arrLocation'];
		$depTime = $row['depTime'];
		$arrTime = $row['arrTime'];
		$depDate = $row['depDate'];
		$arrDate = $row['arrDate'];
		
		$ids = array();
		
		$sql3 = "SELECT * FROM orders";
		$mydata3 = mysqli_query($con, $sql3);
		while ($row3 = mysqli_fetch_array($mydata3)) {
			array_push($ids, (int) $row3['orderNumber']);
		}
		
		$newID = count($ids) + 1;
		
		$query = "INSERT INTO orders (orderNumber, orderTotalPrice, userID, busID, busType, depLocation, arrLocation, depTime, arrTime, depDate, arrDate, childrenTickets, adultTickets, seniorTickets) VALUES ('".$newID."', '".$totalPayment."', '".$_SESSION['id']."', '".$busID."', '".$busType."', '".$depLoc."', '".$arrLoc."', '".$depTime."', '".$arrTime."', '".$depDate."', '".$arrDate."', '".$numChildren."', '".$numAdults."', '".$numSeniors."')";
		
		if(mysqli_query($con, $query)) {
			echo "<p>Tickets booked successfully!</p>";
			
			$ticketLeft = $row['ticketLeft'];
			$ticketLeft = $ticketLeft - $numAdults - $numChildren - $numSeniors;
			
			$query2 = "UPDATE schedule SET ticketLeft='".$ticketLeft."' WHERE scheduleID='".$scheduleID."'" ;
			
			mysqli_query($con, $query2);
		}
		else {
			echo "<p style='color:red;'>Could book the tickets because because:<br/>".mysqli_error($con)."</p>";
		}
		
		mysqli_close($con);
	}
	
	echo "<br/><p><a href='index.php'>Return to Home Page</a></p>";
	
	echo "</form>";
	echo "</section>";
	echo "</div>";
	
	echo "</div>";
	echo "</section>";
	echo "</main>";
	require('footer.php');
?>