<script type="text/javascript">
	
	// BRON: http://www.openjs.com/scripts/dom/class_manipulation.php
	function hasClass(ele,cls) {
		return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
	}
	
	// deze is wel zelf geschreven
	// geeft true terug als element (ele) ten minste 1 van de classes uit de array met classes (clsArray) bevat.
	// anders false
	function hasClassArray(ele, clsArray)
	{
		for(var i = 0; i < clsArray.length; i++)
		{
			if(hasClass(ele, clsArray[i]))
			{
				return true;			// stop de functie, class is gevonden
			}
		}
		return false;	// class niet gevonden, dus return false
	}


	function showhide ()
	{		
		// zoek uit welke classes getoond moeten worden
		// selecteer elke checkbox en kijk of ze gechecked zijn of niet
		var inputs = document.getElementsByClassName("input_radio_search_users_rights");		
		var showClasses;
		
		for (var i = 0; i < inputs.length; i++)
		{
			if(inputs[i].checked)
			{
				showClasses = "id_recht_" + inputs[i].value;
			}
		}	
		
		var userBoxes = document.getElementsByClassName('id_recht_all');	// haal alle li's op
		var numberVis = 0;
		for(var userBoxIndex = 0; userBoxIndex < userBoxes.length; userBoxIndex++)	// loop door alle li's 
		{
			if(showClasses == 'id_recht_none')
			{
				if(!hasClass(userBoxes[userBoxIndex], 'id_recht_aanmaken') && !hasClass(userBoxes[userBoxIndex], 'id_recht_keuren') && !hasClass(userBoxes[userBoxIndex], 'id_recht_admin'))
				{
					console.log('hallo');
					userBoxes[userBoxIndex].style.visibility = "visible";
					numberVis++;
				}
				else
				{
					userBoxes[userBoxIndex].style.visibility = "hidden";
				}
			}
			else
			{			
				if(hasClass(userBoxes[userBoxIndex], showClasses))
				{
					userBoxes[userBoxIndex].style.visibility = "visible";
					numberVis++;
				}
				else
				{
					userBoxes[userBoxIndex].style.visibility = "hidden";
				}
			}
		}
		
		if(numberVis == 0)
		{
			document.getElementById("msg_no_users").style.display = "block";
		}
	}
	
	function showUser(id)
	{
		window.location.replace("index.php?page=admin&id=" + id + "&semipage=lijst_van_gebruikers");
	}
	
	function init()
	{
		showhide(3);
	}
	
	document.addEventListener("DOMContentLoaded", init, false);
</script>
<?php
if(Functions::auth("admin_rights"))
{
	echo'
	<div class="userlist">
		<span id="sresult">
		</span>
		<table id="sort_table">
			<tr>
				<td id="sort_name">
					Weergave
				</td>
				<td id="recht_checkbox">
						<ul>
							<li><label><input type="radio" class="input_radio_search_users_rights" name="rad" value="all" onclick="showhide();" checked="checked" />Iedereen</label></li>
							<li><label><input type="radio" class="input_radio_search_users_rights" name="rad" value="none" onclick="showhide();" />Geen rechten</label></li>
							<li><label><input type="radio" class="input_radio_search_users_rights" name="rad" value="aanmaken" onclick="showhide();" />Aanmaken</label></li>
							<li><label><input type="radio" class="input_radio_search_users_rights" name="rad" value="keuren" onclick="showhide();" />Keuren</label></li>
							<li><label><input type="radio" class="input_radio_search_users_rights" name="rad" value="admin" onclick="showhide();" />Admin</label></li>
						</ul>
				</td>
				<td id="zoek">
					<span id="zoek_text">Zoek:</span>
					<input type="text" id="zoek_box" name="zoek" />
					<span id="result"></span>
				</td>
			</tr>
		</table>
		
		<h1>Gebruikers</h1>
			<p>
				Klik op een gebruiker om gegevens van deze gebruiker te bekijken en zijn rechten aan te passen
			</p>
		';
		
			
		$mysqli = Functions::getDB();

		$sql = "SELECT id, name FROM users;";

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
					echo '<p>Er zijn geen gebruikers gevonden.</p>';
				}
				else
				{
					echo '<ul id="userlistlist">';
					while($row = $stmt->fetch())
					{
						$sql_recht = "SELECT permission_id FROM users_permissions WHERE user_id=:id";
						$stmt_recht = $mysqli->prepare($sql_recht);
						$stmt_recht->bindParam(":id",$row['id'],PDO::PARAM_INT);
						$stmt_recht->execute();						
						
						$classes = 'id_recht_all';
						
						while($recht = $stmt_recht->fetch())
						{
							switch($recht['permission_id'])
							{
								case 1: 
									$classes .= ' id_recht_aanmaken';
									break;
								case 2:
									$classes .= ' id_recht_keuren';
									break;
								case 3:
									$classes .= ' id_recht_admin';
									break;
							}
						}
						echo '<li onclick="showUser('.$row['id'].')" class="'.$classes.'">';
						echo '<a href="index.php?page=admin&amp;id='.$row['id'].'&amp;semipage=lijst_van_gebruikers">'.$row['name'].'</a>';
						echo '</li>';
					}
					echo '</ul>';
					echo '<span id="msg_no_users"  style="display: hidden;">Er zijn geen gebruikers die aan dit selectiecriterium voldoen</span>';
				}
			}
		}
		else
		{
			echo 'Er zit een fout in de query: '.$mysqli->error;
		}
	echo '</div>';
	
	echo'<h1>Berichten</h1>';
	
	//haal een lijst met de berichten op
	
	//leg connectie met database
	$db = Functions::getDB();

	//sql query om informatie op te vragen
	$sqll = "SELECT id, name, subject FROM messages;";

	//bereid de query voor
	$stmt3 = $db->prepare($sqll);

	$message_list="";
	
	if(!$stmt3->execute())
	{
		echo'Het uitvoeren van de query is mislukt';
	}
	else
	{
		while($messages = $stmt3->fetch())
		{
			$message_list .= '<li><a href="index.php?page=bericht&amp;semipage=lijst_van_gebruikers&amp;messageid='.out($messages['id']).'">'.out($messages['subject']).' ('.out($messages['name']).')</a></li>';
		} 
		if($message_list == "")
		{		
			echo '<div id="message_list">Er zijn op dit moment geen berichten</div>';			
		}
		else 
		{
			echo'<div id="message_list">
				<ul>
					'.$message_list.'
				</ul>
			</div>
			';
		}	
	}
}
else
{
	echo '<h1>Verboden toegang!</h1> <p>U moet inloggen om deze pagina te kunnen bekijken!</p>';
}
?>	

