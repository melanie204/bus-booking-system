<?php
	define ('TITLE', 'Log Out');
	//header
	require ('header.php');
	
	//clear session
	unset($_SESSION);
	//destroy session
	session_destroy();
	
	//message for user
	echo "<main class='page-content' style='padding: 50px 35px 20px 45px;'>";
	echo "<h2>You have successfully logged out!</h2><br/>";
	echo "<a href='index.php'>Go Back to Home Page</a>";
	echo "</main>";
	
	//footer
	require ('footer.php');
?>