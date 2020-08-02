<?php
	session_start();
	
	require ('functions.php');
?>

<!DOCTYPE html>
<html lang='en' class='wide wow-animation'>
  <head>
    <!-- Site Title-->
    <title>Rapid Bus</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Montserrat:400,700%7CLato%7CRoboto">
    <link rel="stylesheet" href="css/style.css">
  </head>

  <body>
      <?php
    //Page
    echo "<div class='page'>";
      // Page Header
      echo "<header class='page-head'>";
        // RD Navbar
        echo "<div class='rd-navbar-wrap'>";
          echo "<nav data-layout='rd-navbar-fixed' data-sm-layout='rd-navbar-fullwidth' data-md-layout='rd-navbar-fullwidth' data-md-device-layout='rd-navbar-fixed' data-lg-layout='rd-navbar-static' data-lg-device-layout='rd-navbar-static' data-sm-stick-up-offset='150px' data-lg-stick-up-offset='150px' class='rd-navbar'>";
            echo "<div class='rd-navbar-inner'> ";
            ?>     
            <?php
              // RD Navbar Panel
              echo "<div class='rd-navbar-wrapper'>";
                echo "<div class='rd-navbar-panel'>";
                  // RD Navbar Toggle
                  echo "<button data-rd-navbar-toggle='.rd-navbar-nav-wrap' class='rd-navbar-toggle'><span></span></button>";
                  // RD Navbar Brand
				  if (isset($_SESSION['staff'])) {
					  echo "<div class='rd-navbar-brand'><a href='logout.php' class='brand-name'>";
				  }
				  else {
					  echo "<div class='rd-navbar-brand'><a href='index.php' class='brand-name'>";
				  }
                  
                      echo "<div class='logo'><img src='images/logo1.png' alt=''></div></a></div>";
                echo "</div>";
                ?>
                <?php
                echo "<div class='rd-navbar-nav-wrap'>";
                  // RD Navbar Nav
                  echo "<ul class='rd-navbar-nav'>";
				  if (isset($_SESSION['staff'])) {
					echo "<li><a href='addschedule.php'><span class='material-icons-library_add icon icon-white icon-lg'></span><span>&nbsp;&nbsp;ADD SCHEDULE&nbsp;&nbsp;</span><span class='triangle'></span></a></li>";
                    echo "<li><a href='selectschedule.php'><span class='material-icons-event_note icon icon-white icon-lg'></span><span>&nbsp;&nbsp;MODIFY SCHEDULE&nbsp;&nbsp;</span><span class='triangle'></span></a></li>";
                    echo "<li><a href='deleteschedule.php'><span class='material-icons-delete icon icon-white icon-lg'></span><span>&nbsp;&nbsp;DELETE SCHEDULE&nbsp;&nbsp;</span><span class='triangle'></span></a></li>";
                    echo "<li><a href='deletebus.php'><span class='material-icons-directions_bus icon icon-white icon-lg'></span><span>&nbsp;&nbsp;DELETE BUSES&nbsp;&nbsp;</span><span class='triangle'></span></a></li>";
                    echo "<li><a href='addbus.php'><span class='material-icons-directions_bus icon icon-white icon-lg'></span><span>&nbsp;&nbsp;ADD BUSES&nbsp;&nbsp;</span><span class='triangle'></span></a></li>";
				  }
                  echo "</ul>";
                ?>
            <?php
              echo "</div>";
            echo "</div>";
          echo "</nav>";
        echo "</div>";
      echo "</header>";
      ?>