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
  
  <div id='portal'><a href='http://lamp.cse.fau.edu/~mhus2015/e-mall'>E-Mall</a></div>
  <br>
  <div id='logsign'>Please Register</div><br>
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
    <form method='post' action='signup.php'>$error
    <span class='fieldname'></span>
    <input type='text' maxlength='16' name='user' placeholder='USERNAME' value='$user'
      onBlur='checkUser(this)'><span id='info'></span><br>
    <span class='fieldname'></span>
    <input type='PASSWORD' maxlength='16' name='pass' placeholder='PASSWORD'
      value='$pass'>



<span id='info'></span><br>
	
	<span class='fieldname'></span>
	<input type='text' maxlength='16' name='fn' placeholder='First Name'
      value='$firstname'>
	
	<span id='info'></span><br>
	
	<span class='fieldname'></span>
	<input type='text' maxlength='16' name='ln' placeholder='Last Name'
      value='$lastname'>
	
	<span id='info'></span><br>
	
	<span class='fieldname'></span>
	<input type='text' maxlength='32' name='adres' placeholder='Address'
      value='$address'>
	
	<span id='info'></span><br>
	
	<span class='fieldname'></span>
	<input type='text' maxlength='16' name='ccn' placeholder='Credit Card Number'
      value='$creditcard'>

<br>
_END;



?>

    <div class = "space2" ></div>  

    <input class='button-1' type='submit' value='REGISTER'>

    </form></div>

  </body>
    <a href='login.php'><input class='button-1' type='submit' value='SIGN IN' a href='login.php'></a>

</html>
