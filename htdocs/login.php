<?php
session_start();
//Pagina kan niet via de URL worden geladen
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	header('Location: index.php');
	die();
}

//Controle op volledigheid van informatie, anders wordt er teruggelinkt
//naar de header met een foutmelding (incomplete form)
if(!isset($_POST['naam']) || !isset($_POST['pwd']) || empty($_POST['naam']) || empty($_POST['pwd']))
{
	header('Location: index.php?notice=incomplete_form');
	die();
}
//SQL-query om gebruiker_id op te halen
//Dit ID staat in contact met alle gebruiker-gerelateerde informatie uit de database
//Zie eventueel phpMyAdmin Designer
$sql = "SELECT id FROM users WHERE email = :email AND password = :pass;";
$pwd = Functions::hashPass($_POST['pwd']);
$email = $_POST['naam'];


$db = Functions::getDB();
$stmt = $db->prepare($sql);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':pass', $pwd, PDO::PARAM_STR);
$stmt->execute();

//Als username en password een positieve match zijn,
//moet er maar 1 combinatie tussen die twee mogelijk zijn
if($stmt->rowCount() == 1)
{
	$row = $stmt->fetch();
	$_SESSION['userid'] = $row['id'];
	
	session_regenerate_id();
	
	
	header("Location: index.php?page=agenda_week");
	
}
//Als username en password niet samengaan, krijg je een foutmelding
else
{
	header('Location: index.php?notice=invalid_login');
}

