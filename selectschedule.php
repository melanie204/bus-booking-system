<?php
	define('TITLE', 'Modify Schedule');
	//header
	require('staffheader.php');
	echo "<center>";
	echo "<main class='page-content'>";
	echo "<section class='section-sm-95 bg-image bg-image-6 text-center section-sm-bottom-100 section-60'>";
	echo "<div class='shell'>";
	//title
	echo "<h1 class='txt-white'>Modify Bus Schedule</h1><br/>";
	
	//connect to database
	require ('dbcon.php');
	//sql query
	$sql = "SELECT * FROM `schedule`";
	//parse query to database
	$myData = mysqli_query($con, $sql);
	
	//form start
	//start of form
	echo "<div class='range'>";
	echo "<div class='cell-lg-8 cell-lg-preffix-2'>";
	echo "<form class='text-left form-search' action='modifyschedule.php' method='post'>";
	echo "<div class='range offset-top-50'>";
	echo "<div class='cell-xs-12'>";
	echo "<div class='form-group select2-custom'>";
	echo "<label for='name' class='form-label'>Select a Bus Schedule:</label>";
	echo "<select name='schedule'>";
	echo "<option value=''>Bus Schedule</option>";
	//if there is data that fullfill the requirement in database
	while($row = mysqli_fetch_array($myData)){
		echo "<option value='".$row['scheduleID']."'>".$row['depLocation']." to ".$row['arrLocation']." (".$row['depTime']."hrs, ".$row['depDate']." to ".$row['arrTime']."hrs, ".$row['arrDate'].")</option>";
	}
	
	echo "</select>";
	echo "</div>";
	echo "</div>";
	//submit button
	echo "<div class='cell-xs-12 offset-top-50'>";
	echo "<button type='submit' data-text='DISPLAY SCHEDULE' class='btn btn-orange btn-fullwidth btn-winona btn-sm'><span>DISPLAY SCHEDULE</span></button>";
	echo "</div>";
	
	echo "</div>";
	echo "</form>";
	echo "</div>";
	echo "</div>";
	mysqli_close($con);
	
	echo "</div>";
	echo "</section>";
	echo "</main>";
	echo "</center>";
	//footer
	require ('stafffooter.php');
?>