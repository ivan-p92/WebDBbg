<?php
if($_GET["semipage"]=="toevoeg_evenement" && Functions::auth("submit_event") && !empty($_POST))
{
echo'
<h1>Evenement</h1>

<table id="evenement">
	<tbody>
	<tr>
		<td>Titel</td>
		<td class="rechts">'.$_POST["titel"].'</td>
	</tr>
	<tr>
		<td>Omschrijving</td>
		<td class="rechts">'.$_POST["omschrijving"].'</td>
	</tr>
	<tr>
		<td>Locatie</td>
		<td>'.$_POST["locatie"].'</td>
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
		';if(in_array("klant", $_POST["categorie"]))
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
$_SESSION["tijdelijke_evenementwaardes"]=$_POST;

echo'

<a class="submit_button" href="http://websec.science.uva.nl/webdb1235/index.php?page=toevoeg_evenement" title="Aanpassen">
        <button class="button"><span class="right"><span class="inner">Aanpassen</span></span></button>
</a>
<a class="submit_button" href="http://websec.science.uva.nl/webdb1235/index.php?page=data_verstuur" 
			onclick="alert(\'Uw evenement wordt zo snel mogelijk gekeurd en in de agenda gezet\')" title="Aanmaken">
        <button class="button"><span class="right"><span class="inner">Maak evenement aan</span></span></button>
</a>

</div>';
}

elseif($_GET["semipage"]=="keuren" && Functions::auth("approve_event") && isset($_GET["id"]))
{
$database=Functions::getDB();

$sql = 'SELECT events.*, users.name FROM events INNER JOIN users ON users.id=events.create_id WHERE events.id=:id';

$stmt = $database->prepare($sql);

$stmt->bindParam(":id", $_GET["id"], PDO::PARAM_INT);

$stmt->execute();

$info=$stmt->fetch();

echo'
<h1>Evenement</h1>

<table id="evenement">
	<tbody>
	<tr>
		<td>Titel</td>
		<td class="rechts">'.$info["title"].'</td>
	</tr>
	<tr>
		<td>Plaatsing</td>
		<td class="rechts">'."Op ".$info["create_date"]." door ".$info["name"].'</td>
	</tr>
	<tr>
		<td>Omschrijving</td>
		<td class="rechts">'.$info["description"].'.</td>
	</tr>
	<tr>
		<td>Locatie</td>
		<td>'.$info["location"].'</td>
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
		<td class="rechts"><img src="afbeeldingen/icons/tick.png" alt="Goedgekeurd! " title="Goedgekeurd" /> Klant</td>
	</tr>
	<tr>
		<td class="rechts"><img src="afbeeldingen/icons/cross.png" alt="Afgekeurd! " title="Afgekeurd" /> Keuken</td>
	</tr>
	<tr>
		<td class="rechts"><img src="afbeeldingen/icons/tick.png" alt="Goedgekeurd! " title="Goedgekeurd" /> Afwassers</td>
	</tr>
	<tr>
		<td class="rechts"><img src="afbeeldingen/icons/cross.png" alt="Afgekeurd! " title="Afgekeurd" /> Barpersoneel</td>
	</tr>
	</tbody>
</table>

<div id="event_buttons">
<a class="submit_button" href="&amp;k=G" title="Goedkeuren">
	<button class="button"><span class="right"><span class="inner">Goedkeuren</span></span></button>
</a>	
<a class="submit_button" href="#" title="Afkeuren">
        <button class="button"><span class="right"><span class="inner">Afkeuren</span></span></button>
</a>	
</div>';
} 

elseif($_GET["semipage"]=="agenda_week" && isset($_GET["id"]))

{
$database=Functions::getDB();

$sql = 'SELECT events.*, users.name FROM events INNER JOIN users ON users.id=events.create_id WHERE events.id=:id';

$stmt = $database->prepare($sql);

$stmt->bindParam(":id", $_GET["id"], PDO::PARAM_INT);

$stmt->execute();

$info=$stmt->fetch();

echo'
<h1>Evenement</h1>

<table id="evenement">
	<tbody>
	<tr>
		<td>Titel</td>
		<td class="rechts">'.$info["title"].'</td>
	</tr>
	<tr>
		<td>Plaatsing</td>
		<td class="rechts">'."Op ".$info["create_date"]." door ".$info["name"].'</td>
	</tr>
	<tr>
		<td>Omschrijving</td>
		<td class="rechts">'.$info["description"].'.</td>
	</tr>
	<tr>
		<td>Locatie</td>
		<td>'.$info["location"].'</td>
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
		<td class="rechts"><img src="afbeeldingen/icons/tick.png" alt="Goedgekeurd! " title="Goedgekeurd" /> Klant</td>
	</tr>
	<tr>
		<td class="rechts"><img src="afbeeldingen/icons/cross.png" alt="Afgekeurd! " title="Afgekeurd" /> Keuken</td>
	</tr>
	<tr>
		<td class="rechts"><img src="afbeeldingen/icons/tick.png" alt="Goedgekeurd! " title="Goedgekeurd" /> Afwassers</td>
	</tr>
	<tr>
		<td class="rechts"><img src="afbeeldingen/icons/cross.png" alt="Afgekeurd! " title="Afgekeurd" /> Barpersoneel</td>
	</tr>
	</tbody>
</table>

';
} 
else
{
	echo'
	<h1>Fout!</h1>
	<p>U hebt geen rechten om deze pagina te bekijken of benadert de pagina op de verkeerde manier. Controleer uw invoer of log in.</p>
	';
}

?>