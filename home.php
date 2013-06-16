<?php
session_start();

if(!isset($_SESSION['loggedin']))
{
    header("Location: ./index.php");
}

$action = $_GET['action'];

if ($action == 'logout') {
	$_SESSION = array();
    session_destroy();
    header("Location: ./index.php");
} 
?>

home 
<br>
<a href="home.php?action=logout">Logout</a>