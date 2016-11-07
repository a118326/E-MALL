
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-Mall</title>
    <style>
    label{
    display:inline-block;
    width:100px;
}</style>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/heroic-features.css" rel="stylesheet">
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
			<a class="navbar-brand" href="../index.php">Home</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
<?php 
  require_once 'header.php';
  echo "";
  $error = $user = $pass = "";
  $salt1    = "qm&h*";
  $salt2    = "pg!@";



  if ($loggedin)  die(header('Location: http://lamp.cse.fau.edu/~mchen2015/docs/userpage.php'));
    

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
        die(header('Location: http://lamp.cse.fau.edu/~mchen2015/docs/userpage.php'));
      }
    }
  }

  echo <<<_END
  <div class="container">
  <header class="jumbotron" align = "center">
            <h2>Sign in</h2>
    <form method='post' action='login.php'>
    <div class="container">
    $error<br>
    <label>Account:</label>
    <span class='fieldname'></span><input type='text'
      maxlength='16' name='user' placeholder="USERNAME" value='$user'>
      <br><br><label>Password:</label>
    <span class='fieldname'></span><input type='password'
      maxlength='16' name='pass' placeholder="PASSWORD" value='$pass'>
       <br>
_END;

?>

    <br>

    
    <input class="button-1" type='submit' value='LOGIN'>
    </form>
    </div>
<div><h5>New to E-mall?</h5></div>
    <a href='signup.php'>
        <input class='button-1' type='submit' value='SIGN UP' a href='signup.php'></a>


</header>
<hr>
</div>
</body>
</html>

