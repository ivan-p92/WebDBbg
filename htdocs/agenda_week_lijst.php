<!--
	agenda_week_lijst.php
	creëert de weeklijst weergave van de openbare agenda
-->

<!-- div#event_lijst_container bevat de lijst van de evenementen 
     De hoofdstructuur ervan is een unordered list -->
<div id="event_lijst_container">
	
	<!-- sort_table bevat de checkboxes voor de categorieën en ook
	textboxjes voor de week en jaar. Verder zitten er ook knoppen in
	om vooruit/achteruit en naar de huidige week te gaan -->
	
	<table id="sort_table" class="sort_table">
			<tr>
				<td id="sort_name">
					Toon evenementen uit de volgende categorieën:
				</td>
				<td>
					<label><input type="checkbox" id="klantbox" class="catbox" value="klant" name="categorie[]" onclick="initEvents();" />Klant</label>
				</td>
				<td>
					<label><input type="checkbox" id="keukenbox" class="catbox" value="keuken" name="categorie[]" onclick="initEvents();" />Keuken</label>
				</td>
				<td>
					<label><input type="checkbox" id="afwasbox" class="catbox" value="afwas" name="categorie[]" onclick="initEvents();" />Afwassers</label>
				</td>
				<td>
					<label><input type="checkbox" id="barbox" class="catbox" value="bar" name="categorie[]" onclick="initEvents();" />Barpersoneel</label>
				</td>
				<td id="week">
					Week:
				</td>
				<td id="wkbox">
					<input type="text" id="week_box" name="week" value="" onkeyup="dateSubmitWithKey(event, true)" />
				</td>
				<td id="jaar">
					Jaar:
				</td>
				<td id="jaarbox">
					<input type="text" id="jaar_box" name="week" value="" onkeyup="dateSubmitWithKey(event, false)" />
				</td>
				<td id="browse_week">
					<span class="submit_button" onclick="browseWeek(false)"><button class="button"><span class="right"><span class="inner">&lt;</span></span></button></span>
					<span class="submit_button" onclick="backToNow()"><button class="button"><span class="right"><span class="inner">Deze week</span></span></button></span>
					<span class="submit_button" onclick="browseWeek(true)"><button class="button"><span class="right"><span class="inner">&gt;</span></span></button></span>
				</td>
				
			</tr>
		</table>

	
	<h1 id="event_lijst_titel">Aankomende evenementen</h1>
	
	<!-- Deze tekst wordt getoond (dmv javascript) wanneer er geen evenementen getoond worden -->
	<p id="no_events">Er zijn geen evenementen op dit moment of voor de opgegeven criteria!</p>
	
	
