<?php
	define('TITLE', 'Modify Schedule');
	require ('staffheader.php');
	echo "<center>";
	echo "<main class='page-content' style='padding: 40px 125px 25px 125px;'>";
	
	//title
	echo "<h1>Add Schedule</h1>";
	echo "<h3>Import from CSV</h3><br/>";
	
	require ('dbcon.php');
	
	//if user click the submit button
	if (isset($_POST['submitted'])) {
		$filename=$_FILES["file"]["tmp_name"];

        if($_FILES["file"]["size"]>0){
            $file=fopen($filename,"r");

            while(($getdata=fgetcsv($file,10000,","))!== FALSE){
				//sql query
                $sql="INSERT INTO schedule (scheduleID,depLocation,arrLocation,depTime,arrTime,depDate,arrDate,ticketLeft,busID) 
				VALUES ('".$getdata[0]."','".$getdata[1]."','".$getdata[2]."','".$getdata[3]."','".$getdata[4]."','".$getdata[5]."','".$getdata[6]."','".$getdata[7]."','".$getdata[8]."')"  ;

				//parse the query to the database to insert the data into the database
                $result=mysqli_query($con,$sql);
                
                //pop up message if the import button is being clicked by the user
                if(!($result)){
                    
                    echo "<script language='javascript'>
                        window.alert('Failed to import schedules.');
                        window.location.href='import.php';</script>";
                }else{
                    echo "<script language='javascript'>
                        window.alert('Successfully imported schedules.');
                        window.location.href='import.php';</script>";
                }
            }
			mysqli_close($con);
            fclose($file);
        } 
		else {
            echo "<script language='javascript'>
                window.alert('No schedules found in the uploaded file.');
                window.location.href='import.php';</script>";
        }
	}
	else {
		//start of form
		echo "<form action='import.php' method='post' enctype='multipart/form-data'>";
		echo "<input type='file' name='file' />";
		echo "<input type='submit' name='submit' value='Submit'/>";
		echo "<input type='hidden' name='submitted' value='true'>";
		echo "</form>";
	}
	
	
	echo "</main>";
	echo "</center>";
	require('stafffooter.php');
?>