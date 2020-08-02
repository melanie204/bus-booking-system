<?php
	//HEADER
	require('staffheader.php');
	//connect to database
	require('dbcon.php');
	
	if (isset($_POST['submitted'])) {
		//check for blank / not blank fields
		if ( (!empty($_POST['staffID'])) && (!empty($_POST['password'])) ) {
			//sql query
			$query="SELECT * FROM staff WHERE staffID='".$_POST['staffID']."' AND staffPassword='".$_POST['password']."'";

			$sql = $con->query($query);

			//if there is data that fullfill the requirement in the database
			if ($sql->num_rows > 0){
				//set session
				$_SESSION['staff'] = $_POST['staffID'];
				echo "<SCRIPT LANGUAGE='JavaScript'>window.alert('You are now logged in!')
				window.location.href='addschedule.php';</script>";
			}
			else{
				//if the data cant be found in the database
				echo "<SCRIPT LANGUAGE='JavaScript'>window.alert('Your ID or password is wrong. Please try again.')
				window.location.href='stafflogin.php';</script>";
			}
		}
		//IF USER FORGETS A FIELD
		else {
			echo "<SCRIPT LANGUAGE='JavaScript'>window.alert('Please make sure you fill in all the fields. All fields are compulsory.')
			window.location.href='stafflogin.php';</script>";
		}
	}
	else {
		//Page Content
		echo "<main class='page-content'>";
		echo "<section class='section-sm-95 bg-image bg-image-6 text-center section-sm-bottom-100 section-60'>";
		echo "<div class='shell'>";
		//title
		echo "<h1 class='txt-white'>STAFF LOGIN</h1>";
		echo "<div class='range'>";
		echo "<div class='cell-lg-8 cell-lg-preffix-2'>";
		//form start
		echo "<form class='text-left form-search' action='stafflogin.php' method='post'>";
		echo "<div class='range offset-top-50'>";
		echo "<div class='cell-xs-12'>";
		echo "<div class='form-group'>";
		echo "<label for='staffID' class='form-label'>STAFF ID</label>";
		echo "<input id='staffID' name='staffID' type='text' placeholder='Enter Staff ID' data-constraints='@Required' class='form-control'>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
		echo "<div class='range offset-top-50'>";
		echo "<div class='cell-xs-12'>";
		echo "<div class='form-group'>";
		echo "<label for='password' class='form-label'>PASSWORD</label>";
		echo "<input id='password' name='password' type='password' placeholder='Enter Password' data-constraints='@Required' class='form-control'>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
		echo "<div class='cell-xs-12 offset-top-50'>";
		//submit button
		echo "<button type='submit' data-text='LOGIN' class='btn btn-orange btn-fullwidth btn-winona btn-sm'><span>LOGIN</span></button>";
		echo "<input type = 'hidden' name = 'submitted' value='true'/>";
		echo "</div>";
		echo "</form>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
		echo "</section>";
		echo "</main>";
	}
	
	mysqli_close($con);
	//FOOTER
	require('stafffooter.php');
?>
