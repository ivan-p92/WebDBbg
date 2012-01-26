<?php
if($_GET["del"]="ja")
{
	$db = Functions::getDB()
	$sql = "DELETE FROM messages WHERE id = :id;";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':id', $_GET['messageid'], PDO::PARAM_INT);
	$stmt->execute();
	
	echo'<p>Het bericht is succesvol verwijderd</p>';
	echo'<a class="submit_button" href="index.php?page=bericht&amp;semipage=lijst_van_gebruikers title="OK">
			<button class="button">
				<span class="right">
					<span class="inner">
						OK
					</span>
				</span>
			</button>
		</a>';
}
else
{
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
	<h1>'.out($row["subject"]).'</h1>
	<table id="events">
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
					'.out($row["email"]).'
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

	<a class="submit_button" href="index.php?page=bericht&amp;semipage=lijst_van_gebruikers&amp;messageid='.$_GET["messageid"].'&amp;k=G&amp;del=ja" title="Verwijderen">
		<button class="button">
			<span class="right">
				<span class="inner">
					Verwijder
				</span>
			</span>
		</button>
	</a>	
	<a class="submit_button" href="index.php?page=bericht&amp;semipage=lijst_van_gebruikers title="OK">
		<button class="button">
			<span class="right">
				<span class="inner">
					OK
				</span>
			</span>
		</button>
	</a>
	';
}
?>