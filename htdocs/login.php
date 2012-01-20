<?php
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	header('Location: index.php');
	die();
}

if(!isset($_POST['naam']) || !isset($_POST['pwd']) || empty($_POST['naam']) || empty($_POST['pwd']))
{
	header('Location: index.php?notice=incomplete_form');
	die();
}

$sql = "SELECT id FROM users WHERE email = :email AND password = :pass;";
$pwd = Functions::hashPass($_POST['pwd']);
$email = $_POST['naam'];


$db = Functions::getDB();
$stmt = $db->prepare($sql);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':pass', $pwd, PDO::PARAM_STR);
$stmt->execute();

if($stmt->rowCount() == 1)
{
	$row = $stmt->fetch();	
	$_SESSION['userid'] = $row['id'];

	header("Location index.php");
}
else
{
	header('Location: index.php?notice=invalid_login');
}

