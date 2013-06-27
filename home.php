<?php
session_start();

if(!isset($_SESSION['loggedin']))
{
    header("location: ./index.php");
}

$action = $_GET['action'];

if($action == 'logout')
{
	$_SESSION = array();
    session_destroy();
    header("location: ./index.php");
} 
?>

<html>
<head>
	<link rel="stylesheet" type="text/css" HREF="stylesheets/main.css">
	<script src="javascript/jquery.js"></script>
	<title>soccerman | Home</title>
</head>
<body>
	<div id=logoutbox>
		<p align="right">
			<?php
				session_start();
				echo('Logged in as ');
				echo($_SESSION['name']);
				echo(' |');
			?>
			<a href="home.php?action=logout">Log out</a>
		</p>
	</div>
	<center>
	<a href="index.php"><img src="images/banner.png"></a><br><br>
	<a href="teams.php">My Teams</a>
	</center>
</body
</html>
