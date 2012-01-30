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

	// deze functie wordt aangeroepen wanneer op de radiobuttons wordt geklikt
	function showhide ()
	{		
		// elke user uit de lijst heeft een aantal classes mee: standaard id_recht_all
		// verder voor elk recht nog een class: id_recht_<naamvhrecht>

		//zoek uit welke users (en dus classes) getoond moeten worden
		// selecteer de radioboxen en kijk of ie gechecked is of niet
		var inputs = document.getElementsByClassName("input_radio_search_users_rights");		
		var showClasses;
		
		for (var i = 0; i < inputs.length; i++)
		{
			if(inputs[i].checked) // deze radio is geselecteerd
			{
				showClasses = "id_recht_" + inputs[i].value;	// nu willen we deze users (en dus class) laten zien
			}
		}	
		
		var userBoxes = document.getElementsByClassName('id_recht_all');	// haal alle li's (users) op
		var numberVis = 0; // variabele die telt hoeveel users zichtbaar zijn bij huidige selectie
		
		for(var userBoxIndex = 0; userBoxIndex < userBoxes.length; userBoxIndex++)	// loop door alle li's /users
		{
			if(showClasses == 'id_recht_none')	// als er gebruikers zonder rechten getoond moeten worden
			{									// dan mag de user geen enkel ander recht hebben
				if(!hasClass(userBoxes[userBoxIndex], 'id_recht_aanmaken') && !hasClass(userBoxes[userBoxIndex], 'id_recht_keuren') && !hasClass(userBoxes[userBoxIndex], 'id_recht_admin'))
				{					
					userBoxes[userBoxIndex].style.display = "block";	// zet op zichtbaar
					numberVis++;	// update teller
				}
				else	// deze gebruiker heeft wel rechten
				{
					userBoxes[userBoxIndex].style.display = "none"; // dus moet niet getoond worden
				}
			}
			else	// gebruikers met een bepaald recht moeten getoond worden
			{			
				if(hasClass(userBoxes[userBoxIndex], showClasses)) // als de user/<li> de goede class heeft
				{
					userBoxes[userBoxIndex].style.display = "block";	// dan tonen we dit listitem
					numberVis++;	// update teller
				}
				else
				{
					userBoxes[userBoxIndex].style.display = "none"; // zoniet, dan onzichtbaar maken
				}
			}
		}
		
		// onderstaand stukje dient om een melding (on)zichtbaar te maken als er geen users getoond worden onder de selectiecriteria
		if(numberVis == 0)
		{
			document.getElementById("msg_no_users").style.display = "block"; // de melding moet zichtbaar zijn, want geen zichtbare users
		}
		else
		{
			document.getElementById("msg_no_users").style.display = "none"; // de melding moet onzichtbaar zijn, want wel zichtbare users
		}
	}
	
	// deze functie wordt aangeroepn wanneer er op een li geklikt wordt (zodat heel de box klikbaar is en niet enkel de link
	function showUser(id)
	{
		window.location.replace("index.php?page=admin&id=" + id + "&semipage=lijst_van_gebruikers");
	}
	
	// deze functie wordt aangeroepen als de pagina beschikbaar is (klaar met laden)
	function init()
	{
		showhide(); // laat goede users zien
	}
	
	document.addEventListener("DOMContentLoaded", init, false); // zorg dat init op het juiste moment wordt aangeroepen
</script>

<?php
if(Functions::auth("admin_rights"))	// user moet goede rechten hebben
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
		
	try
	{
		$mysqli = Functions::getDB(); // vraag om db connectie

		$sql = "SELECT
					id,
					name
				FROM
					users
				ORDER BY
					name ASC;";

		$stmt = $mysqli->prepare($sql);		
		$stmt->execute();

		
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
			echo '<span id="msg_no_users" style="display: none;">Er zijn geen gebruikers die aan dit selectiecriterium voldoen</span>';
		}
		echo '</div>';
	}
	catch(Exception $e)
	{
		// er ging wat mis, nette foutmelding
		// echo $e->getMessage(); //DEBUG ONLY
		echo '<p class="erro">Er is iets misgegaan, onze excuses</p>';
	}
	
	echo'<h1>Berichten</h1>';
	
	//haal een lijst met de berichten op
	
	//leg connectie met database
	try
	{
		$db = Functions::getDB();

		//sql query om informatie op te vragen
		$sqlBerichten = "SELECT id, name, subject FROM messages;";

		//bereid de query voor
		$stmtBerichten = $db->prepare($sqlBerichten);		
		$stmtBerichten->execute();
		
		$message_list="";	
	
		while($messages = $stmtBerichten->fetch())
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
			</div>';
		}	
		
	}
	catch(Exception $e)
	{
		// er ging wat mis, nette foutmelding
		// echo $e->getMessage(); //DEBUG ONLY
		echo '<p class="erro">Er is iets misgegaan, onze excuses</p>';
	}
}
else // geen juiste rechten
{
	echo '<h1>Verboden toegang!</h1> <p>U moet inloggen om deze pagina te kunnen bekijken!</p>';
}
?>	

