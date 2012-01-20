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
$pwd = Functions::hashPass($_POST['pwd']);
$email = $_POST['naam'];


$db = Functions::getDB();
$stmt = $db->prepare($sql);



//$stmt->bindValue(':email', $email, PDO::PARAM_STR);
//$stmt->bindValue(':pass', $pwd, PDO::PARAM_STR);

$stmt->execute();


if($stmt->rowCount() == 1)
{
	$row = $stmt->fetch();	
	$_SESSION['userid'] = $row['id'];
}
else
{
	var_dump($stmt);
	die();
	header('Location: index.php?notice=invalid_login');
}

