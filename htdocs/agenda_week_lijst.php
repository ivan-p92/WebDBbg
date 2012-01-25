

<!-- div#weeklijst container bevat de lijst van de evenementen 
     De hoofdstructuur ervan is een unordered list -->
<div id="event_lijst_container">
	<h1 id="event_lijst_titel">Aankomende evenementen</h1>
	
	<form id="sorteer_events" action="http://websec.science.uva.nl/webdb1235/index.php?page=agenda_week_lijst" method="post">
	<label><input type="checkbox" value="klant" name="categorie[]" checked="checked" />Klant</label>
	<label><input type="checkbox" value="keuken" name="categorie[]" checked="checked" />Keuken</label>
	<label><input type="checkbox" value="afwas" name="categorie[]" checked="checked" />Afwassers</label>
	<label><input type="checkbox" value="bar" name="categorie[]" checked="checked" />Barpersoneel</label>
	<label class="submit_button">
	<button type="submit" class="button" id="event_aanmaken">
		<span class="right">
		<span class="inner">Herladen</span></span>
	</button></label>
	</form>
	<ul class="event_lijst">
<?php
	
	$arr = array("bla", "JAN", "FEB", "MAA", "APR", "MEI", "JUN", "JUL", "AUG", "SEP", "OKT", "NOV", "DEC");
	
    $mysqli = Functions::getDB(); /*new mysqli('localhost', 'webdb1235', 'sadru2ew', 'webdb1235');*/
    
    $sql = "SELECT title, id, location,
			YEAR(start_date) AS jaar,
			DAYOFMONTH(start_date) AS begin_dag,
			MONTH(start_date) AS begin_maand,
			DAYOFMONTH(end_date) AS eind_dag,
			MONTH(end_date) AS eind_maand,
			TIME_FORMAT(TIME(start_date), '%H:%i') AS begin_tijd,
			TIME_FORMAT(TIME(end_date), '%H:%i') AS eind_tijd,
			DATEDIFF(end_date, start_date) AS diff,
			WEEK(start_date) AS wkstart,
			WEEK(end_date) AS wkend
			FROM events WHERE public='1' ORDER BY start_date ASC;"; //AND end_date >= NOW()

	$sql2 = "SELECT events_groups.event_id, groups.`group` 
			 FROM `events_groups` 
			 JOIN groups ON groups.id=events_groups.group_id;";
	
	$stmt2 = $mysqli->prepare($sql2);
	
	$stmt2->execute();
	
	$koppel_array = array();
	
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
	
    if($stmt = $mysqli->prepare($sql))
    {
		if(!$stmt->execute())
		{
			echo 'Het uitvoeren van de query is mislukt: '.$stmt->error.' in query: '.$sql;
		}
		else
		{
					
			if($stmt->rowCount() == 0)
			{
				echo '<p>Er zijn geen aankomende evenementen.</p>';
			}
			else
			{	
			while($row = $stmt->fetch())
			{
				if($row['diff'] == 0)
				{					
					echo '<li class="event';
						foreach($koppel_array as $group => $array)
						{
							if(in_array($row['id'], $array))
							{
								echo " identifier_".$group;
							}	
						}
					echo '">';
					echo '<p class="eendags_event">';
					echo '<span class="begin_datum">';
					echo '<span class="jaar">'.$row['jaar'].'</span>';
					echo '<span class="dd-mm">'.$row['begin_dag'].'<br />'.$arr[$row['begin_maand']].'</span>';
					echo '</span>';
					echo '</p>';
					
					echo '<div class="event_details">';
					echo '<p class="event_titel">';
					echo '<a class="event_link" href="index.php?page=evenement&amp;id='.$row['id'].'&amp;semipage=agenda_week">'.out($row['title']).'</a>';
					echo '</p>';
					echo '<p class="begintijd">Begin: '.$row['begin_tijd'].'u. Eind: '.$row['eind_tijd'].'u. @'.out($row['location']).'</p>';
					echo '</div>';
					echo '</li>';
				}
				else
				{
					echo '<li class="event'; 
					
					foreach($koppel_array as $group => $array)
						{
							if(in_array($row['id'], $array))
							{
								echo " identifier_".$group;
							}	
						}
					echo'">';
                                        echo '<p class="eendags_event">';
                                        echo '<span class="begin_datum">';
                                        echo '<span class="jaar">'.$row['jaar'].'</span>';
                                        echo '<span class="dd-mm">'.$row['begin_dag'].' '.$arr[$row['begin_maand']].'<br />'.$row['eind_dag'].' '.$arr[$row['eind_maand']].'</span>';
                                        echo '</span>';
                                        echo '</p>';

                                        echo '<div class="event_details">';
                                        echo '<p class="event_titel">';
                                        echo '<a class="event_link" href="index.php?page=evenement&amp;id='.$row['id'].'&amp;semipage=agenda_week">'.out($row['title']).'</a>';
                                        echo '</p>';
                                        echo '<p class="begintijd">Begin: '.$row['begin_tijd'].'u. Eind: '.$row['eind_tijd'].'u. @'.out($row['location']).'</p>';
                                        echo '</div>';
					echo '</li>';
	
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
