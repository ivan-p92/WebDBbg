<!--
Bestand: evenement.php
Datum: januari 2012
Groep: webdb1235

Dit bestand geeft een opgevraagd evenement weer in een tabel met eventueel
opties zoals het goed/afkeuren of toevoegen/aanpassen van een event.

Er wordt gekeken naar de rechten die de persoon heeft die de pagina probeert
te openen en naar de evenementen die opgevraagd worden. Op die manier worden
alleen juiste evenementen getoond; als iemand geen rechten heeft of evenementen
niet bestaan/al gekeurd zijn, dan zijn er meldingen.
-->

<?php
// dit eerste geval is als iemand een evenement wil goed of afkeuren
// de $_GET parameter 'k' is G om goed te keuren, of A om af te keuren
// met Functions::auth wordt gekeken of de persoon genoeg rechten heeft om evenementen
// te keuren. Ook wordt gekeken of 'id' en 'k' wel ingesteld zijn
if(isset($_GET["semipage"]) && $_GET["semipage"]=="keuren" && Functions::auth("approve_event") && isset($_GET["id"]) && isset($_GET["k"]))
{
	// als aan de eerste voorwaarden voldaan is wordt verbinding gemaakt met de database
	$database = Functions::getDB();
	
	// Deze query is om te kijken of het via 'id' opgevraagde evenement nog ongekeurd is
	$sql = 'SELECT status FROM events_status WHERE id=:id';
	try
	{
		// de query wordt uitgevoerd
		$stmt = $database->prepare($sql);
		$stmt->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
		$stmt->execute();
		$info = $stmt->fetch();
	}
	catch(Exception $e) 
	{
		// als er een fout is, dan komt dat in principe doordat het evenement niet bestaat
		echo '<h1>Fout!</h1> <p>Het door u opgevraagde evenement bestaat niet!</p>';
	}
	
	// als 'k' op 'G' ingesteld is, en het evenement nog niet gekeurd is, dan zal het 
	// goedgekeurd worden
	if($_GET['k'] == "G" && $info["status"] == "unapproved")
	{
		// deze query voegt id en datum-tijd toe van goedkeuring
		// ook wordt het evenement publiek
		$sql = 'UPDATE events 
				SET approve_id=:uid, approve_date=NOW(), public=1 
				WHERE id=:eid';

		$stmt = $database->prepare($sql);

		// userid wordt uit $_SESSION gehaald, id van het evenement uit $_GET
		$stmt->bindParam(":uid", $_SESSION['userid'], PDO::PARAM_INT);
		$stmt->bindParam(":eid", $_GET['id'], PDO::PARAM_INT);

		$stmt->execute();

		// om te kijken of er daadwerkelijk een wijziging heeft plaatsgevonden
		// rowCount wordt niet gebruikt, omdat dit soms 0 kan terugsturen, terwijl er
		// wel row(s) zijn veranderd. Code 00000 betekent dat alles goed gaat
		$err = $stmt->errorCode();
		if($err == 00000)
			echo '<h1>Evenement goedgekeurd!</h1> <p>Het evenement is succesvol goedgekeurd!</p>';
		else // als er een fout is wordt een melding gegeven
			echo $err.'<h1>Fout!</h1> <p>Een fout is opgetreden. Dit evenement is mogelijk niet goedgekeurd.</p>';
	}
	// als 'k' op 'A' is ingesteld, zal het evenement goedgekeurd worden
	// verder is de procedure net als hierboven, alleen wordt public op '0' gezet
	elseif($_GET['k'] == "A" && $info["status"] == "unapproved")
	{
		$database=Functions::getDB();

		$sql = 'UPDATE events 
				SET approve_id=:uid, approve_date=NOW(), public=0 
				WHERE id=:eid';

		$stmt = $database->prepare($sql);

		$stmt->bindParam(":uid", $_SESSION['userid'], PDO::PARAM_INT);
		$stmt->bindParam(":eid", $_GET['id'], PDO::PARAM_INT);

		$stmt->execute();

		$err = $stmt->errorCode();
		if($err == 00000)
			echo '<h1>Evenement afgekeurd!</h1> <p>Het evenement is succesvol afgekeurd!</p>';
		else
			echo $err.'<h1>Fout!</h1> <p>Een fout is opgetreden. Dit evenement is mogelijk niet afgekeurd.</p>';
	}
	// in het laatste geval is het evenement al gekeurd (dus $info["status"] is approved of declined
	else
	{
		echo '<h1>Fout!</h1> <p>Het evenement is reeds gekeurd!</p>';
	}
}

