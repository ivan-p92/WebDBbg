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
	$stmt = $db->prepare("SELECT id, name FROM users WHERE name LIKE :name LIMIT 10");
	$stmt->bindParam(':name', $q, PDO::PARAM_STR);
	
	$stmt->execute();
	
	$return = '<ul id="livesearch">';
	$i = 0;
	
	while($row = $stmt->fetch())
	{
		$row['name'] = str_ireplace($_GET['q'], '<span class="b">'.$_GET['q'].'</span>', $row['name']);
		$i++;
		$return .= '<li id="ls_li_'.$i.'" class="clickable">'.$row['name'].'</li>';
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
	echo "<ul id=\"livesearch\"><li>Geen resultaten</li></ul>";
}

?>