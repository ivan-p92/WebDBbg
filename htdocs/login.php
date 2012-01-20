<?php

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	header('Location: index.php?i=a');
	die();
}

if(!isset($_POST['naam']) || !isset($_POST['pwd']) || empty($_POST['naam']) || empty($_POST['pwd']))
{
	header('Location: index.php?notice=incomplete_form');
	die();
}

$db = Functions::getDB();
$stmt = $db->prepare("SELECT id FROM users WHERE email = ? AND password = ?;");
$stmt->bind_param('ss', $_POST['naam'], Functions::hashPass($_POST['pwd']));
$stmt->execute();

if($stmt->num_rows == 1)
{
	$stmt->bind_result($id);
	$stmt->fetch();
	
	$_SESSION['userid'] = $id;
	
	$stmt->close();
}
else
{
	
	header('Location: index.php?notice='.$stmt->num_rows.'invalid_login');$stmt->close();
}