<?php // in dit stuk php worden alle evenementen uit de database gehaald en geformatteerd
	  // javascript functies bepalen uiteindelijk welke getoond worden en welke niet
	
	// dit array bevat de maanden van het jaar zoals ze in de lijst weergegeven worden
	$arr = array("bla", "JAN", "FEB", "MAA", "APR", "MEI", "JUN", "JUL", "AUG", "SEP", "OKT", "NOV", "DEC");
	
	// een verbinding met de database wordt aangemaakt
    $database = Functions::getDB();
    
	// de huidige week en jaar worden via sql opgevraagd
	$row = $database->query("SELECT WEEK(NOW(), 1) AS week, YEAR(NOW()) AS jr;")->fetch();
	
	// dit stuk javascript zorgt ervoor dat zodra de pagina geladen is, de cookie gecheckt of
	// ingesteld wordt. Het huidige jaar en week worden ook meegegeven (zie showEvents.js)
	echo '<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() {checkCookie(',$row["jr"].','.$row["week"].');}, false);</script>'; //initYear('.$row["jr"].'); setWeek('.$row["week"].');checkCookie(',$row["jr"].','.$row["week"].');
	
	// de hoofdstructuur van de agenda is een unordered list. Alle evenementen en evenement
	// omschrijvingen zijn list items
	echo '<ul class="event_lijst">'."\n\n";
	
	// deze monster query haalt alle evenementen op, zodat bij het bladeren door de weken heen
	// de pagina niet herladen hoeft te worden, gezien alles met javascript wordt afgehandeld
	// De query haalt de informatie van de evenementen op en voert gelijk al meerdere operaties
	// uit over de start en eind datums.
    $sql = "SELECT title, id, location, description, status
			YEAR(start_date) AS jaar,
			YEAR(end_date) AS jaar2,
			DAYOFMONTH(start_date) AS begin_dag,
			MONTH(start_date) AS begin_maand,
			DAYOFMONTH(end_date) AS eind_dag,
			MONTH(end_date) AS eind_maand,
			TIME_FORMAT(TIME(start_date), '%H:%i') AS begin_tijd,
			TIME_FORMAT(TIME(end_date), '%H:%i') AS eind_tijd,
			DATEDIFF(end_date, start_date) AS diff,
			WEEK(start_date, 1) AS wkstart,
			WEEK(end_date, 1) AS wkend
			FROM events_status WHERE status='approved' ORDER BY start_date ASC;";

	// deze query haalt de bij de evenementen horende categorieën op uit de koppeltabel events_groups
	$sql2 = "SELECT events_groups.event_id, groups.`group` 
			 FROM `events_groups` 
			 JOIN groups ON groups.id=events_groups.group_id;";
	
	// de categorieën query wordt voorbereid en uitgevoerd
	$stmt2 = $database->prepare($sql2);	
	$stmt2->execute();	
	
	// koppel_array wordt een tweedimensionaal array met als eerste dimensie
	// de verschillende groepen als array en per 'groep array' de bijbehorende id's
	// van de juiste evenementen
	$koppel_array = array();
	
	// nu wordt koppel_array gevuld met de groepen en de bijbehorende id's
	while($var=$stmt2->fetch())
	{
		if(isset($koppel_array[$var["group"]]))
		{
			$koppel_array[$var["group"]][] = $var["event_id"];
		}
		else
		{
			$koppel_array[$var["group"]] = array($var["event_id"]);
		}
	}
	
	// nu wordt het ophalen van de evenementen uitgevoerd
    if($stmt = $database->prepare($sql))
    {
		if(!$stmt->execute())
		{
			echo 'Het uitvoeren van de query is mislukt: '.$stmt->error.' in query: '.$sql;
		}
		else
		{
			
			if($stmt->rowCount() > 0)
			{
			// elke keer dat deze lus doorlopen wordt, wordt er een nieuw evenement toegevoegd
			// aan de pagina
			while($row = $stmt->fetch())
			{	
				// eerst wordt de omschrijving van het evenement in een li gestopt
				// het krijgt als id 'desc_id' mee waarbij 'id' de id is van het evenement
				$description = $row['description'];
				$desc_id = 'desc_'.$row['id'];
				echo '<li class="event_omschrijving" id="'.$desc_id.'" style="display: none;">'.out($description).'</li>';
				
				// dit is het begin van de list item van het evenement zelf
				// de juiste javascript acties worden samengesteld
				echo '<li onmouseover="showDetails(this,\''.$desc_id.'\')" onmouseout="fixOMO(this,\''.$desc_id.'\', event)" onclick="goToEventA('.$row["id"].')" class="event';
				
				// nu krijgt het evenement de groepen waarin het zit mee als class
				// aan de classnaam wordt 'id_' toegevoegd
				foreach($koppel_array as $group => $array)
				{
					if(in_array($row['id'], $array))
					{
						echo " id_".$group;
					}	
				}
				
				// in het volgende stuk wordt worden de juiste jaar/week klassen meegegeven
				// voor het sorteren op jaar/week
				// elke jaar/week klasse bestaat uit 'd'+jaar+week en elk evenement krijgt voor
				// elke week waarin het plaatsvindt een jaar/week klasse mee
				// dus een evenement dat in week 4 en 5 van 2012 plaatsvindt krijgt de volgende
				// klassen mee: d20124 en d20125
				
				// dit eerste geval is voor een evenement dat in één jaar plaatsvindt
				if($row['jaar'] == $row['jaar2'])
				{
					// voor alle weken tussen wkstart en wkend wordt een class aangemaakt
					for($i = $row['wkstart']; $i <= $row['wkend']; $i++)
								echo " d".$row['jaar'].$i;
				}
				// in dit geval gaat het om een meerjaars evenement
				else
				{
					// de jaren worden doorlopen
					for($i = $row['jaar']; $i <= $row['jaar2']; $i++)
					{
						// nu wordt gekeken of het betreffende jaar het beginjaar, eindjaar
						// of een jaar ertussen in is
						switch($i)
						{
						// als het een beginjaar is, dan betreft het de weken vanaf de startweek
						// t/m week 53
						case $row['jaar']:
							for($j = $row['wkstart']; $j <=53; $j++)
								echo " d".$i.$j;
							break;
						// als het een eindjaar is, dan betreft het de weken vanaf 0 t/m de eindweek
						case $row['jaar2']:
							for($j = 0; $j <= $row['wkend']; $j++)
								echo " d".$i.$j;
							break;
						// als het een jaar tussenin is, dan betreft het de weken vanaf 0 t/m 53
						default:
							for($j = 0; $j <= 53; $j++)
								echo " d".$i.$j;
						}
					}
				}
				echo '">';
				echo '<p class="eendags_event">';
				echo '<span class="begin_datum">';
				// nu wordt de juiste html code aangemaakt. Het resultaat hangt af van meerdere dingen:
				// - of het een eendags of meerdaags evenement is
				// - als het een meerdaags evenement is, of het dan ook een meerjaars evenement is
				if($row['diff'] == 0) // eendags evenement
				{
					echo '<span class="jaar">'.$row['jaar'].'</span>';
					echo '<span class="dd-mm">'.$row['begin_dag'].'<br />'.$arr[$row['begin_maand']].'</span>';
				}
				else // meerdaags evenement
				{
					if($row["jaar"] == $row["jaar2"]) // evenement in hetzelfde jaar
					{
						echo '<span class="jaar">'.$row['jaar'].'</span>';
					}
					else // meerjaars evenement
					{
						$jr1 = substr($row["jaar"], 2, 2);
						$jr2 = substr($row["jaar2"], 2, 2);
						echo '<span class="jaar">\''.$jr1.' - \''.$jr2.'</span>';
					}
					echo '<span class="dd-mm">'.$row['begin_dag'].' '.$arr[$row['begin_maand']].'<br />'.$row['eind_dag'].' '.$arr[$row['eind_maand']].'</span>';
				}
				echo '</span>';
				echo '</p>';
				
				echo '<div class="event_details">';
				echo '<p class="event_titel">';
				// dit is het link gedeelte van de titel, linkt door naar de detailpagina
				echo '<a class="event_link" href="index.php?page=evenement&amp;id='.$row['id'].'&amp;semipage=agenda_week">'.out($row['title']).'</a>';
				echo '</p>';
				echo '<p class="begintijd">Begin: '.$row['begin_tijd'].'u. Eind: '.$row['eind_tijd'].'u. @'.out($row['location']).'</p>';
				echo '</div>';
				echo "</li>\n\n";
			}
		}
		}
    }

    else
    {
        echo 'Er zit een fout in de query: '.$database->error;
    }

?>
	</ul>
</div>
