<?php
	define('TITLE', 'Bus Booking');
	require('header.php');
	echo "<main class='page-content'>";
	echo "<section class='section-sm-95 bg-image bg-image-6 text-center section-sm-bottom-100 section-60'>";
	echo "<div class='shell'>";
	
	if (isset($_POST['submitted'])) {
		echo "<h1 class='txt-white'>PAYMENT</h1><br>";
		
		require('dbcon.php');
		$scheduleID = $_POST['schedule'];
		$numAdults = (empty($_POST['adults'])) ? 0 : $_POST['adults'];
		$numChildren = (empty($_POST['children'])) ? 0 : $_POST['children'];
		$numSeniors = (empty($_POST['seniorCitizens'])) ? 0 : $_POST['seniorCitizens'];
		
		//get the number of tickets left
		$query1 = "SELECT * from `schedule` WHERE scheduleID='".$scheduleID."'";
		$myData1 = mysqli_query($con, $query1);
		while ($row = mysqli_fetch_array($myData1)) {
			$ticketLeft = $row['ticketLeft'];
			$busID = $row['busID'];
		}
		
		$query2 = "SELECT * from `bus` WHERE busID='".$busID."'";
		$myData2 = mysqli_query($con, $query2);
		while ($row = mysqli_fetch_array($myData2)) {
			$ticketPrice = $row['ticketPrice'];
		}
		
		//calculate total tickets bought
		$totalTickets = $numAdults + $numChildren + $numSeniors;
		
		echo "<div class='cell-lg-8 cell-lg-preffix-2 offset-top-5'>";
		echo "<section class='section-71 section-bottom-80'>";
		echo "<form class='text-left form-search' action='bookingcomplete.php' method='post'>";
        //echo "<form class='rd-mailform text-center form-search2' action='bookingcomplete.php' method='post'>";
		echo "<center>";
		
		//check whether user entered an appropriate number of tickets
		if ($totalTickets == 0) {
			echo "<p>At least 1 ticket (of any age category) must be purchased</p>";
		} else if ($totalTickets > $ticketLeft) {
			echo "<p>Error: The number of tickets you wish to purchase exceeds the number of tickets left</p>";
		} else {
			$normalPrice = number_format($ticketPrice, 2);
			$otherPrice = number_format($ticketPrice - 5, 2);
			$adultPrice = number_format($normalPrice * $numAdults, 2);
			$childPrice = number_format($otherPrice * $numChildren, 2);
			$seniorPrice = number_format($otherPrice * $numSeniors, 2);
			$payment = number_format($adultPrice + $childPrice + $seniorPrice, 2);
			
			echo "<div class='total-tickets'>";
			echo "<table>";
			echo "<tr style='background-color: white; border-bottom: 5px;'>";
			echo "<td></td>";
			echo "<th>Price per Ticket (RM)</th>";
			echo "<td></td>";
			echo "<th>Number of Tickets</th>";
			echo "<td></td>";
			echo "<th>Total Price (RM)</th>";
			echo "</tr>";
			echo "<tr style='background-color: white;'>";
			echo "<th style='text-align: left;'>Children</th>";
			echo "<td>$otherPrice</td>";
			echo "<td>&#10005;</td>";
			echo "<td>$numChildren</td>";
			echo "<td>=</td>";
			echo "<td>$childPrice</td>";
			echo "</tr>";
			echo "<tr style='background-color: white;'>";
			echo "<th style='text-align: left;'>Adults</th>";
			echo "<td>$normalPrice</td>";
			echo "<td>&#10005;</td>";
			echo "<td>$numAdults</td>";
			echo "<td>=</td>";
			echo "<td>$adultPrice</td>";
			echo "</tr>";
			echo "<tr style='background-color: white;'>";
			echo "<th style='text-align: left;'>Senior Citizens</th>";
			echo "<td>$otherPrice</td>";
			echo "<td>&#10005;</td>";
			echo "<td>$numSeniors</td>";
			echo "<td>=</td>";
			echo "<td>$seniorPrice</td>";
			echo "</tr>";
			echo "<tr class='total'>";
			echo "<th style='text-align: left;'>Total</th>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<th>$totalTickets</th>";
			echo "<td></td>";
			echo "<th>$payment</th>";
			echo"</tr>";
			echo "<tr>";
			echo "<td></td>";
			echo "</tr>";
			echo "<tr style='background-color: white; outline-style: solid; outline-width: thin;'>";
			echo "<td colspan='6' style='text-align: left;'><b>Payment Method:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label><input type='radio' name='payment-method' value='Debit/Credit Card'> Debit/Credit Card</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label><input type='radio' name='payment-method' value='E-Wallet'> E-Wallet</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<label><input type='radio' name='payment-method' value='Online Banking'> Online Banking</label>
				</td>";
			echo "</tr>";
			echo "</table>";
			echo "</div>";
			
			echo "<div class='cell-xs-12 offset-top-50'>";
			echo "<button type='submit' data-text='PAY' class='btn btn-orange btn-fullwidth btn-winona btn-sm'><span>PAY</span></button>";
			echo "<input type = 'hidden' name = 'price' value='$payment'/>";
			echo "<input type = 'hidden' name = 'child' value='$numChildren'/>";
			echo "<input type = 'hidden' name = 'adult' value='$numAdults'/>";
			echo "<input type = 'hidden' name = 'senior' value='$numSeniors'/>";
			echo "<input type='hidden' name='schedule' value='$scheduleID' />";
			echo "</div>";
		}
		
		echo "<br/><p><a href='enterbookinginfo.php?schedule=$scheduleID'>Go Back</a></p>";
		
		echo "</center>";
		echo "</form>";
		echo "</section>";
		echo "</div>";
	}
	else {
		echo "<h1 class='txt-white'>ENTER TICKET AMOUNT</h1><br>";
		
		$scheduleID = $_GET['schedule'];
		
		echo "<div class='range'>";
		echo "<div class='cell-lg-8 cell-lg-preffix-2'>";
		echo "<form class='text-left form-search' action='enterbookinginfo.php' method='post'>";
		echo "<div class='range offset-top-5'>";
		
		//CHILDREN
		echo "<div class='cell-sm-4 offset-top-50'>";
		echo "<div class='form-group'>";
		echo "<label for='children' class='form-label'>Children ( &lt 18 )</label>";
		echo "<input type='text' name='children' size='15' />";
		echo "</div>";
		echo "</div>";
		
		//ADULTS
		echo "<div class='cell-sm-4 offset-top-50'>";
		echo "<div class='form-group'>";
		echo "<label for='adults' class='form-label'>Adults ( 18 - 60 )</label>";
		echo "<input type='text' name='adults' size='15' />";
		echo "</div>";
		echo "</div>";
		
		//SENIOR CITIZENS
		echo "<div class='cell-sm-4 offset-top-50'>";
		echo "<div class='form-group'>";
		echo "<label for='seniorCitizens' class='form-label'>Senior Citizens ( &gt 60 )</label>";
		echo "<input type='text' name='seniorCitizens' size='15' />";
		echo "</div>";
		echo "</div>";
		
		//BOOK NOW BUTTON
		echo "<div class='cell-xs-12 offset-top-50'>";
		echo "<button type='submit' data-text='BOOK NOW' class='btn btn-orange btn-fullwidth btn-winona btn-sm'><span>BOOK NOW</span></button>";
		echo "<input type = 'hidden' name = 'submitted' value='true'/>";
		echo "<input type='hidden' name='schedule' value='$scheduleID' />";
		echo "</div>";
		
		echo "</div>";
		echo "</form>";
		echo "</div>";
		echo "</div>";
	}
	
	echo "</div>";
	echo "</section>";
	echo "</main>";
	require('footer.php');
?>