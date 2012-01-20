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
$sql = "SELECT id FROM users WHERE email = ':email' AND password = ':pass';";
$db = Functions::getDB();
$stmt = $db->prepare($sql);

$stmt->bindParam(':email', $_POST['naam']);
$stmt->bindParam(':pass', Functions::hashPass($_POST['pwd']));
$stmt->execute();
var_dump($stmt);
die();

if($stmt->rowCount() == 1)
{
	$row = $stmt->fetch();
	
	$_SESSION['userid'] = $row['id'];

}
else
{
	header('Location: index.php?notice=invalid_login');
}

