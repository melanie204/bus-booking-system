<?php
	define('TITLE', 'My Profile');
	require('header.php');
	echo "<main class='page-content' style='display: flex; flex-direction: row; padding-top:10px;'>";
	
	//user profile navigation bar
	echo "<div class='profile-navbar' style='padding: 40px 20px 25px 20px; width: 20%; background-color: #ccc;'>";
	echo "<h3><a href='modifyuser.php'>My Profile</a></h3>";
	echo "<br/>";
	echo "<h3><a href='purchaseHistory.php'>Purchase History</a></h3>";
	echo "</div>";
	
	//user profile content
	echo "<div class='profile-content' style='padding: 30px 20px 25px 20px; width: 80%; background-color: #f1f1f1;'>";
	
	if (isset($_POST['submitted'])) {
		//connect to database
		require('dbcon.php');
		//retrieve user record based on session id
		$sql = "SELECT * FROM `users` WHERE userID='".$_SESSION['id']."'";
		$myData = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($myData);
		
		//get the new values submitted by user in the form
		$name = $_POST['name'];
		$bdayDay = $_POST['bday-day'];
		$bdayMonth = $_POST['bday-month'];
		$bdayYear = $_POST['bday-year']; 
		$phoneNo = $_POST['hp'];
		
		//set all checking variables to false
		$validName = false;
		$validBirthday = false;
		$validPhoneNo = false;
		$filledForm = false;
		$isLeapYear = false;
		
		//check for any missing fields
		if (empty($name) && (empty($bdayDay) || empty($bdayMonth) || empty($bdayYear)) && empty($phoneNo)) {
			echo "<p>Please enter your Name, Phone Number and select your Birthday</p>";
		} else if (empty($name) && (empty($bdayDay) || empty($bdayMonth) || empty($bdayYear))) {
			echo "<p>Please enter your Name and select your Birthday</p>";
		} else if (empty($name) && empty($phoneNo)) {
			echo "<p>Please enter your Name and Phone Number</p>";
		} else if ((empty($bdayDay) || empty($bdayMonth) || empty($bdayYear)) && empty($phoneNo)) {
			echo "<p>Please enter your Phone Number and select your Birthday</p>";
		} else if (empty($name)) {
			echo "<p>Please enter your Name</p>";
		} else if ((empty($bdayDay) || empty($bdayMonth) || empty($bdayYear))) {
			echo "<p>Please select your birthday</p>";
		} else if (empty($phoneNo)) {
			echo "<p>Please enter your Phone Number</p>";
		} else {
			//if none are missing, set the checking variable to true
			$filledForm = true;
		}
		
		//if user's name contain characters other than alphabets and white spaces
		if (!empty($name) && !preg_match("/^[A-Za-z ]*$/", $name)) {
			//display error message
			echo "<p>Name should contain letters and white spaces only</p>";
		}
		else {
			//otherwise, set the checking variable to true
			$validName = true;
		}
		
		//check validity of birthday if none of the birthday fields are empty
		if (!(empty($bdayDay) || empty($bdayMonth) || empty($bdayYear))) {
			$validBirthday = validateDate($bdayDay, $bdayMonth, $bdayYear);
			
			//if the checking variable was not set to true, display an error message
			if (!$validBirthday) {
				echo "<p>Invalid Birthday selected</p>";
			}
		}
		
		//check whether phone is digits only and has an appropriate length (10 / 11)
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
		
		//start process for adding record to database if nothing is wrong with user input
		if ($validName && $validBirthday && $validPhoneNo) {
			//make sure birthday is in dd-mm-yyyy format
			//if day and month is 1 digit only, add a "0" in front of it
			$bdayDay = convertToTwoDigits($bdayDay);
			$bdayMonth = convertToTwoDigits($bdayMonth);
			
			//combine day, month and year back into one string
			$bday = $bdayDay . "-" . $bdayMonth . "-" . $bdayYear;
			
			//query for updating user record
			$query = "
			UPDATE users
			SET userName='".$name."', userBirthday='".$bday."', userPNumber	='".$phoneNo."'
			WHERE userID='".$_SESSION['id']."'";
			
			//inform user whether the update was successful
			if (mysqli_query($con, $query)) {
				print '<p>User information updated!</p>';
			}
			else {
				print '<p style="color:red;">Could not update user information because:<br/>'.mysqli_error($con).'.The query was:' . $query . '.</p>';
			}
		}
		
		//provide link for user to return to their profile page
		print'<p><a href="modifyuser.php">Go Back</a></p>';
		
		//close database connection
		mysqli_close($con);
	}
	else {
		//connect to database
		require('dbcon.php');
		//retrieve user record based on session id
		$sql = "SELECT * FROM `users` WHERE userID='".$_SESSION['id']."'";
		$myData = mysqli_query($con, $sql);
		$row = mysqli_fetch_array($myData);
		
		//separate birthday string into day, month and year
		$birthday = explode("-", $row['userBirthday'], 3);
		
		//display form
		echo "<h2>MY PROFILE</h2><br/>";
		echo "<form action='modifyuser.php' method='post'>";
		//NAME FIELD
		echo "<h4>Name</h4>";
		//set default value to the user's name 
		echo "<input type='text' name='name' size='40' style='height: 50px; padding: 0 15px; margin-top: 5px;' value='".$row['userName']."'/><br/><br/>";
		//BIRTHDAY FIELD
		echo "<h4>Birthday</h4>";
		echo "<div class='select-date' style='margin-top: 5px;'>";
		echo "<select name='bday-day'>";	
		echo "<option value=''>Day</option>";
		//use loop to display day 1 to 31
		//if the user's birthday day matches a number, that number is made the default value
		displayDropdownOptions(1, 31, $birthday[0], 1);
		echo "</select>&nbsp;";
		echo "<select name='bday-month'>";	
		echo "<option value=''>Month</option>";
		//use loop to display month 1 to 12
		//if the user's birthday month matches a number, that number is made the default value
		displayDropdownOptions(1, 12, $birthday[1], 1);
		echo "</select>&nbsp;";	
		echo "<select name='bday-year'>";	
		echo "<option value=''>Year</option>";
		//use loop to display year 1920 to 2020
		//if the user's birthday year matches a number, that number is made the default value
		displayDropdownOptions(2020, 1920, $birthday[2], 1);
		echo "</select>";
		echo "</div><br/>";
		//PHONE NUMBER FIELD
		echo "<h4>Phone Number</h4>";
		////set default value to the user's phone number 
		echo "<input type='text' name='hp' size='40' style='height: 50px; padding: 0 15px; margin-top: 5px;' value='".$row['userPNumber']."'/><br/><br/><br/>";
		echo "<input type='submit' name='submit' value='Save Changes' style='width: 160px; height: 50px; font-size: 20px;'/>";
		echo "<input type='hidden' name='submitted' value='true' />";
		echo "</form>";
		
		mysqli_close($con);
	}
	
	echo "</div>";
	echo "</div>";
	echo "</main>";
	require('footer.php');
?>