// in dit geval komt de bezoeker van de toevoeg_evenement pagina en zitten er dus gegevens in $_POST
// als die er niet zijn volgt de algemene foutmelding (onderaan dit document)
// ook hier wordt de gebruiker geauthenticeerd
elseif(isset($_GET["semipage"]) && $_GET["semipage"]=="toevoeg_evenement" && Functions::auth("submit_event") && !empty($_POST))
{
	$begindatumtijd = '"'.$_POST["jaar1"]."-".$_POST["maand1"]."-".$_POST["datum1"]." ".$_POST["begintijd"].":"."00".'"';					
	$einddatumtijd = '"'.$_POST["jaar2"]."-".$_POST["maand2"]."-".$_POST["datum2"]." ".$_POST["eindtijd"].":"."00".'"';
		
	// sql wordt gebruikt bij het berekenen van het verschil tussen de twee datums
	$database = Functions::getDB();
	$sql = "SELECT TIMESTAMPDIFF(MINUTE,:begin,:eind) AS diff;";
	$stmt = $database->prepare($sql);
	$stmt->bindParam(":begin", $begindatumtijd);
	$stmt->bindParam(":eind", $einddatumtijd);
	$stmt->execute();
	$result = $stmt->fetch();
	$diff = $result["diff"];
	
	// strings voor de eventuele foutmelding
	$not_titel = 'Geef een titel op voor het evenement!\n';
	$not_omschrijving = 'Geef een omschrijving van het evenement!\n';
	$not_locatie = 'Geef een locatie op voor het evenement!\n';
	$not_vinkje = 'Vink minstens één categorie aan!\n';
	$not_begindatum = 'De begindatum is geen valide datum!\n';
	$not_einddatum = 'De einddatum is geen valide datum!\n';
	$not_validdiff = 'De einddatum en tijd moet ná de begindatum zijn!';
	$message = "";

	if(empty($_POST["titel"])) $message = $message.$not_titel;
	if(empty($_POST["omschrijving"])) $message = $message.$not_omschrijving;
	if(empty($_POST["locatie"])) $message = $message.$not_locatie;
	if(!isset($_POST["categorie"])) $message = $message.$not_vinkje;
	if(!checkdate($_POST["maand1"], $_POST["datum1"], $_POST["jaar1"])) $message = $message.$not_begindatum;
	if(!checkdate($_POST["maand2"], $_POST["datum2"], $_POST["jaar2"])) $message = $message.$not_einddatum;
	if($diff < 0) $message = $message.$not_validdiff;	
	
	// als $message niet leeg is, dan is niet alles correct ingevuld en wordt
	// de melding gegeven en toevoeg_evenement herladen
	if($message != "") 
	{
		$_SESSION["tijdelijke_evenementwaardes"]=$_POST;
		echo' <script>alert(\''.$message.'\')</script>
		<meta http-equiv="refresh" content="0; url=http://websec.science.uva.nl/webdb1235/index.php?page=toevoeg_evenement" />
		';
	}
	// hie rzal de tabel getoond worden
	else
	{
		// hier wordt de tabel weergave gevormd met als inhoud de gegevens uit $_POST
		// bij titel, omschrijving en locatie wordt .out() (uit functions.php) gebruikt omdat de gegevens 
		// html code zouden kunnen bevatten.
		echo'
		<h1>Evenement</h1>

		<table id="evenement">
			<tbody>
			<tr>
				<td>Titel</td>
				<td class="rechts">'.out($_POST["titel"]).'</td>
			</tr>
			<tr>
				<td>Omschrijving</td>
				<td class="rechts">'.out($_POST["omschrijving"]).'</td>
			</tr>
			<tr>
				<td>Locatie</td>
				<td>'.out($_POST["locatie"]).'</td>
			</tr>
			<tr>
				<td>Begintijd</td>
				<td class="rechts">'.$_POST["datum1"]." ".$_POST["maand1"]." ".$_POST["jaar1"]." ".$_POST["begintijd"].'</td>
			</tr>
			<tr>
				<td>Eindtijd</td>
				<td class="rechts">'.$_POST["datum2"]." ".$_POST["maand2"]." ".$_POST["jaar2"]." ".$_POST["eindtijd"].'</td>
			</tr>
			<tr>
				<td rowspan="4">Categorie</td>
				';
				// afhankelijk van of een categorie aangekruist is, wordt een vinkje of een kruisje geladen
				if(in_array("klant", $_POST["categorie"]))
				{echo'<td class="rechts"><img src="afbeeldingen/icons/tick.png" alt="Goedgekeurd! " title="Goedgekeurd" /> Klant</td>';}
				else{echo'<td class="rechts"><img src="afbeeldingen/icons/cross.png" alt="Afgekeurd! " title="Afgekeurd" /> Klant</td>';}
			echo'
			</tr>
			<tr>
				';if(in_array("keuken", $_POST["categorie"]))
				{echo'<td class="rechts"><img src="afbeeldingen/icons/tick.png" alt="Goedgekeurd! " title="Goedgekeurd" /> Keuken</td>';}
				else{echo'<td class="rechts"><img src="afbeeldingen/icons/cross.png" alt="Afgekeurd! " title="Afgekeurd" /> Keuken</td>';}
			echo'
			</tr>
			<tr>
				';if(in_array("afwas", $_POST["categorie"]))
				{echo'<td class="rechts"><img src="afbeeldingen/icons/tick.png" alt="Goedgekeurd! " title="Goedgekeurd" /> Afwas</td>';}
				else{echo'<td class="rechts"><img src="afbeeldingen/icons/cross.png" alt="Afgekeurd! " title="Afgekeurd" /> Afwas</td>';}
			echo'
			</tr>
			<tr>
				';if(in_array("bar", $_POST["categorie"]))
				{echo'<td class="rechts"><img src="afbeeldingen/icons/tick.png" alt="Goedgekeurd! " title="Goedgekeurd" /> Barpersoneel</td>';}
				else{echo'<td class="rechts"><img src="afbeeldingen/icons/cross.png" alt="Afgekeurd! " title="Afgekeurd" /> Barpersoneel</td>';}
			echo'
			</tr>
			</tbody>
		</table>

		';
		// de variabelen uit POST worden aan het SESSION array toegevoegd, zodat bij het aanpassen
		// van het evenement (door op 'aanpassen' te klikken) de waardes al in het formulier gestopt worden
		$_SESSION["tijdelijke_evenementwaardes"]=$_POST;

		// dit zijn de twee knoppen: Aanpassen en Aanmaken
		echo'

		<a class="submit_button" href="http://websec.science.uva.nl/webdb1235/index.php?page=toevoeg_evenement" title="Aanpassen">
				<button class="button"><span class="right"><span class="inner">Aanpassen</span></span></button>
		</a>
		<a class="submit_button" href="http://websec.science.uva.nl/webdb1235/index.php?page=data_verstuur" 
					onclick="alert(\'Uw evenement wordt zo snel mogelijk gekeurd en in de agenda gezet\')" title="Aanmaken">
				<button class="button"><span class="right"><span class="inner">Maak evenement aan</span></span></button>
		</a>';
	}
		
}

