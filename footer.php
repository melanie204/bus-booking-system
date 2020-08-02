<?php
    // Page Footer
    echo "<footer class='page-foot bg-base text-center text-md-left'>";
        echo "<section class='section-82'>";
          echo "<div class='shell'>";
            echo "<div class='range'>";
              echo "<div class='cell-sm-6 cell-md-3 offset-top-65 offset-sm-top-0'>";
                echo "<h6>Have Questions?</h6>";
                echo "<div class='reveal-block offset-top-23'><a href='callto:#'>04 190008198</a></div>";
                echo "<div class='reveal-block offset-top-10'><a href='mailto:#'>info@rapidbus.org</a></div>";
                echo "<p class='offset-top-10'>24/7 Dedicated Customer Support</p>";
              echo "</div>";
?>
<?php
              echo "<div class='cell-sm-6 cell-md-4 cell-md-preffix-1 offset-top-65 offset-md-top-0 cell-sm-preffix-3'>";
                echo "<h6>Sign up for exclusive offers</h6>";
                echo "<p class='offset-top-23'>Join our email list. Sign up to receive hot deals, updates on bus schedules and know about exclusive offers on the booking of the tickets.</p>";
                // RD Mailform
                echo "<form data-form-output='form-output-global' data-form-type='subscribe' method='post' action='bat/rd-mailform.php' class='rd-mailform offset-top-34'>";
                  echo "<div class='form-group'>";
                    echo "<input id='contact-email' type='email' name='email' data-constraints='@Required @Email' placeholder='Enter your e-mail' class='form-control'>";
                  echo "</div>";
                  echo "<button type='submit' data-text='sign up' class='btn btn-orange btn-winona btn-xs offset-top-21'><span>Sign up!</span></button>";
                echo "</form>";
              echo "</div>";
            echo "</div>";
          echo "</div>";
        echo "</section>";
        ?>

        <!--staff login section-->
        <?php
        echo "<section class='bg-gray-dark section-10'>";
          echo "<div class='shell'>";
            echo "<p>";
              echo "Copyright &copy; 2018.Rapid Bus All rights reserved.</a>
              <a href='stafflogin.php' style='float: right;'>STAFF LOGIN</a>";
            echo "</p>";
          echo "</div>";
        echo "</section>";
      echo "</footer>";
    echo "</div>";
    ?>
    <?php
    // Global Mailform Output
    echo "<div id='form-output-global' class='snackbars'></div>";
    // PhotoSwipe Gallery
    echo "<div tabindex='-1' role='dialog' aria-hidden='true' class='pswp'>";
      echo "<div class='pswp__bg'></div>";
      echo "<div class='pswp__scroll-wrap'>";
        echo "<div class='pswp__container'>";
          echo "<div class='pswp__item'></div>";
          echo "<div class='pswp__item'></div>";
          echo "<div class='pswp__item'></div>";
        echo "</div>";
        ?>
        <?php
        echo "<div class='pswp__ui pswp__ui--hidden'>";
          echo "<div class='pswp__top-bar'>";
            echo "<div class='pswp__counter'></div>";
            echo "<button title='Close (Esc)' class='pswp__button pswp__button--close'></button>";
            echo "<button title='Share' class='pswp__button pswp__button--share'></button>";
            echo "<button title='Toggle fullscreen' class='pswp__button pswp__button--fs'></button>";
            echo "<button title='Zoom in/out' class='pswp__button pswp__button--zoom'></button>";
            echo "<div class='pswp__preloader'>";
              echo "<div class='pswp__preloader__icn'>";
                echo "<div class='pswp__preloader__cut'>";
                  echo "<div class='pswp__preloader__donut'></div>";
                echo "</div>";
              echo "</div>";
            echo "</div>";
          echo "</div>";
          echo "<div class='pswp__share-modal pswp__share-modal--hidden pswp__single-tap'>";
            echo "<div class='pswp__share-tooltip'></div>";
          echo "</div>";
          ?>

          <?php
          echo "<button title='Previous (arrow left)' class='pswp__button pswp__button--arrow--left'></button>";
          echo "<button title='Next (arrow right)' class='pswp__button pswp__button--arrow--right'></button>";
          echo "<div class='pswp__caption'>";
            echo "<div class='pswp__caption__cent'></div>";
          echo "</div>";
        echo "</div>";
      echo "</div>";
    echo "</div>";
    ?>
    <?php
    // Java script
   echo "<script  type='text/javascript' src='js/core.min.js'></script>";
    echo "<script  type='text/javascript' src='js/script.js' ></script>";
    ?>
  </body>
</html>