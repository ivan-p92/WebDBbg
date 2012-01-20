<?php

if($_SERVER['REQUEST'] != 'POST')
{
	header('Location: index.php');
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

if($stmt->num_rows === 1)
{
	$stmt->bind_result($id);
	$stmt->fetch();
	
	$_SESSION['userid'] = $id;
	
	$stmt->close();
}
else
{
	%stmt->close();
	header('Location: index.php?notice=invalid_login');
}

