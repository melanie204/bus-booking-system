<?php
	//header
	require('staffheader.php');
	echo "<main class='page-content'>";
	echo "<section class='section-60 section-sm-95 bg-image bg-image-1 text-center section-sm-bottom-60'>";
	echo "<div data-autoplay='5000' class='swiper-container swiper-slider text-center'>";
	echo "<div data-slide-bg='images/index5.jpg' class='swiper-slide'>";
	echo "</div>";
	echo "<div class='swiper-pagination'></div>";
	echo "</div>";
	//Title
	echo "<div class='shell'>";
	echo "<h1 class='txt-white'>ADD BUS</h1>";
	echo "<div class='range'>";    
	echo "<div class='cell-lg-8 cell-lg-preffix-2'>";
	echo "<section class='section-71 section-bottom-80'>";
	
	if (isset($_POST['submitted'])) {
		echo "<div class='cell-lg-8 cell-lg-preffix-2 offset-top-5'>";
		echo "<section class='section-71 section-bottom-80'>";
        echo "<form class='rd-mailform text-center form-search2'>";
		
		$filledForm = false;
		$validPrice = false;
		$validTicket = false;
		
		//receive data 
		$bus_type=$_POST["bustype"];
		$bus_price=$_POST["busprice"];
		$bus_ticket=$_POST["busticket"];
		
		if (empty($bus_type) && empty($bus_price) && empty($bus_ticket)) {
			echo "<p>Please enter the bus' Ticket Price, Total Seats Available and select its Type</p>";
		} else if (empty($bus_type) && empty($bus_price)) {
			echo "<p>Please select the bus' Type and enter its Ticket Price</p>";
		} else if (empty($bus_type) && empty($bus_ticket)) {
			echo "<p>Please select the bus' Type and enter the Total Seats Available</p>";
		} else if (empty($bus_price) && empty($bus_ticket)) {
			echo "<p>Please enter the bus' Ticket Price and Total Seats Available</p>";
		} else if (empty($bus_type)) {
			echo "<p>Please select the bus' Type</p>";
		} else if (empty($bus_price)) {
			echo "<p>Please enter the bus' Ticket Price</p>";
		} else if (empty($bus_ticket)) {
			echo "<p>Please enter the Total Seats Available for this bus</p>";
		} else {
			$filledForm = true;
		}
		
		if (!empty($bus_price)) {
			if (is_numeric($bus_price)) {
				if ($bus_price > 0) {
					$validPrice = true;
					$bus_price = number_format($bus_price, 2);
				}
				else {
					echo "<p>Ticket Price cannot be a negative number</p>";
				}
			}
			else {
				echo "<p>Ticket Price must contain digits only</p>";
			}

		}
		
		if (!empty($bus_ticket)) {
			if (is_numeric($bus_ticket)) {
				if ($bus_ticket > 0) {
					$validTicket = true;
				}
				else {
					echo "<p>The Total Seats Available cannot be a negative number</p>";
				}
			}
			else {
				echo "<p>The Total Seats Available must contain digits only</p>";
			}
		}
			
		
		if ($filledForm && $validPrice && $validTicket) {
			require('dbcon.php');
			
			//create an id for the bus
			$ids = array();
			$sql2 = "SELECT * FROM bus";
			$mydata2 = mysqli_query($con, $sql2);
			while ($row2 = mysqli_fetch_array($mydata2)) {
				array_push($ids, $row2['busID']);
			}
			$newID = "b" . convertToTwoDigits(count($ids) + 1);
			
			$i = 2;
			
			while (in_array($newID, $ids)) {
				$newID = "b" . convertToTwoDigits(count($ids) + $i);
				$i++;
			}
			
			//sql command
			$sql=
			"INSERT INTO bus (busID, busType, ticketPrice, totalTicketPerBus)
			VALUES ('".$newID."', '".$bus_type."', '".$bus_price."', '".$bus_ticket."')";

			//insert into database
			$result1=mysqli_query($con,$sql);

			//if insert into the database successfully
			if($result1){
				echo "<p>Bus successfully added!</p>";
			}
			else{
				//if fail to insert into database
				echo "<p style='color:red;'>Could not add the bus to database because:<br/>".mysqli_error($con).".The query was:". $sql.".</p>";
			}

			mysqli_close($con);
		}
		
		echo "<p><a href='addbus.php'>Go Back</a></p>";
		echo "</form>";
		echo "</section>";
		echo "</div>";
	}
	else {
		//form start
		echo "<form class='rd-mailform text-left form-search' action='addbus.php' method='POST'>";
		echo "<div class='range offset-top-50'>";
		echo "<div class='cell-xs-12'>";
		echo "<div class='form-group select2-custom'>";
		echo "<label for='to' class='form-label'>Bus Type:</label>";
		echo "<select name='bustype'>";
		echo "<option value=''>Bus Type<option>";
		echo "<option value='Normal'>Normal<option>";
		echo "<option value='Premium'>Premium<option>";
		echo "<option value='Rapid'>Rapid<option>";
		echo "</select>";
		echo "</div>";
		echo "</div>";
		echo "<div class='cell-sm-6 offset-top-45'>";
		echo "<div class='form-group'>";
		echo "<label for='from' class='form-label'>Ticket Price:</label>";
		echo "<input id='busprice' type='text' name='busprice' placeholder='RM' data-constraints='@Required' class='form-control'>";
		echo "</div>";
		echo "</div>";
		echo "<div class='cell-sm-6 offset-top-45'>";
		echo "<div class='form-group'>";
		echo "<label for='to' class='form-label'>Total Seats Available:</label>";
		echo "<input id='busticket' type='text' name='busticket' placeholder='No.' data-constraints='@Required' class='form-control'>";
		echo "</div>";
		echo "</div>";
		//submit button
		echo "<div class='cell-xs-12 offset-top-37'>";
		echo "<button type='submit' name='submit' data-text='add' class='btn btn-orange btn-fullwidth btn-winona btn-sm'><span>add</span></button>";
		echo "<input type = 'hidden' name = 'submitted' value='true'/>";
		echo "</div>";
		echo "</form>";
	}
	
	echo "</section>";
	echo "</div>";
	echo "</div>";
	echo "</div>";
	echo "</main>";
	//footer
	require('stafffooter.php');
?>