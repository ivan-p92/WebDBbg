<?php
include('functions.php');

try
{
	if(!isset($_GET['q']) || empty($_GET['q']))
	{
		throw new Exception("");
	}
	
	$q = '%'.$_GET['q'].'%';
	
	$db = Functions::getDB();
	$stmt = $db->prepare("SELECT id, name FROM users WHERE name LIKE :name");
	$stmt->bindParam(':name', $q, PDO::PARAM_STR);
	
	$stmt->execute();
	
	$return = '<ul id="livesearch">';
	
	while($row = $stmt->fetch())
	{
		$return .= '<li>'.$row['name'].'</li>';
	}
	$return .= '</ul>';
	
	echo $return;
}
catch(Exception $e)
{
	echo '<ul id=\"livesearch\"><li class=\"noclick\">Geen resultaten</li></ul>';
}

?>