// in dit geval is de gebruiker afkomstig van 'keuren' en wordt een tabel getoond
// met de opties om een knop goed of af te keuren
// ook hier is de pagina beveiligd
elseif(isset($_GET["semipage"]) && $_GET["semipage"]=="keuren" && Functions::auth("approve_event") && isset($_GET["id"]))
{
	// er wordt verbinding gemaakt met de database
	$database=Functions::getDB();

	// deze query haalt alle info op over het betreffende evenement (incl status) en ook de auteur ervan
	$sql = 'SELECT events_status.*, users.name FROM events_status INNER JOIN users ON users.id=events_status.create_id WHERE events_status.id=:id';
	
	// deze queries kijken of het evenement tot bepaalde categorieën hoort
	$sql_klant = 'SELECT * FROM `events_groups` WHERE event_id=:id AND group_id=1';
	$sql_keuken = 'SELECT * FROM `events_groups` WHERE event_id=:id AND group_id=2';
	$sql_afwas = 'SELECT * FROM `events_groups` WHERE event_id=:id AND group_id=3';	
	$sql_bar = 'SELECT * FROM `events_groups` WHERE event_id=:id AND group_id=4';
	
	// alle info behalve categorieën wordt opgehaald.
	// maar als het evenent niet zichtbaar mag zijn (al gekeurd), wordt de rest niet uitgevoerd
	$stmt = $database->prepare($sql);
	$stmt->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
	$stmt->execute();
	$info=$stmt->fetch();
	
	// dus alleen als het nog niet gekeurd is wordt de tabel weergegeven, anders volgt een melding
	if($info["status"] == "unapproved")
	{
	// dit bereidt de queries voor
	$stmt_klant = $database->prepare($sql_klant);
	$stmt_keuken = $database->prepare($sql_keuken);
	$stmt_afwas = $database->prepare($sql_afwas);
	$stmt_bar = $database->prepare($sql_bar);
	
	// nu wordt id overal gebind
	$stmt_klant->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
	$stmt_keuken->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
	$stmt_afwas->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
	$stmt_bar->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
	
	// de queries worden uitgevoerd
	$stmt_klant->execute();
	$stmt_keuken->execute();
	$stmt_afwas->execute();
	$stmt_bar->execute();
	
	// met rowCount wordt gekeken of de categorieën van toepassing zijn
	$klant = $stmt_klant->rowCount();
	$keuken = $stmt_keuken->rowCount();
	$afwas = $stmt_afwas->rowCount();
	$bar = $stmt_bar->rowCount();

	// de tabel wordt op de juiste manier gecreëerd en ingevuld
	echo'
	<h1>Evenement</h1>

	<table id="evenement">
		<tbody>
		<tr>
			<td>Titel</td>
			<td class="rechts">'.out($info["title"]).'</td>
		</tr>
		<tr>
			<td>Plaatsing</td>
			<td class="rechts">'."Op ".$info["create_date"]." door ".$info["name"].'</td>
		</tr>
		<tr>
			<td>Omschrijving</td>
			<td class="rechts">'.out($info["description"]).'.</td>
		</tr>
		<tr>
			<td>Locatie</td>
			<td>'.out($info["location"]).'</td>
		</tr>
		<tr>
			<td>Begintijd</td>
			<td class="rechts">'.$info["start_date"].'</td>
		</tr>
		<tr>
			<td>Eindtijd</td>
			<td class="rechts">'.$info["end_date"].'</td>
		</tr>
		<tr>
			<td rowspan="4">Categorie</td>
			';
			if($klant != 0)
			{echo'<td class="rechts"><img src="afbeeldingen/icons/tick.png" alt="Goedgekeurd! " title="Goedgekeurd" /> Klant</td>';}
			else{echo'<td class="rechts"><img src="afbeeldingen/icons/cross.png" alt="Afgekeurd! " title="Afgekeurd" /> Klant</td>';}
		echo'
		</tr>
		<tr>
			';if($keuken != 0)
			{echo'<td class="rechts"><img src="afbeeldingen/icons/tick.png" alt="Goedgekeurd! " title="Goedgekeurd" /> Keuken</td>';}
			else{echo'<td class="rechts"><img src="afbeeldingen/icons/cross.png" alt="Afgekeurd! " title="Afgekeurd" /> Keuken</td>';}
		echo'
		</tr>
		<tr>
			';if($afwas != 0)
			{echo'<td class="rechts"><img src="afbeeldingen/icons/tick.png" alt="Goedgekeurd! " title="Goedgekeurd" /> Afwas</td>';}
			else{echo'<td class="rechts"><img src="afbeeldingen/icons/cross.png" alt="Afgekeurd! " title="Afgekeurd" /> Afwas</td>';}
		echo'
		</tr>
		<tr>
			';if($bar != 0)
			{echo'<td class="rechts"><img src="afbeeldingen/icons/tick.png" alt="Goedgekeurd! " title="Goedgekeurd" /> Barpersoneel</td>';}
			else{echo'<td class="rechts"><img src="afbeeldingen/icons/cross.png" alt="Afgekeurd! " title="Afgekeurd" /> Barpersoneel</td>';}
		echo'
		</tr>
		</tbody>
	</table>';

	// deze knoppen zijn voor het goed of afkeuren
	// de parameter 'k' wordt meegegeven
	echo '
	<div id="event_buttons">
	<a class="submit_button" href="index.php?page=evenement&amp;id='.$_GET["id"].'&amp;k=G&amp;semipage=keuren" title="Goedkeuren">
		<button class="button"><span class="right"><span class="inner">Goedkeuren</span></span></button>
	</a>	
	<a class="submit_button" href="index.php?page=evenement&amp;id='.$_GET["id"].'&amp;k=A&amp;semipage=keuren" title="Afkeuren">
			<button class="button"><span class="right"><span class="inner">Afkeuren</span></span></button>
	</a>	
	</div>';
	}
	// in het laatste geval bestaat het evenement niet of is het al gekeurd
	else echo '<h1>Fout!</h1>Het door u opgegeven evenement kan niet gekeurd worden, omdat het niet bestaat of reeds gekeurd is!';
} 

