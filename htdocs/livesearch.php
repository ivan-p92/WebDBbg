<?php
// deze pagina wordt via AJAX request aangeroepen

// functions zijn nodig
include('functions.php');

try
{
	if(!isset($_GET['q']) || empty($_GET['q']))
	{
		throw new Exception("");	// geen zoekstring, dus gooi exception
	}
	
	$q = '%'.$_GET['q'].'%'; // voeg % toe voor de LIKE
	
	$db = Functions::getDB(); // vraag connectie
	$stmt = $db->prepare("	SELECT
								id,
								name
							FROM
								users
							WHERE
								name LIKE :name
							LIMIT 10");
	$stmt->bindParam(':name', $q, PDO::PARAM_STR);	
	$stmt->execute();
	
	$return = '<ul id="livesearch">';
	$i = 0; // teller voor aantal resultaten
	
	while($row = $stmt->fetch())
	{
		$i++; //update teller
		// geef een li terug met 2 spans: <li><span class="ls_name"> <naam> </span><span class="ls_id"> <id> </span></li>
		$return .= '<li class="clickable"><span class="ls_name">'.out($row['name']).'</span><span class="ls_id">'.$row['id'].'</span></li>';
	}
	
	if($i == 0) // geen resultaten
	{
		throw new Exception();	// gooi exception
	}
	
	$return .= '</ul>';
	
	echo $return; // zend de lijst terug
}
catch(Exception $e) // er ging wat mis, stuur terug dat er geen resultaten zijn
{
	echo "<ul id=\"livesearch\"><li>Geen resultaten</li></ul>";
}

?>