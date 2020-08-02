<?php
	//HEADER
	require('header.php');
	require('dbcon.php');
	echo "<main class='page-content'>";
	echo "<section class='section-sm-95 bg-image bg-image-6 text-center section-sm-bottom-100 section-60'>";
	echo "<div class='shell'>";
	//title
	echo "<h1 class='txt-white'>USER REGISTRATION</h1><br>";
	
	//CHECK IF FORM IS SUBMITTED
	if (isset($_POST['submitted'])) {
		echo "<div class='cell-lg-8 cell-lg-preffix-2'>";
		echo "<section class='section-71 section-bottom-80'>";
        echo "<form class='rd-mailform text-center form-search2'>";
		
		//store the variables
		$name = $_POST['name']; 
		$password = $_POST['password'];
		$passwordRepeat = $_POST['passwordRepeat'];
		$phoneNo = $_POST['phoneNo'];
		$userID = $_POST['userID']; 
		$bdayDay = $_POST['bday-day'];
		$bdayMonth = $_POST['bday-month'];
		$bdayYear = $_POST['bday-year'];
		
		//checking variables
		$validUserId = true; 
		$validName = false; 
		$validBirthday = false; 
		$validPhoneNo = false; 
		$validPassword = false; 
		$validConfirmPw = false;
		
		//USER ID
		if (!empty($userID)) {
			$query1 = "SELECT * FROM users";
			$myData1 = mysqli_query($con, $query1);
			while ($row1 = mysqli_fetch_array($myData1)) {
				if ($row1['userID'] == $userID) {
					echo "<p>The ID '$userID' has already been taken, please enter a different ID</p>";
					$validUserId = false;
					break;
				}
			}
		}
		else {
			echo "<p>Please enter a User ID</p>";
			$validUserId = false;
		}
		
		//NAME
		if (!empty($name)) {
			if (preg_match("/^[a-zA-Z ]*$/", $name)) {
				$validName = true;
			}
			else {
				echo "<p>Name must only contain letters and white spaces.</p>";
			}
		}
		else {
			echo "<p>Please enter your Name</p>";
		}
		
		//BIRTHDAY
		if (!(empty($bdayDay) || empty($bdayMonth) || empty($bdayYear))) {
			$validBirthday = validateDate($bdayDay, $bdayMonth, $bdayYear);
			
			//if the checking variable was not set to true, display an error message
			if (!$validBirthday) {
				echo "<p>Invalid Birthday selected</p>";
			}
		}
		else {
			echo "<p>Please select your Birthday</p>";
		}
		
		//PHONE NUMBER
		if (!empty($phoneNo)) {
			if (!is_numeric($phoneNo)) {
				echo "<p>Phone Number should contain digits (0 - 9) only</p>";
			} elseif (strlen($phoneNo) < 10 || strlen($phoneNo) > 11) {
				echo "<p>Phone Number should have 10 or 11 digits</p>";
			}
			else {
				$validPhoneNo = true;
			}
		}
		else {
			echo "<p>Please enter your Phone Number</p>";
		}
		
		//PASSWORD
		if (!empty($password)) {
			//password must include at least one upper case letter
			$uppercase = preg_match('@[A-Z]@', $password);
			$lowercase = preg_match('@[a-z]@', $password);
			//password must include at least one number
			$number = preg_match('@[0-9]@', $password);
			//password must include at least one special character
			$specialChars = preg_match('@[^\w]@', $password);

			//validate password strength including password must be at least 8 characters in length
			if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
				echo "Password must be at least 8 characters in length and include at least one lowercase letter, one uppercase letter, one number, and one special character.";
			}
			else {
				$validPassword = true;
			}
		}
		else {
			echo "<p>Please enter a Password</p>";
		}
		
		//CONFIRM PASSWORD
		if (!empty($passwordRepeat)) {
			if ($passwordRepeat == $password) {
				$validConfirmPw = true;
			}
			else {
				echo "<p>The Passwords you've entered do not match</p>";
			}
		}
		else {
			echo "<p>Please re-enter your Password</p>";
		}
		
		if ($validUserId && $validName && $validBirthday && $validPhoneNo && $validPassword && $validConfirmPw) {
			$bdayDay = convertToTwoDigits($bdayDay);
			$bdayMonth = convertToTwoDigits($bdayMonth);
			
			$bday = $bdayDay . "-" . $bdayMonth . "-" . $bdayYear;
			
			$query2 = "INSERT INTO users (userID, userName, userBirthday, userPassword, userPNumber) 
			VALUES ('".$userID."', '".$name."', '".$bday."', '".$password."', '".$phoneNo."')";
			$myData2 = mysqli_query($con, $query2);
			
			if ($myData2) {
				echo "<p>You have successfully registered!</p>";
				echo "<br/><p><a href='userlogin.php'>Log In Now</a></p>";
			}
			else {
				echo '<p style="color:red;">Could not register because:<br/>'.mysqli_error($con).'.The query was:' . $query2 . '.</p>';
				echo "<br/><p><a href='userregistration.php'>Try Again</a></p>";
			}
		}
		else {
			echo "<br/><p><a href='userregistration.php'>Try Again</a></p>";
		}
		
		
		echo "</form>";
		echo "</section>";
		echo "</div>";
	}
	else {
		//title
		echo "<h4 class='txt-white'>Register now to book our bus!</h4>";
		//display the form     
		echo "<div class='range'>";
		echo "<div class='cell-lg-8 cell-lg-preffix-2'>";
		echo "<form class='text-left form-search' action='userregistration.php' method='post'>";
		echo "<p class='small text-xs-right'><font color='red'>* All fields are required</font></p>";
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
		echo "<label for='name' class='form-label'>NAME</label>";
		echo "<input id='name' name='name' type='text' placeholder='Enter Name' data-constraints='@Required' class='form-control'>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
		echo "<div class='range offset-top-50'>";
		echo "<div class='cell-xs-12'>";
		echo "<div class='form-group'>";
		echo "<label for='birthday' class='form-label'>BIRTHDAY</label>";
		echo "<div class='select-date' style='margin-top: 5px;'>";
		echo "<select name='bday-day'>";	
		echo "<option value=''>Day</option>";
		displayDropdownOptions(1, 31, 0, 1);
		echo "</select>&nbsp;";
		echo "<select name='bday-month'>";	
		echo "<option value=''>Month</option>";
		displayDropdownOptions(1, 12, 0, 1);
		echo "</select>&nbsp;";	
		echo "<select name='bday-year'>";	
		echo "<option value=''>Year</option>";
		displayDropdownOptions(2020, 1920, 0, 1);
		echo "</select>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
		echo "<div class='range offset-top-50'>";
		echo "<div class='cell-xs-12'>";
		echo "<div class='form-group'>";
		echo "<label for='phoneNo' class='form-label'>PHONE NUMBER</label>";
		echo "<input id='phoneNo' name='phoneNo' type='text' placeholder='Enter Phone Number' data-constraints='@Required' class='form-control'>";
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
		echo "<div class='range offset-top-50'>";
		echo "<div class='cell-xs-12'>";
		echo "<div class='form-group'>";
		echo "<label for='passwordRepeat' class='form-label'>CONFIRM PASSWORD</label>";
		echo "<input id='passwordRepeat' name='passwordRepeat' type='password' placeholder='Enter Password Again' data-constraints='@Required' class='form-control'>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
		echo "<div class='cell-xs-12 offset-top-50'>";
		//submit button
		echo "<button type='submit' data-text='REGISTER' class='btn btn-orange btn-fullwidth btn-winona btn-sm'><span>REGISTER</span></button>";
		echo "<input type = 'hidden' name = 'submitted' value='true'/>";
		echo "</div>";
		echo "<p class='cell-xs-12 offset-top-30 text-center'>Already have an account?</p>";
		echo "<div class='cell-xs-12 offset-top-30 text-center'><a href='userlogin.php' class='btn-link'>LOGIN NOW!</a></div>";
		echo "</form>";
		echo "</div>";
		echo "</div>";
	}

	echo "</div>";
	echo "</section>";
	echo "</main>";
	mysqli_close($con);
	//FOOTER
	require('footer.php');
?>
