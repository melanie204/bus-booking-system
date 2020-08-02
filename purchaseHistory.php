<?php
	define('TITLE', 'My Profile');
	//header
	require('header.php');
	echo "<main class='page-content' style='display: flex; flex-direction: row; padding-top:10px;'>";

	//user profile navigation bar
	echo "<div class='profile-navbar' style='padding: 40px 20px 25px 20px; width: 20%; background-color: #ccc;'>";
	echo "<h3><a href='modifyuser.php'>My Profile</a></h3>";
	echo "<br/>";
	echo "<h3><a href='purchaseHistory.php'>Purchase History</a></h3>";
	echo "</div>";

	//table content
	echo "<div class='profile-content' style='padding: 30px 20px 25px 20px; width: 80%; background-color: #f1f1f1;'>";
	//title
	echo "<h2>PURCHASE HISTORY</h2><br/>";

	//connect to database
	include ('dbcon.php');

	//get userID from session
	$userID=$_SESSION['id'];

	//SQL Query
	$sql="SELECT * FROM orders WHERE userID='$userID'";
	$result=mysqli_query($con,$sql);
	
	$count = 0;

	//if there is data in the database
	while($row=mysqli_fetch_assoc($result)){
		if ($count == 0) {
			echo "<div class='table-bordered'>";
			echo "<center>";
			echo "<table width='925'>";
			//table header
			echo "<tr>";
			echo "<th>Order ID</th>";
			echo "<th width='140px'>Depart From</th>";
			echo "<th width='140px'>Arrive At</th>";
			echo "<th>No. of Children</th>";
			echo "<th>No. of Adults</th>";
			echo "<th>No. of Senior Citizens</th>";
			echo "<th>Bus ID</th>";
			echo "<th>Total Payment (RM)</th>";
			echo "</tr>";
		}
		
		if ($count % 2 == 0) {
			echo "<tr style='background-color: #ccc;'>";
		}
		else {
			echo "<tr>";
		}
		
		echo "<td>".$row['orderNumber']."</td>";
		echo "<td>".$row['depLocation'].",<br/>".$row['depTime']."hr<br/>".$row['depDate']."</td>";
		echo "<td>".$row['arrLocation'].",<br/>".$row['arrTime']."hr<br/>".$row['arrDate']."</td>";
		echo "<td>".$row['childrenTickets']."</td>";
		echo "<td>".$row['adultTickets']."</td>";
		echo "<td>".$row['seniorTickets']."</td>";
		echo "<td>".$row['busID']."</td>";
		echo "<td>".$row['orderTotalPrice']."</td>";
		echo "</tr>";
		
		$count++;
	}   
	
	if ($count > 0) {
		echo "</table>";
		echo "</center>";
		echo "</div>";	
	}
	else {
		echo "<p>It seems you have not made any purchases yet...</p>";
		echo "<p>Click <a href='booking.php'>here</a> to start your first purchase!</p>";
	}
	
	echo "</div>";
	echo "</main>";
	mysqli_close($con);
	//footer
	require('footer.php');
?>
