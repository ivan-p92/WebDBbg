<h1>Bericht</h1>

<?php

//leg connectie met database
$db = Functions::getDB();

//sql query om informatie op te vragen
$sql = "SELECT * FROM messages WHERE id = :id;";

//bereid de query voor
$stmt = $db->prepare($sql);

//zet de waardes van de parameters
$stmt->bindParam(':id', $_GET['messageid'], PDO::PARAM_INT);

//voer de query uit
$stmt->execute();

//als er iets wordt gevonden, zet het in de variabele row
if($stmt->rowCount() == 1)
{		
	$row = $stmt->fetch();
}

?>