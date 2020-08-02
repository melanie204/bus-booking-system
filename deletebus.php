<?php
	//header
	require('staffheader.php');
	require('dbcon.php');
	//Page Content
	echo "<main class='page-content'>";
	echo "<section class='section-60 section-sm-95 bg-image bg-image-1 text-center section-sm-bottom-60'>";
	echo "<div data-autoplay='5000' class='swiper-container swiper-slider text-center'>";
	echo "<div data-slide-bg='images/index5.jpg' class='swiper-slide'>";
	echo "</div>";
	//Swiper Pagination
	echo "<div class='swiper-pagination'></div>";
	echo "</div>";
	echo "<div class='shell'>";
	//title
	echo "<h1 class='txt-white'>DELETE SCHEDULE</h1>";
	echo "<div class='range'>";
	echo "<div class='cell-lg-8 cell-lg-preffix-2'>";
	echo "<section class='section-71 section-bottom-80'>";
	
	if (isset($_POST['submitted'])) {
		echo "<div class='cell-lg-8 cell-lg-preffix-2 offset-top-5'>";
		echo "<section class='section-71 section-bottom-80'>";
		echo "<form class='rd-mailform text-center form-search2'>";
		
		if (!empty($_POST["busID"])) {
			//get data from the form input by the user
			$bus_id=$_POST["busID"];

			//sql query
			$sql = "DELETE FROM bus WHERE busID='$bus_id'";

			//send query to database
			$result1 = mysqli_query($con,$sql);

			//if deleted successfully
			if($result1){
				echo "<p>Bus deleted successfully!</p>";
			}
			else{
				//if fail to delete
				echo "<p style='color:red;'>Could not delete the bus because:<br/>".mysqli_error($con).".The query was:". $sql.".</p>";
			}
		}
		else {
			echo "<p>No bus selected</p>";
		}
		
		echo "<p><a href='deletebus.php'>Go Back</p>";
		echo "</form>";
		echo "</section>";
		echo "</div>";
	}
	else {
		//form start
		echo "<form class='rd-mailform text-left form-search' action='deletebus.php' method='POST'>";
		echo "<div class='range offset-top-50'>";
		echo "<div class='cell-xs-12'>";
		echo "<div class='form-group select2-custom'>";
		echo "<label for='busID' class='form-label'>Select Bus ID:</label>";
		echo "<select name='busID'>";
		//sql query
		$sql = "SELECT busID FROM bus";
		$data =$con->query($sql);

		echo "<option value=''>Bus ID</option>";
		//if there is data in the database
		if ($data->num_rows > 0) {
			//fetch data from database
			while($row = $data->fetch_assoc()) {
				//display option
				echo"<option value='".$row['busID']."'>".$row['busID']."</option>";
			}
		}
		echo "</select>";
		echo "</div>";
		echo "</div>";    
		echo "<div class='cell-xs-12 offset-top-37'>";
		//submit button
		echo "<button type='submit' name='submit' data-text='Delete' class='btn btn-orange btn-fullwidth btn-winona btn-sm'><span>Delete</span></button>";
		echo "<input type = 'hidden' name = 'submitted' value='true'/>";
		echo "</div>";
		echo "</form>";
	}
	
	echo "</section>";
	echo "</div>";
	echo "</div>";
	echo "</div>";
	echo "</main>";
	mysqli_close($con);
	//footer
	require('stafffooter.php');
?>