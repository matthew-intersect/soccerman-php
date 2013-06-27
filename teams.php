<?php
session_start();
require_once 'team_functions.php';
$db = new TeamFunctions();
$response = array("success" => 0, "error" => 0);

if(!isset($_SESSION['loggedin']))
{
    header("location: ./index.php");
}


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
	<title>soccerman | Teams</title>
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
	<a href="index.php">
		<img src="images/banner.png">
	</a>
	<div id="teams_table">
		<?php
		$teams = $db->getPlayersTeams($response, $_SESSION['id']);
		if($teams['success'] == 1 && count($teams['teams']) > 0)
		{
			echo"<table border='1' cellpadding='10'><tr><td><b>Team</td><td><b>Manager</td><td><b>Actions</td></tr>";
			for($i=0; $i<count($teams['teams']); $i++)
			{
				$id = $teams['teams'][$i]['id'];
				$name = $teams['teams'][$i]['name'];
				$manager = $teams['teams'][$i]['manager'];
				echo"<tr><td>$name</td><td>$manager</td><td><a href='teams/players.php?id=$id'>
					<img src='images/player.png'></a> <a href='teams/matches.php?id=$id'>
					<img src='images/matches.png'></a></td></tr>";
			}
			echo"</table>";
		}
		else
		{
			echo("No teams to display");
		}

		?>
	</div>
	<br>
	<input type='button' onclick="location.href='home.php'" name='cancel' value='Back'>
</center>
</body
</html>