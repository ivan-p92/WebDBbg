<?php
error_reporting(E_ALL); // E_ALL (alle foutmeldingen) in ontwikkelomgeving, 0 (geen) in  de live omgeving
ini_set('display_errors', true); // true in ontwikkelomgeving, false in  de live omgeving

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
var_dump($stmt);
die();

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
	header('Location: index.php?notice=invalid_login'.$_POST['naam'].'&'.Functions::hashPass($_POST['pwd']));
}

