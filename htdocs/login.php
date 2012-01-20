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
$sql = "SELECT id FROM users WHERE email = 'freek.boutkan@gmail.com' AND password = '6c56b463e8057d3ea083d783478701ebce00a0de';";
$db = Functions::getDB();
$stmt = $db->prepare($sql);

//$stmt = $db->prepare("SELECT id FROM users WHERE email = 'freek.boutkan@gmail.com' AND password = '6c56b463e8057d3ea083d783478701ebce00a0de';");
//$pwd = Functions::hashPass($_POST['pwd']);
//$stmt->bind_param('ss', $_POST['naam'], $pwd);
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
	$stmt->close();
	header('Location: index.php?notice=invalid_login');
}

