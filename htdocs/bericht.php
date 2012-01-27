<?php
if(Functions::auth("admin_rights") && isset$_GET["semipage"] && $_GET["semipage"]="lijst_van_gebruikers")
{
	//als het bericht verwijderd moet worden, wordt deze functie aangeroepen
	if(isset($_GET["del"]))
	{
		//leg connectie met database
		$db = Functions::getDB();
		//bereid query om bericht te verwijderen voor
		$sql = "DELETE FROM messages WHERE id = :id;";
		$stmt = $db->prepare($sql);
		//zet de variabele parameters
		$stmt->bindParam(':id', $_GET['messageid'], PDO::PARAM_INT);
		
		//voer de query uit
		$stmt->execute();
		
		//geef bericht aan de gebruiker, en een knop om terug naar de admin pagina te gaan
		echo'<p>Het bericht is succesvol verwijderd</p>';
		echo'<a class="submit_button" href="index.php?page=lijst_van_gebruikers" title="OK">
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
		//anders geef een fout melding en link door naar de admin pagina
		else 
		{
			echo' <script>alert(\''."Er ging iets mis met het laden van het bericht.\nVermoedlijk is het al verwijderd".'\')</script>
			<meta http-equiv="refresh" content="0; url=http://websec.science.uva.nl/webdb1235/index.php?page=lijst_van_gebruikers" />';
		}
		
		//Laat de informatie van het evenement zien
		echo'
		<h1>'.out($row["subject"]).'</h1>
		<table id="evenement">
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
		<a class="submit_button" href="index.php?page=lijst_van_gebruikers" title="OK">
			<button class="button">
				<span class="right">
					<span class="inner">
						OK
					</span>
				</span>
			</button>
		</a>
		';
	}//einde geval, laat informatie zien
}//einde geval, je hebt rechten en komt op de goed manier op de pagina
else
{
	//als de gebruiker niet de goede rechten heeft of op de verkeerde maniier de pagina benadert, laat volgend bericht zien
	echo '<h1>Verboden toegang</h1><p>U heeft niet de juiste rechten om deze pagina te bekijken of benadert hem op de verkeerde manier</p>';
}
?>