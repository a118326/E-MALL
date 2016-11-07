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

  echo <<<_END
  <script>
    function checkUser(user)
    {
      if (user.value == '')
      {
        O('info').innerHTML = ''
        return
      }

      params  = "user=" + user.value
      request = new ajaxRequest()
      request.open("POST", "checkuser.php", true)
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
      request.setRequestHeader("Content-length", params.length)
      request.setRequestHeader("Connection", "close")

      request.onreadystatechange = function()
      {
        if (this.readyState == 4)
          if (this.status == 200)
            if (this.responseText != null)
              O('info').innerHTML = this.responseText
      }
      request.send(params)
    }

    function ajaxRequest()
    {
      try { var request = new XMLHttpRequest() }
      catch(e1) {
        try { request = new ActiveXObject("Msxml2.XMLHTTP") }
        catch(e2) {
          try { request = new ActiveXObject("Microsoft.XMLHTTP") }
          catch(e3) {
            request = false
      } } }
      return request
    }
  </script>
_END;

  $error = $user = $pass = $firstname = $lastname = $address = $creditcard = "";
    $salt1    = "qm&h*";
    $salt2    = "pg!@";
  if (isset($_SESSION['user'])) destroySession();

  if (isset($_POST['user']))
  {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    
	$firstname = sanitizeString($_POST['fn']);
	$lastname = sanitizeString($_POST['ln']);
	$address = sanitizeString($_POST['adres']);
	$creditcard = sanitizeString($_POST['ccn']);



    if ($user == "" || $pass == "" || $firstname == "" || $lastname == "" || $address == "" || $creditcard == "")
      $error = "<center>Not all fields were entered</center><br>";
    else
    {
      $result = queryMysql("SELECT * FROM buyers WHERE user='$user'");

      if ($result->num_rows)
        $error = "That username already exists<br><br>";
      else
      {
        $token    = hash('ripemd128', "$salt1$pass$salt2");

        queryMysql("INSERT INTO buyers VALUES('$user', '$token', '$firstname', '$lastname' , '$address', '$creditcard')");








        die("<h4>Account created</h4><a href='login.php'>Please Log in.</a><br><br>");
      }
    }
  }

  echo <<<_END
  <div class="container">
  <header class="jumbotron" align = "center">
            <h2>Sign up</h2>
            <div class="container">
    <form method='post' action='signup.php'>$error
    
    <label>Username:</label>
    <span class='fieldname'></span>    
    <input type='text' maxlength='16' name='user' placeholder='USERNAME' value='$user'
      onBlur='checkUser(this)'>
    
      <span id='info'></span><br><br>
      <label> Password:</label>
    <span class='fieldname'></span>
    <input type='PASSWORD' maxlength='16' name='pass' placeholder='PASSWORD'
      value='$pass'>


<span id='info'></span><br><br>
	 <label>First name:</label>
	<span class='fieldname'></span>
	<input type='text' maxlength='16' name='fn' placeholder='First Name'
      value='$firstname'>

	<span id='info'></span><br><br>
	 <label>Last name:</label>
	<span class='fieldname'></span>
	<input type='text' maxlength='16' name='ln' placeholder='Last Name'
      value='$lastname'>

	<span id='info'></span><br><br>
	 <label>  Address:</label>
	<span class='fieldname'></span>
	<input type='text' maxlength='32' name='adres' placeholder='Address'
      value='$address'>

	<span id='info'></span><br><br>
	 <label>Credit number:</label>
	<span class='fieldname'></span>
	<input type='text' maxlength='16' name='ccn' placeholder='Credit Card Number'
      value='$creditcard'>
<br><br>
_END;



?>

    <input class='button-1' type='submit' value='REGISTER'>
    </form></div>
    <div><h5>Already have a E-mall Account?</h5></div>
 <a href='login.php'>
     <input class='button-1' type='submit' value='SIGN IN' a href='login.php'>
    </a>
    
</header>
<hr>
</div>
  </body>
</html>
