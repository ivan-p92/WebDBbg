<?php
include('functions.php');

try
{
	if(!isset($_GET['q']) || empty($_GET['q']))
	{
		throw new Exception("");
	}
	
	$db = Functions::getDB();
	$stmt = $db->prepare("SELECT id, name FROM users WHERE name LIKE :name");
	$stmt->bindParam(':name', '%'.%_GET['q'].'%', PDO::PARAM_STR);
	
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

}

?>