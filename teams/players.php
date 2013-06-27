<?php
session_start();
require_once '../team_functions.php';
$db = new TeamFunctions();
$response = array("success" => 0, "error" => 0);

if(!isset($_SESSION['loggedin']))
{
    header("location: ../index.php");
}

$team_id = $_GET['id'];

?>

<html>
<head>
	<link rel="stylesheet" type="text/css" HREF="../stylesheets/main.css">
	<script src="../javascript/jquery.js"></script>
	<title>soccerman | Players</title>
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
			<a href="../home.php?action=logout">Log out</a>
		</p>
	</div>
	<center>
	<a href="../index.php">
		<img src="../images/banner.png">
	</a>
	<div id="players_table">
		<?php
		$players = $db->getTeamPlayers($team_id, $response);
		if($players['success'] == 1 && count($players['players']) > 0)
		{
			echo"<table border='1' cellpadding='10'><tr><td><b>Player</td><td><b>Actions</td></tr>";
			for($i=0; $i<count($players['players']); $i++)
			{
				$id = $players['players'][$i]['id'];
				$name = $players['players'][$i]['name'];
				echo"<tr><td>$name</td><td><a href='#'></a></td></tr>";
			}
			echo"</table>";
		}
		else
		{
			echo("No players to display");
		}

		?>
	</div>
	<br>
	<input type='button' onclick="location.href='../teams.php'" name='cancel' value='Back to Teams'>
</center>
</body
</html>