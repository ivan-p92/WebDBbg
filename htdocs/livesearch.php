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
	$i = 0;
	
	while($row = $stmt->fetch())
	{
		$i++;
		$return .= '<li class="clickable">'.$row['name'].'</li>';
	}
	
	if($i == 0)
	{
		throw new Exception();
	}
	
	$return .= '</ul>';
	
	echo $return;
}
catch(Exception $e)
{
	echo '<ul id=\"livesearch\"><li>Geen resultaten</li></ul>';
}

?>