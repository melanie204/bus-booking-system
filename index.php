<?php
  define('TITLE', 'Rapid Bus');
  //header
	require ('header.php');
	echo "<main class='page-content' style='display: flex; flex-direction: row;'>";
	
	echo "<div class='main-container'>";
	?>
  <!--Section Hot Tours-->
<?php
    echo "<section class='section-71 section-bottom-80'>";
      echo "<div class='shell'>";
        //title
        echo "<h2 class='text-center'>OUR SERVICES</h2>";
        echo "<div class='range'>";
          //premium
          echo "<div class='owl-item'>";
            echo "<div class='thumbnail-custom'><img src='images/index-2-370x370.jpg' alt='' width='370' height='370'>";
              echo "<div class='caption'>";
                echo "<h4>PREMIUM</h4>";
                echo "<p>40 seats per bus</p>";
                echo "<div class='h4 price'>15.00/seat</div>"
		if (isset($_SESSION['id'])) {
			echo "<a href='booking.php' data-text='book now!' class='btn btn-winona btn-transparent btn-xs'>book now!</a>";
		}
		else {
			echo "<a href='userlogin.php' data-text='book now!' class='btn btn-winona btn-transparent btn-xs'>book now!</a>";
		}
                echo "</div>";
              echo "</div>";
            echo "</div>";
            //normal
            echo "<div class='owl-item'>";
              echo "<div class='thumbnail-custom'><img src='images/index-3-370x370.jpg' alt='' width='370' height='370'>";
                echo "<div class='caption'>";
                  echo "<h4>NORMAL</h4>";
                  echo "<p>45 seats per bus</p>";
                  echo "<div class='h4 price'>10.00/seat</div>";
		if (isset($_SESSION['id'])) {
			echo "<a href='booking.php' data-text='book now!' class='btn btn-winona btn-transparent btn-xs'>book now!</a>";
		}
		else {
			echo "<a href='userlogin.php' data-text='book now!' class='btn btn-winona btn-transparent btn-xs'>book now!</a>";
		}
                echo "</div>";
              echo "</div>";
            echo "</div>";
            //rapid
            echo "<div class='owl-item'>";
              echo "<div class='thumbnail-custom'><img src='images/index-4-370x370.jpg' alt='' width='370' height='370'>";
                echo "<div class='caption'>";
                  echo "<h4>RAPID</h4>";
                  echo "<p>45 seats per bus</p>";
                  echo "<div class='h4 price'>18.00/seat</div>";
		if (isset($_SESSION['id'])) {
			echo "<a href='booking.php' data-text='book now!' class='btn btn-winona btn-transparent btn-xs'>book now!</a>";
		}
		else {
			echo "<a href='userlogin.php' data-text='book now!' class='btn btn-winona btn-transparent btn-xs'>book now!</a>";
		}
                echo "</div>";
              echo "</div>";
            echo "</div>";
          echo "</div>";
        echo "</div>";
      echo "</section>";
?>
<?php
	  echo '</div>';	
  echo '</main>';
//footer
require('footer.php');
?>
