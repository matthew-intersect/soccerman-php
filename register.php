<?php
session_start();
require_once 'user_functions.php';
$db = new UserFunctions();

if(isset($_SESSION['loggedin']))
{
	header("location: ./home.php");
	die();
}



?>

<html>
<head>
	<title>soccerman</title>
	<link rel="stylesheet" type="text/css" HREF="main.css">
</head>

<body>
	<center>
	<img src="images/banner.png">
	<div id="registerbox">
		<form type='register.php' method='POST'>
		<?php
		session_start();
		if (isset($_SESSION['ERRMSG_ARR']) && !empty($_SESSION['ERRMSG_ARR']))
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
		<input type='password' name='retypePassword' class="form-input" placeholder="Confirm Password" required>
		<br><br>
		<input type='submit' name='createAccount' value='Create Account'>
		<input type='button' onclick="location.href='index.php'" name='cancel' value='Cancel'><br>
		</center>
		</form>
	</div>
</body>

</html>
 