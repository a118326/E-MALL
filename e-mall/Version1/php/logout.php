<?php // Example 26-12: logout.php
  require_once 'header.php';

  if (isset($_SESSION['user']))
  {
    destroySession();
    echo "<div class='loggedout'>Thanks for stopping by! You have been logged out. " .
         "<a href='../index.php'>Log back in.</a>";
  }
  else echo "<div class='loggedout'><br>" .
            "You cannot log out because you are not logged in<br><a href='login.php'>LOG IN</a>";
?>

    <br><br></div>
  </body>
</html>
