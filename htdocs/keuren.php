<h1 id="event_lijst_titel">Te keuren evenementen</h1>
<?php
  
	if(Functions::auth("approve_event"))
	{
		echo '<div id="event_lijst_container">';
       		echo '<ul class="event_lijst">';
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
				DATEDIFF(end_date, start_date) AS diff
				FROM events WHERE approve_id IS NULL ORDER BY start_date ASC LIMIT 20 OFFSET 0;";

		if($stmt = $mysqli->prepare($sql))
		{
			if(!$stmt->execute())
			{
				echo 'Het uitvoeren van de query is mislukt: '.$stmt->error.' in query: '.$sql;
			}
			else
			{
				//var_dump($stmt);
				//$stmt->bind_column($titel, $id, $locatie, $jaar, $begin_dag, $begin_maand, $eind_dag, $eind_maand, $begin_tijd, $eind_tijd, $diff);
				
				if($stmt->rowCount() == 0)
				{
					echo '<p>Er zijn geen aankomende evenementen.</p>';
				}
				else
				{	
				while($row = $stmt->fetch())
				{
					if(strlen($row['title']) > 50)
					{
						$row['title']= substr($row['title'], 0, 50).'...';
					}

					if(strlen($row['location']) > 25)
					{
						$row['location'] = substr($row['location'], 0, 25).'...';
					}

					if($row['diff'] == 0)
					{					
						echo '<li class="event">';
						echo '<p class="eendags_event">';
						echo '<span class="begin_datum">';
						echo '<span class="jaar">'.$row['jaar'].'</span>';
						echo '<span class="dd-mm">'.$row['begin_dag'].'<br />'.$arr[$row['begin_maand']].'</span>';
						echo '</span>';
						echo '</p>';
						
						echo '<div class="event_details">';
						echo '<p class="event_titel">';
						echo '<a class="event_link" href="index.php?page=evenement&amp;id='.$row['id'].'&amp;semipage=keuren">'.$row['title'].'</a>';
						echo '</p>';
						echo '<p class="begintijd">Begin: '.$row['begin_tijd'].'u. Eind: '.$row['eind_tijd'].'u. @'.$row['location'].'</p>';
						echo '</div>';
						echo '</li>';
					}
					else
					{
						echo '<li class="event">';
						echo '<p class="eendags_event">';
						echo '<span class="begin_datum">';
						echo '<span class="jaar">'.$row['jaar'].'</span>';
						echo '<span class="dd-mm">'.$row['begin_dag'].' '.$arr[$row['begin_maand']].'<br />'.$row['eind_dag'].' '.$arr[$row['eind_maand']].'</span>';
						echo '</span>';
						echo '</p>';

						echo '<div class="event_details">';
						echo '<p class="event_titel">';
						echo '<a class="event_link" href="index.php?page=evenement&amp;id='.$row['id'].'&amp;semipage=keuren">'.$row['title'].'</a>';
						echo '</p>';
						echo '<p class="begintijd">Begin: '.$row['begin_tijd'].'u. Eind: '.$row['eind_tijd'].'u. @'.$row['location'].'</p>';
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
		</ul>
	</div>
}
else
{
	echo '<p>Log in om evenementen te kunnen keuren!</p>'
}
?>
