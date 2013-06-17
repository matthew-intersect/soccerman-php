<?php
session_start();
require_once 'user_functions.php';
$db = new UserFunctions();

if(isset($_SESSION['loggedin']))
{
	header("location: ./home.php");
	die();
}

if(isset($_POST['createAccount']))
{
	$email = mysql_real_escape_string($_POST['email']);
	$name = mysql_real_escape_string($_POST['name']); 
	$pass = mysql_real_escape_string($_POST['password']);
	$pass2 = mysql_real_escape_string($_POST['confirmPassword']);

	$errmsg_arr = array();
	if($email == '' || $name == '' || $pass == '' || $pass2 == '')
	{
		$errmsg_arr[] = 'Some fields are blank';
		$errflag = true;
	}
   
	if($pass != $pass2)
	{
		$errmsg_arr[] = 'The passwords do not match';
		$errflag = true;
	}

	if($db->isUserExisted($email))
	{
		$errmsg_arr[] = 'User with given email already exists';
		$errflag = true;
	}
	
	if($errflag) 
	{
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: ./register.php");
	}
	else
	{
		$user = $db->storeUser($name, $email, $pass);
		if($user)
		{
			$_SESSION['loggedin'] = "YES"; // Set it so the user is logged in!
			$_SESSION['name'] = $name; // Make it so the username can be called by $_SESSION['name']
			$_SESSION['id'] = $user["id"];
			header("location: ./home.php");
		}
		else
		{
			$errmsg_arr[] = 'Error occurred in registration. Try again later';
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			session_write_close();
			header("location: ./index.php");
		}
	}
}

?>

<html>
<head>
	<title>soccerman</title>
	<link rel="stylesheet" type="text/css" HREF="main.css">
</head>

<body>
	<center>
	<a href="index.php">
		<img src="images/banner.png">
	</a>
	<div id="registerbox">
		<form type='register.php' method='POST'>
		<?php
		if(isset($_SESSION['ERRMSG_ARR']) && !empty($_SESSION['ERRMSG_ARR']))
		{
			echo"<font color='red'>";
			foreach($_SESSION['ERRMSG_ARR'] as $key=>$value)
		    {
		    echo"-$value<br>";
		    }
			echo"</font>";
			unset($_SESSION['ERRMSG_ARR']);
		}
		?>
		<input type='text' name='email' class="form-input" placeholder="Email" required>
		<br><br>
		<input type='text' name='name' class="form-input" placeholder="Full name" required>
		<br><br>
		<input type='password' name='password' class="form-input" placeholder="Password" required>
		<br><br>
		<input type='password' name='confirmPassword' class="form-input" placeholder="Confirm Password" required>
		<br><br>
		<input type='submit' name='createAccount' value='Create Account'>
		<input type='button' onclick="location.href='index.php'" name='cancel' value='Cancel'><br>
		</center>
		</form>
	</div>
</body>

</html>
 