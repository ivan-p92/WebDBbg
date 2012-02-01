<!--
Hier wordt de data die ingevuld is in het toevoeg formulier, en vervolgens in evenement.php nog een keer gekeurd is, verstuurd naar de database
webdb1235, data_verstuur.php
-->

<?php
try{
//er worden twee DateTime objecten aangemaakt, deze kunnen makkelijk in de database worden geïmplementeerd, en maken de code leesbaarder
$begindatum = new DateTime($_SESSION["tijdelijke_evenementwaardes"]["jaar1"]."-".$_SESSION["tijdelijke_evenementwaardes"]["maand1"]."-".
					$_SESSION["tijdelijke_evenementwaardes"]["datum1"]." ".$_SESSION["tijdelijke_evenementwaardes"]["begintijd"].":"."00");
					
$einddatum = new DateTime($_SESSION["tijdelijke_evenementwaardes"]["jaar2"]."-".$_SESSION["tijdelijke_evenementwaardes"]["maand2"]."-".
					$_SESSION["tijdelijke_evenementwaardes"]["datum2"]." ".$_SESSION["tijdelijke_evenementwaardes"]["eindtijd"].":"."00");
					

//maak connectie met de database, funtie daarvoor staat in functions.php					
$database = Functions::getDB();
    
	//sql query die het nieuwe row toevoegd in de events tabel in MySQL
	$sql = 'INSERT INTO events (id, title, description, start_date, end_date, create_id, create_date, location) 
		VALUES (NULL, :title, :description, :start_date, :end_date, :create_id, NOW(), :location)';
	
	//bereid de query voor
	$stmt=$database->prepare($sql);
	
	//voeg de parameters toe die in de array $_SESSION["tijdelijke_evenemetwaardes"] zitten
    $stmt->bindParam(':title', $_SESSION["tijdelijke_evenementwaardes"]["titel"], PDO::PARAM_STR);
	$stmt->bindParam(':description', $_SESSION["tijdelijke_evenementwaardes"]["omschrijving"], PDO::PARAM_STR);
	$stmt->bindParam(':start_date', $begindatum->format('Y:m:d H:i:s'), PDO::PARAM_STR);
	$stmt->bindParam(':end_date', $einddatum->format('Y:m:d H:i:s'), PDO::PARAM_STR);
	$stmt->bindParam(':create_id', $_SESSION["userid"], PDO::PARAM_STR);
	$stmt->bindParam(':location', $_SESSION["tijdelijke_evenementwaardes"]["locatie"], PDO::PARAM_STR);
	
	//voer de query uit, voeg evenement toe aan database
	$stmt->execute();
	
	//vraag het id van het toegevoegde evenement op
	$event_id=$database->lastInsertId();
	
	//sql query die aan de koppel tabel een connectie tussen evnementen en groepen toevoegt
	$sql='INSERT INTO events_groups (event_id, group_id) VALUES (:event_id, (SELECT id FROM groups WHERE `group`=:group))';
	
	//bereid de query voor
	$stmt=$database->prepare($sql);
	
	//voor elke categroie waarin de groep valt, voeg zo een connectie toe
	foreach($_SESSION["tijdelijke_evenementwaardes"]["categorie"] as $groep)
	{
		$stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
		$stmt->bindParam(':group', $groep, PDO::PARAM_STR);
		
		$stmt->execute();
	}
	
	//leeg de array met de tijdelijke evenementwaardes, de waardes zitten immers nu in de database
	unset($_SESSION["tijdelijke_evenementwaardes"]);
	
	//link door naar de homepage
	echo'<meta http-equiv="refresh" content="0; url=http://websec.science.uva.nl/webdb1235/index.php" />';
}

//als er een fout is, deze melding
catch(Exception $e){
echo'Er was een fout bij het versturen van de data.'.$e;
}

?>