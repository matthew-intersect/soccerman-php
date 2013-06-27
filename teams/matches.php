<?php
session_start();
require_once '../match_functions.php';
$db = new MatchFunctions();
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
	<title>soccerman | Matches</title>
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
	<div id="matches_table">
		<?php
		$matches = $db->getMatches($team_id, $response);
		if($matches['success'] == 1 && count($matches['matches']) > 0)
		{
			echo"<table border='1' cellpadding='10'><tr><td><b>Opponent</td>
				<td><b>Ground</td><td><b>Date</td><td><b>Game Time</td><td><b>Actions</td></tr>";
			for($i=0; $i<count($matches['matches']); $i++)
			{
				$id = $matches['matches'][$i]['id'];
				$opponent = $matches['matches'][$i]['opponent'];
				$venue = $matches['matches'][$i]['venue'];
				$time = $matches['matches'][$i]['time'];
				echo"<tr><td>$opponent</td><td>$venue</td><td>";
				echo date("d-m-Y", $time/1000);
				echo"</td><td>";
				echo date("g:i A", $time/1000);
				echo"</td><td><a href='#'></a></td></tr>";
			}
			echo"</table>";
		}
		else
		{
			echo("No matches to display");
		}

		?>
	</div>
	<br>
	<input type='button' onclick="location.href='../teams.php'" name='cancel' value='Back to Teams'>
</center>
</body
</html>