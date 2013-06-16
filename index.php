<?php
session_start();
require_once 'user_functions.php';
$db = new UserFunctions();

if(isset($_SESSION['loggedin']))
{
	header("location: ./home.php");
	die();
}
if(isset($_POST['submit']))
{
	$email = mysql_real_escape_string($_POST['email']);
	$password = mysql_real_escape_string($_POST['password']); 
	
	$user = $db->getUserByEmailAndPassword($email, $password);

	if($user != false) {
    	// user found
		$_SESSION['loggedin'] = "YES"; // Set it so the user is logged in!
		$_SESSION['name'] = $user["name"]; // Make it so the username can be called by $_SESSION['name']
		$_SESSION['id'] = $user["id"];
		header("location: ./home.php");
	}
	else {
		$errmsg_arr = array();
		$errmsg_arr[] = 'Username or password were incorrect';
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: ./index.php");
	}
}
?>

<html>
<head>
	<title>soccerman</title>
	<link rel="stylesheet" type="text/css" HREF="main.css">
</head>

<body OnLoad="document.login.email.focus();">
	<center>
	<a href="index.php">
		<img src="images/banner.png">
	</a>
	<div id='loginbox'>
		<form name="login" type='index.php' method='POST'>
		<?php
		//session_start();
		if (isset($_SESSION['ERRMSG_ARR']) && !empty($_SESSION['ERRMSG_ARR']))
		{
			echo"<font color='red'>";
			foreach($_SESSION['ERRMSG_ARR'] as $key=>$value)
			{
				echo"$value<br>";
			}
			echo"</font>";
			unset($_SESSION['ERRMSG_ARR']);
		}
		?>
		<input type='text' name='email' class="form-input" placeholder="Email" required>
		<br><br>
		<input type='password' name='password' class="form-input" placeholder="Password" required>
		<br>
		<input type='submit' name='submit' value='Login'>
		<br><br><br>
		Don't have an account? Register now!
		<br>
		<input type='button' onclick="location.href='register.php'" name='register' value='Register'>
		</center>
		</form> 
	</div>
</body>

</html>