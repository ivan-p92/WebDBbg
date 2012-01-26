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
else 
{
	echo' <script>alert(\''."Er ging iets mis met het laden van het bericht.\nVermoedlijk is het al verwijderd".'\')</script>
	<meta http-equiv="refresh" content="0; url=http://websec.science.uva.nl/webdb1235/index.php?page=lijst_van_gebruikers" />';
}

echo'
<h1>'.out($row["subject"].'
<table id="message">
	<tbody>
		<tr>
			<td>
				Bericht geplaatst door
			</td>
			<td>
				'.out($row["name"]).'
			</td>
		</tr>
		<tr>
			<td>
				Email
			</td>
			<td>
				'.out(row["email"]).'
			</td>
		</tr>
		<tr>
			<td>
				Bericht
			</td>
			<td>
				'.out($row["message"]).'
			</td>
		</tr>
	</tbody>
</table>




?>