

<!-- div#weeklijst container bevat de lijst van de evenementen 
     De hoofdstructuur ervan is een unordered list -->
<div id="event_lijst_container">
	<h1 id="event_lijst_titel">Aankomende evenementen</h1>
	<ul class="event_lijst">
		
		<?php
	
	$arr = array("bla", "JAN", "FEB", "MAA", "APR", "MEI", "JUN", "JUL", "AUG", "SEP", "OKT", "NOV", "DEC");
	
    $mysqli = new mysqli('localhost', 'webdb1235', 'sadru2ew', 'webdb1235');
    if(mysqli_connect_errno())
    {
        trigger_error('Fout bij verbinding: '.$mysqli->error);
    }

    $sql = "SELECT title, id, location,
			YEAR(start_date) AS jaar,
			DAYOFMONTH(start_date) AS begin_dag,
			MONTH(start_date) AS begin_maand,
			DAYOFMONTH(end_date) AS eind_dag,
			MONTH(end_date) AS eind_maand,
			TIME_FORMAT(TIME(start_date), '%H:%i') AS begin_tijd,
			TIME_FORMAT(TIME(end_date), '%H:%i') AS eind_tijd,
			DATEDIFF(end_date, start_date) AS diff
			FROM events WHERE public='1' AND end_date >= NOW() ORDER BY start_date ASC LIMIT  OFFSET 0;";

    if($stmt = $mysqli->prepare($sql))
    {
		if(!$stmt->execute())
		{
			echo 'Het uitvoeren van de query is mislukt: '.$stmt->error.' in query: '.$sql;
		}
		else
		{
			$stmt->bind_result($titel, $id, $locatie, $jaar, $begin_dag, $begin_maand, $eind_dag, $eind_maand, $begin_tijd, $eind_tijd, $diff);
			
			if($stmt->num_rows == 0)
			{
				echo '<p>Er zijn geen aankomende evenementen.</p>';
			}
			else
			{	
			while($stmt->fetch())
			{
				if(diff == 0)
				{
					echo '<li class="event">';
					echo '<p class="eendags_event">';
					echo '<span class="begin_datum">';
					echo '<span class="jaar">'.$jaar.'</span>';
					echo '<span class="dd-mm">'.$begin_dag.'<br />'.$arr[$begin_maand].'</span>';
					echo '</span>';
					echo '</p>';
					
					echo '<div class="event_details">';
					echo '<p class="event_titel">';
					echo '<a class="event_link" href="index.php?page=evenement&amp;id='.$id.'&amp;semipage=agenda_week">'.$titel.'</a>';
					echo '</p>';
					echo '<p class="begintijd">Begin: '.$begin_tijd.'u. Eind: '.$eind_tijd.'u. @'.$locatie.'</p>';
					echo '</div>';
					echo '</li';
				}
				else
				{
					echo '<li class="event">';
					echo '<p class="eendags_event">';
					echo '<span class="begin_datum">';
					echo '<span class="jaar">'.$jaar.'</span>';
					echo '<span class="dd-mm">'.$begin_dag.' '.$arr[$begin_maand].'<br />'.$eind_dag.' '.$arr[$eind_maand].'</span>';
					echo '</span>';
					echo '</p>';
					
					echo '<div class="event_details">';
					echo '<p class="event_titel">';
					echo '<a class="event_link" href="index.php?page=evenement&amp;id='.$id.'&amp;semipage=agenda_week">'.$titel.'</a>';
					echo '</p>';
					echo '<p class="begintijd">Begin: '.$begin_tijd.'u. Eind: '.$eind_tijd.'u. @'.$locatie.'</p>';
					echo '</div>';
					echo '</li';
				}
			}
		}
		}
    }

    else
    {
        echo 'Er zit een fout in de query: '.$mysqli->error;
    }

?>
	</ul>
</div>
