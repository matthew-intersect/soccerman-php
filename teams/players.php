<?php
session_start();
require_once '../team_functions.php';
$db = new TeamFunctions();
$response = array("success" => 0, "error" => 0);

if(!isset($_SESSION['loggedin']))
{
    header("location: ../index.php");
}

$action = $_GET['action'];
$team_id = $_GET['id'];

if($action == "delete")
{
	$player = $_GET['player'];
	$res = $db->removePlayer($team_id, $player);
	if($res['success'] == 1)
	{
		$sucmsg_arr = array();
		$sucmsg_arr[] = 'Player successfully removed from team';
		$_SESSION['SUCMSG_ARR'] = $sucmsg_arr;
		session_write_close();
		header("location: ./players.php?id=$team_id");
	}
	else
	{
		$errmsg_arr = array();
		$errmsg_arr[] = 'Player could not be removed from team. Please try again';
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: ./players.php?id=$team_id");
	}
}

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
	<div id="players_message">
	<?php
		if(isset($_SESSION['ERRMSG_ARR']) && !empty($_SESSION['ERRMSG_ARR']))
		{
			echo"<font color='red'>";
			foreach($_SESSION['ERRMSG_ARR'] as $key=>$value)
			{
				echo"$value<br>";
			}
			echo"</font>";
			unset($_SESSION['ERRMSG_ARR']);
		}
		if(isset($_SESSION['SUCMSG_ARR']) && !empty($_SESSION['SUCMSG_ARR']))
		{
			echo"<font color='green'>";
			foreach($_SESSION['SUCMSG_ARR'] as $key=>$value)
			{
				echo"$value<br>";
			}
			echo"</font>";
			unset($_SESSION['SUCMSG_ARR']);
		}
	?>
	</div><br>
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
				echo"<tr><td>$name</td><td><a href='players.php?action=delete&id=$team_id&player=$id' onclick='return confirm(";
				echo'"Are you sure you want to delete this player from the team?"';
				echo")'><img src='../images/action_delete.png'></a></td></tr>";
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