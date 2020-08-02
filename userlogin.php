<?php
	//HEADER
	require('header.php');
	//connect to database
	require('dbcon.php');
	
	if (isset($_POST['submitted'])) {
		//check for blank / not blank fields
		if ( (!empty($_POST['userID'])) && (!empty($_POST['password'])) ) {
			//sql query
			$query="SELECT * FROM users WHERE userID='".$_POST['userID']."' AND userPassword='".$_POST['password']."'";

			$sql = $con->query($query);

			//if there is data that fullfill the requirement in the database
			if ($sql->num_rows > 0){
				//set session
				$_SESSION['id'] = $_POST['userID'];
				echo "<SCRIPT LANGUAGE='JavaScript'>window.alert('Welcome Back!')
				window.location.href='booking.php';</script>";
			}
			else{
				echo "<SCRIPT LANGUAGE='JavaScript'>window.alert('Your ID or password is wrong. Please try again.')
				window.location.href='userlogin.php';</script>";
			}
		}
		//IF USER FORGETS A FIELD
		else {
			echo "<SCRIPT LANGUAGE='JavaScript'>window.alert('Please make sure you fill in all the fields. All fields are compulsory.')
			window.location.href='userlogin.php';</script>";
		}
	}
	else {
		//Page Content
		echo "<main class='page-content'>";
		echo "<section class='section-sm-95 bg-image bg-image-6 text-center section-sm-bottom-100 section-60'>";
		echo "<div class='shell'>";
		echo "<h1 class='txt-white'>USER LOGIN</h1>";
		echo "<div class='range'>";
		echo "<div class='cell-lg-8 cell-lg-preffix-2'>";
		echo "<form class='text-left form-search' action='userlogin.php' method='post'>";
		echo "<div class='range offset-top-50'>";
		echo "<div class='cell-xs-12'>";
		echo "<div class='form-group'>";
		echo "<label for='userID' class='form-label'>USER ID</label>";
		echo "<input id='userID' name='userID' type='text' placeholder='Enter User ID' data-constraints='@Required' class='form-control'>";
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
		echo "<button type='submit' data-text='LOGIN' class='btn btn-orange btn-fullwidth btn-winona btn-sm'><span>LOGIN</span></button>";
		echo "<input type = 'hidden' name = 'submitted' value='true'/>";
		echo "</div>";
		echo "<p class='cell-xs-12 offset-top-30 text-center'>Don't have an account with us?</p>";
		echo "<div class='cell-xs-12 offset-top-30 text-center'><a href='userregistration.php' class='btn-link'>REGISTER NOW!</a></div>";
		echo "</form>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
		echo "</section>";
		echo "</main>";
	}
	
	mysqli_close($con);
	//FOOTER
	require('footer.php');
?>
