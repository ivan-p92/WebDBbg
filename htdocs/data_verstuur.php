<?php
try{


$begindatum = new DateTime($_SESSION["tijdelijke_evenementwaardes"]["jaar1"]."-".$_SESSION["tijdelijke_evenementwaardes"]["maand1"]."-".
					$_SESSION["tijdelijke_evenementwaardes"]["datum1"]." ".$_SESSION["tijdelijke_evenementwaardes"]["begintijd"].":"."00");
					
$einddatum = new DateTime($_SESSION["tijdelijke_evenementwaardes"]["jaar2"]."-".$_SESSION["tijdelijke_evenementwaardes"]["maand2"]."-".
					$_SESSION["tijdelijke_evenementwaardes"]["datum2"]." ".$_SESSION["tijdelijke_evenementwaardes"]["eindtijd"].":"."00");
					

					
$database = Functions::getDB(); /*new mysqli('localhost', 'webdb1235', 'sadru2ew', 'webdb1235');*/
    
	$sql = 'INSERT INTO events (id, title, description, start_date, end_date, create_id, create_date, location) 
		VALUES (NULL, :title, :description, :start_date, :end_date, :create_id, NOW(), :location)';
	
	$stmt=$database->prepare($sql);
	
	
    $stmt->bindParam(':title', $_SESSION["tijdelijke_evenementwaardes"]["titel"], PDO::PARAM_STR);
	$stmt->bindParam(':description', $_SESSION["tijdelijke_evenementwaardes"]["omschrijving"], PDO::PARAM_STR);
	$stmt->bindParam(':start_date', $begindatum->format('Y:m:d H:i:s'), PDO::PARAM_STR);
	$stmt->bindParam(':end_date', $einddatum->format('Y:m:d H:i:s'), PDO::PARAM_STR);
	$stmt->bindParam(':create_id', $_SESSION["userid"], PDO::PARAM_STR);
	$stmt->bindParam(':location', $_SESSION["tijdelijke_evenementwaardes"]["locatie"], PDO::PARAM_STR);
	
	$stmt->execute();
	
	$event_id=$database->latInsertId();
	
	$sql2='INSERT INTO events_groups (event_id, group_id) VALUES (:event_id, (SELECT id FROM groups WHERE group=:group))';
	
	$stmt2=database->prepare(sql2);
	
	foreach($_SESSION["tijdelijke_evenementwaardes"]["categorie"] as $groep)
	{
		$stmt2->bindParam(':event_id', $event_id, PDO::PARAM_INT);
		$stmt2->bindParam(':group', $groep, PDO::PARAM_STR);
		
		$stmt2->execute();
	}
	
	echo'<meta http-equiv="refresh" content="0; url=http://websec.science.uva.nl/webdb1235/index.php" />';
}

catch(Exception $e){
echo'Er was een fout bij het versturen van de data.'.$e;
}

?>