<?php
if($_GET["semipage"]=="toevoeg_evenement")
{echo'
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
		<td class="rechts">'.$_POST["datum1"].":".$_POST["maand1"].":".$_POST["jaar1"]." ".$_POST["begintijd"].'</td>
	</tr>
	<tr>
		<td>Eindtijd</td>
		<td class="rechts">'.$_POST["datum2"].":".$_POST["maand2"].":".$_POST["jaar2"]." ".$_POST["eindtijd"].'</td>
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

<a class="submit_button" href="#" title="Aanpassen">
        <button class="button"><span class="right"><span class="inner">Aanpassen</span></span></button>
</a>
<a class="submit_button" href="#" title="Aanmaken">
        <button class="button"><span class="right"><span class="inner">Maak evenement aan</span></span></button>
</a>

</div>';
}
else if($_GET["semipage"]=="toevoeg_evenement")
{echo'
<h1>Evenement</h1>

<table id="evenement">
	<tbody>
	<tr>
		<td>Titel</td>
		<td class="rechts">Hier komt de titel</td>
	</tr>
	<tr>
		<td>Plaatsing</td>
		<td class="rechts">Datum van toevoegen en auteur</td>
	</tr>
	<tr>
		<td>Goedkeuring</td>
		<td class="rechts">Datum van goedkeuren en autorisator</td>
	</tr>
	<tr>
		<td>Omschrijving</td>
		<td class="rechts">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
			Mauris vel magna. Mauris risus nunc, tristique varius, gravida in, 
			lacinia vel, elit.Nam ornare, felis non faucibus molestie, 
			nulla augue adipiscing mauris, a nonummy diam ligula ut risus. 
			Praesent varius. Cum sociis natoque penatibus et magnis dis parturient montes, 
			nascetur ridiculus mus.</td>
	</tr>
	<tr>
		<td>Locatie</td>
		<td>Hier komt de locatie</td>
	</tr>
	<tr>
		<td>Begintijd</td>
		<td class="rechts">Hier komt de begintijd en datum</td>
	</tr>
	<tr>
		<td>Eindtijd</td>
		<td class="rechts">Hier de eindtijd en datum</td>
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
<a class="submit_button" href="#" title="Goedkeuren">
	<button class="button"><span class="right"><span class="inner">Goedkeuren</span></span></button>
</a>	
<a class="submit_button" href="#" title="Afkeuren">
        <button class="button"><span class="right"><span class="inner">Afkeuren</span></span></button>
</a>
<a class="submit_button" href="#" title="Aanpassen">
        <button class="button"><span class="right"><span class="inner">Aanpassen</span></span></button>
</a>

</div>';
}
?>