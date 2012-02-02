<h1 id="event_lijst_titel">Te keuren evenementen</h1>

<?php
// gebruiker moet de juiste rechten hebben om deze pagina te bekijken
if(Functions::auth("approve_event"))
{	// dat is het geval

	echo '<div id="event_lijst_container">';
	echo '<ul class="event_lijst">'."\n\n";
	
	// hulp array, eerste element is opvul zodat de key's en maandnummers overeen komen
	$arr = array("bla", "JAN", "FEB", "MAA", "APR", "MEI", "JUN", "JUL", "AUG", "SEP", "OKT", "NOV", "DEC");
	
	try
	{
	
		$mysqli = Functions::getDB(); // vraag om databae connectie
		
		// haal alle events op die nog niet gekeurd zijn
		
		// diff is het verschil in datum
		$sql = "SELECT
					title,
					id,
					location,
					status,
					YEAR(start_date) AS jaar,
					YEAR(end_date) AS jaar2,
					DAYOFMONTH(start_date) AS begin_dag,
					MONTH(start_date) AS begin_maand,
					DAYOFMONTH(end_date) AS eind_dag,
					MONTH(end_date) AS eind_maand,
					TIME_FORMAT(TIME(start_date), '%H:%i') AS begin_tijd,
					TIME_FORMAT(TIME(end_date), '%H:%i') AS eind_tijd,
					DATEDIFF(end_date, start_date) AS diff	
				FROM
					events_status
				WHERE
					status = 'unapproved'
				ORDER BY
					start_date ASC";

		$stmt = $mysqli->prepare($sql);		
		$stmt->execute();	
				
		if($stmt->rowCount() == 0) // geen resultaten, nette melding
		{
			echo '<p>Er zijn geen te keuren evenementen.</p>';
		}
		else
		{	
			// laat elke rij zijn als <li> element
			while($row = $stmt->fetch())
			{										
				echo '<li onclick="goToEventK('.$row["id"].')" class="event">';
				echo '<p class="event_datum">';
				echo '<span class="begin_datum">';
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
						echo '<span class="jaar">\''.$jr1.' -\''.$jr2.'</span>';
					}
					echo '<span class="dd-mm">'.$row['begin_dag'].' '.$arr[$row['begin_maand']].'<br />'.$row['eind_dag'].' '.$arr[$row['eind_maand']].'</span>';
				}
				echo '</span>';
				echo '</p>';
				
				echo '<div class="event_details">';
				echo '<p class="event_titel">';
				echo '<a class="event_link" href="index.php?page=evenement&amp;id='.$row['id'].'&amp;semipage=keuren">'.out($row['title']).'</a>';
				echo '</p>';
				echo '<p class="begintijd">Begin: '.$row['begin_tijd'].'u. Eind: '.$row['eind_tijd'].'u. @'.out($row['location']).'</p>';
				echo '</div>';
				echo "</li>\n\n";
			} // end while
		} // end else		
	
		echo '</ul></div>';
	}// end try
	catch(Exception $e)
	{
		// echo $e->getMessage();	//DEBUG only
		echo '<p class="error">Er ging wat mis, excuses</p>';
	}
}
else // niet ingelogd
{
	echo '<p>Log in om evenementen te kunnen keuren!</p>';
}

?>
