

<!-- div#weeklijst container bevat de lijst van de evenementen 
     De hoofdstructuur ervan is een unordered list -->
<div id="event_lijst_container">
	<h1 id="event_lijst_titel">Aankomende evenementen</h1>
	
	<table id="sort_table">
			<tr>
				<td id="sort_name">
					Toon evenementen uit de volgende categorieën:
				</td>
				<td id="recht_checkbox">
					<form action="" method="post">
						<ul>
							<li><label><input type="checkbox" class="catbox" value="klant" name="categorie[]" checked="checked" onclick="initEvents();" />Klant</label></li>
							<li><label><input type="checkbox" class="catbox" value="keuken" name="categorie[]" checked="checked" onclick="initEvents();" />Keuken</label></li>
							<li><label><input type="checkbox" class="catbox" value="afwas" name="categorie[]" checked="checked" onclick="initEvents();" />Afwassers</label></li>
							<li><label><input type="checkbox" class="catbox" value="bar" name="categorie[]" checked="checked" onclick="initEvents();" />Barpersoneel</label></li>
						</ul>
					</form>
				</td>
				<td id="week">
					<span class="prev" onclick="browseWeek(false)"></span>
					<span id="set_week">Week:</span>
					<input type="text" id="week_box" name="week" value="" onkeyup="weekSubmitWithKey(event)" />
					<span class="next" onclick="browseWeek(true)"></span>
				</td>
			</tr>
		</table>
	
	
	
	<ul class="event_lijst">
<?php
	
	$arr = array("bla", "JAN", "FEB", "MAA", "APR", "MEI", "JUN", "JUL", "AUG", "SEP", "OKT", "NOV", "DEC");
	
    $database = Functions::getDB(); /*new mysqli('localhost', 'webdb1235', 'sadru2ew', 'webdb1235');*/
    
	$row = $database->query("SELECT WEEKOFYEAR(NOW()) AS week, YEAR(NOW()) AS jr;")->fetch();
	echo '<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function() { setWeek('.$row["week"].'); setYear('.$row["jr"].');}, false);</script>';	
	
    $sql = "SELECT title, id, location,
			YEAR(start_date) AS jaar,
			YEAR(end_date) AS jaar2,
			DAYOFMONTH(start_date) AS begin_dag,
			MONTH(start_date) AS begin_maand,
			DAYOFMONTH(end_date) AS eind_dag,
			MONTH(end_date) AS eind_maand,
			TIME_FORMAT(TIME(start_date), '%H:%i') AS begin_tijd,
			TIME_FORMAT(TIME(end_date), '%H:%i') AS eind_tijd,
			DATEDIFF(end_date, start_date) AS diff,
			WEEKOFYEAR(start_date) AS wkstart,
			WEEKOFYEAR(end_date) AS wkend
			FROM events WHERE public='1' ORDER BY start_date ASC;"; //AND end_date >= NOW()

	$sql2 = "SELECT events_groups.event_id, groups.`group` 
			 FROM `events_groups` 
			 JOIN groups ON groups.id=events_groups.group_id;";
	
	$stmt2 = $database->prepare($sql2);
	
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
	
    if($stmt = $database->prepare($sql))
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
				echo '<li onclick="goToEventA('.$row["id"].')" class="event';
					foreach($koppel_array as $group => $array)
					{
						if(in_array($row['id'], $array))
						{
							echo " id_".$group;
						}	
					}
				for($i = $row['wkstart']; $i <= $row['wkend']; $i++)
				{
					echo " w_".$i;
				}
				for($i = $row['jaar']; $i <= $row['jaar2']; $i++)
				{
					echo " y_".$i;
				}
				echo '">';
				echo '<p class="eendags_event">';
				echo '<span class="begin_datum">';
				if($row['diff'] == 0) // eendags evenement
				{
					echo '<span class="jaar">'.$row['jaar'].'</span>';
					echo '<span class="dd-mm">'.$row['begin_dag'].'<br />'.$arr[$row['begin_maand']].'</span>';
				}
				else // meerdaags evenement
				{
					echo '<span class="jaar">'.$row['jaar'].'</span>';
					echo '<span class="dd-mm">'.$row['begin_dag'].' '.$arr[$row['begin_maand']].'<br />'.$row['eind_dag'].' '.$arr[$row['eind_maand']].'</span>';
				}
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

    else
    {
        echo 'Er zit een fout in de query: '.$database->error;
    }

?>
	</ul>
</div>
