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
$stmt = $db->prepare("SELECT id FROM users WHERE email = ? AND password = ?");
$pwd = Functions::hashPass($_POST['pwd']);
$stmt->bind_param('ss', &$_POST['naam'], &$pwd);


if($stmt->num_rows == 1)
{
	$stmt->bind_result($id);
	$stmt->fetch();
	
	$_SESSION['userid'] = $id;
	
	$stmt->close();
}
else
{
	$stmt->close();
	header('Location: index.php?notice=invalid_login');
}

