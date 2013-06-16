<html>
<head>
	<title>soccerman</title>
	<link rel="stylesheet" type="text/css" HREF="main.css">
</head>

<body OnLoad="document.login.email.focus();">
	<center>
	<img src="images/banner.png">
	<div id='loginbox'>
		<form name="login" type='index.php' method='POST'>
		<?php
		//session_start();
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
		<input type='text' name='email' class="form-input" placeholder="Email" required><br>
		<br>
		<input type='password' name='password' class="form-input" placeholder="Password" required><br>
		<input type='submit' name='submit' value='Login'>
		<br>
		<br>
		<br>
		Don't have an account? Register now!
		<br>
		<input type='button' onclick="location.href='register.php'" name='register' value='Register'><br>
		</center>
		</form> 
	</div>
</body>

</html>