// in dit geval komt de gebruiker van de agenda pagina
// dit is voor iedereen toegankelijk, maar er wordt wel gekeken of het evenement id
// valide is, of toegankelijk (je kunt immers zelf een ander id intypen in het adres)
elseif(isset($_GET["semipage"]) && $_GET["semipage"]=="agenda_week" && isset($_GET["id"]))
{
	// verbinding met database wordt aangemaakt
	$database=Functions::getDB();

	// de benodigde queries
	$sql = 'SELECT events_status.*, users.name FROM events_status INNER JOIN users ON users.id=events_status.create_id WHERE events_status.id=:id';
	$sql_klant = 'SELECT * FROM `events_groups` WHERE event_id=:id AND group_id=1';
	$sql_keuken = 'SELECT * FROM `events_groups` WHERE event_id=:id AND group_id=2';
	$sql_afwas = 'SELECT * FROM `events_groups` WHERE event_id=:id AND group_id=3';	
	$sql_bar = 'SELECT * FROM `events_groups` WHERE event_id=:id AND group_id=4';
		
	// alle info behalve categorieën wordt opgehaald.
	// maar als het evenent niet zichtbaar mag zijn, wordt de rest niet uitgevoerd
	$stmt = $database->prepare($sql);
	$stmt->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
	$stmt->execute();
	$info=$stmt->fetch();
	
	// dus tabel wordt alleen aangemaakt als het evenement te tonen is
	if($info["status"] == "approved")
	{
	// dit bereidt de andere queries voor
	$stmt_klant = $database->prepare($sql_klant);
	$stmt_keuken = $database->prepare($sql_keuken);
	$stmt_afwas = $database->prepare($sql_afwas);
	$stmt_bar = $database->prepare($sql_bar);
	
	// nu wordt id overal gebind
	$stmt_klant->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
	$stmt_keuken->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
	$stmt_afwas->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
	$stmt_bar->bindParam(":id", $_GET["id"], PDO::PARAM_INT);
	
	// de queries worden uitgevoerd
	$stmt_klant->execute();
	$stmt_keuken->execute();
	$stmt_afwas->execute();
	$stmt_bar->execute();
	
	// bij de categorieën moet alleen de rijen geteld worden
	$klant = $stmt_klant->rowCount();
	$keuken = $stmt_keuken->rowCount();
	$afwas = $stmt_afwas->rowCount();
	$bar = $stmt_bar->rowCount();

	// de tabel wordt aangemaakt
	echo'
	<h1>Evenement</h1>

	<table id="evenement">
		<tbody>
		<tr>
			<td>Titel</td>
			<td class="rechts">'.out($info["title"]).'</td>
		</tr>
		<tr>
			<td>Omschrijving</td>
			<td class="rechts">'.out($info["description"]).'.</td>
		</tr>
		<tr>
			<td>Locatie</td>
			<td>'.out($info["location"]).'</td>
		</tr>
		<tr>
			<td>Begintijd</td>
			<td class="rechts">'.$info["start_date"].'</td>
		</tr>
		<tr>
			<td>Eindtijd</td>
			<td class="rechts">'.$info["end_date"].'</td>
		</tr>
		<tr>
			<td rowspan="4">Categorie</td>
			';if($klant != 0)
			{echo'<td class="rechts"><img src="afbeeldingen/icons/tick.png" alt="Goedgekeurd! " title="Goedgekeurd" /> Klant</td>';}
			else{echo'<td class="rechts"><img src="afbeeldingen/icons/cross.png" alt="Afgekeurd! " title="Afgekeurd" /> Klant</td>';}
		echo'
		</tr>
		<tr>
			';if($keuken != 0)
			{echo'<td class="rechts"><img src="afbeeldingen/icons/tick.png" alt="Goedgekeurd! " title="Goedgekeurd" /> Keuken</td>';}
			else{echo'<td class="rechts"><img src="afbeeldingen/icons/cross.png" alt="Afgekeurd! " title="Afgekeurd" /> Keuken</td>';}
		echo'
		</tr>
		<tr>
			';if($afwas != 0)
			{echo'<td class="rechts"><img src="afbeeldingen/icons/tick.png" alt="Goedgekeurd! " title="Goedgekeurd" /> Afwas</td>';}
			else{echo'<td class="rechts"><img src="afbeeldingen/icons/cross.png" alt="Afgekeurd! " title="Afgekeurd" /> Afwas</td>';}
		echo'
		</tr>
		<tr>
			';if($bar != 0)
			{echo'<td class="rechts"><img src="afbeeldingen/icons/tick.png" alt="Goedgekeurd! " title="Goedgekeurd" /> Barpersoneel</td>';}
			else{echo'<td class="rechts"><img src="afbeeldingen/icons/cross.png" alt="Afgekeurd! " title="Afgekeurd" /> Barpersoneel</td>';}
		echo'
		</tr>
		</tbody>
	</table>
	';
	}
	// de foutmelding: het id bestaat niet of is niet approved
	else echo '<h1>Fout!</h1> <p>Het door u opgevraagde evenement bestaat niet of is op dit moment niet openbaar!</p>';
} 

// dit is de algemene foutmelding
else
{
	echo'
	<h1>Fout!</h1>
	<p>U hebt geen rechten om deze pagina te bekijken of benadert de pagina op de verkeerde manier. Controleer uw invoer of log in.</p>
	';
}

?>