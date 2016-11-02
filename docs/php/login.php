<?php 
  require_once 'header.php';
  echo "";
  $error = $user = $pass = "";
  $salt1    = "qm&h*";
  $salt2    = "pg!@";



  if ($loggedin)  die(header('Location: http://lamp.cse.fau.edu/~mhus2015/e-mall/'));
    

  if (isset($_POST['user']))
  {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($user == "" || $pass == "")
        $error = "<div class='error-1'>PLEASE ENTER YOUR DETAILS TO LOG IN</div><div class='error-1'>Some Fields Are Blank</div>";
    else
    {
      $token  = hash('ripemd128', "$salt1$pass$salt2");
      $result = queryMysql("SELECT * FROM buyers WHERE user='$user' AND password='$token'");

      if ($result->num_rows == 0)
      {          
        $error = "<div class='error-4'>INVALID USERNAME/PASSWORD </div>";  
      }
      else
      {
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
        die(header('Location: http://lamp.cse.fau.edu/~mhus2015/e-mall/'));
      }
    }
  }

  echo <<<_END
    <form method='post' action='login.php'>
     <div id='portal'><a href='http://lamp.cse.fau.edu/~mhus2015/'>MyPortal</a></div>
    $error<br>
    <span class='fieldname'></span><input type='text'
      maxlength='16' name='user' placeholder="USERNAME" value='$user'><br>
    <span class='fieldname'></span><input type='password'
      maxlength='16' name='pass' placeholder="PASSWORD" value='$pass'>
_END;

?>

    <br>

    
    <input class="button-1" type='submit' value='LOGIN'>
    </form></div>
    <a href='signup.php'><input class='button-1' type='submit' value='SIGN UP' a href='signup.php'></a>




</body>
</html>

