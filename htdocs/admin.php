<!--
Bestand: admin.php
Datum: januari 2012
Groep: webdb1235

Dit bestand laat een admin inzicht krijgen in de aangemaakte evenementen en
rechten van een gebruiker. Ook is het mogelijk om de rechten op deze pagina
aan te passen.
-->
<?php
//Admin-rechten zijn nodig om de pagina te bekijken en er moet een (geldige) userID in de URL aanwezig zijn.
//Als een van deze dingen ontbreekt, krijg je een foutmelding (vanaf regel 196)
if(Functions::auth("admin_rights") && isset($_GET['id']) && is_numeric($_GET['id']))
{
	try
	{	
		//database wordt geladen
		$mysqli = Functions::getDB();
		
		//query om de gebruikersnaam weer te geven op de pagina
		$sql = "SELECT name FROM users WHERE id=:user_id";
		$stmt = $mysqli->prepare($sql);
		$stmt->bindParam(":user_id",$_GET['id'],PDO::PARAM_INT);
		$stmt->execute();
		
		$row = $stmt->fetch();
		
		echo '<div class="admin">';
		//Als de gebruiker niet bestaat, is de lijst leeg		
		if($stmt->rowCount() == 0)
		{
			echo '<h1>Deze gebruiker bestaat niet</h1>
				<p>Keer terug naar de lijst van gebruikers en probeer opnieuw</p>';
		}		
		//Het formulier waarme de rechten worden aangepast maakt gebruik van de $_POST variabele
		//Als admin.php een $_POST variabele mee heeft gekregen, moeten de rechten dus worden aangepast
		elseif($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			//query om alle rechten te verwijderen
			$sql_delPermission = "DELETE FROM users_permissions WHERE user_id=:user_id";
			$stmt_delPermission = $mysqli->prepare($sql_delPermission);
			$stmt_delPermission->bindParam(":user_id",$_GET['id'],PDO::PARAM_INT);
			$stmt_delPermission->execute();
			
			//query om alle aangevinkte rechten toe te voegen
			$sql_addPermission = "INSERT into users_permissions (user_id, permission_id)
								  VALUES (:user_id,(SELECT id FROM permissions WHERE permission = :permission));";
			$stmt_addPermission = $mysqli->prepare($sql_addPermission);
			
			var_dump($_POST['admin_check']);
			
			foreach( $_POST['admin_check'] as $recht )
			{
				$stmt_addPermission->bindParam(':user_id',$_GET['id'],PDO::PARAM_INT);
				$stmt_addPermission->bindParam(':permission', $recht, PDO::PARAM_STR);
				$stmt_addPermission->execute();
			}
			
			//melding dat de rechten succesvol zijn aangepast
			echo '<h1>Succes!</h1>
				  <p>Rechten voor '.$row['name'].' aangepast.</p>';
		}//Als de pagina geen $_POST variabele mee heeft gekregen, wordt deze normaal geladen.
		else
		{	
			//query om de rechten van de gebruiker op te halen
			$sql_check = "SELECT permission_id FROM users_permissions WHERE user_id=:user_id;";
			$stmt_check = $mysqli->prepare($sql_check);
			$stmt_check->bindParam(":user_id",$_GET['id'],PDO::PARAM_INT);
			$stmt_check->execute();
				?>
			
			<!-- MOET DIT SCRIPT NOG IN EEN APARTE JAVASCRIPT-FILE? -->
			<script type="text/javascript">
			//functie om gebruikersrechten weer te geven in admin.php
			//Wanneer de gebruiker het recht heeft wordt de bij behorende checkbox aangevinkt.
			function check_rechten( id )
			{
				switch(id)
				{
				case 1:
					document.getElementById("submit_event").checked="checked";
					break;
				case 2:
					document.getElementById("approve_event").checked="checked";
					break;
				case 3:
					document.getElementById("admin_rights").checked="checked";
					break;
				default:
					document.write("Permission_id niet correct");
				}
			}
			
			function init()
			{
			<?php
				while($check = $stmt_check->fetch())
				{
					echo "check_rechten(".$check['permission_id'].");\n";
				}
			?>
			}
			
			document.addEventListener("DOMContentLoaded", init, false);
			</script>
			
			<?php
			//Weergave van de pagina
			echo'
			<h1>Admin pagina van '.$row['name'].'</h1>
			<p>U kunt hier zien welke evenementen door '.$row['name'].' aangemaakt/goedgekeurd/afgekeurd zijn.<br />
				Ook kunt u diens rechten hier aanpassen.
			</p>
			<p>De volgende evenementen zijn door '.$row['name'].' aangemaakt:</p>';
			
			//Tabel waarin de status van door de gebruiker aangemaakte evenementen wordt getoond
			//Dit is tevens ook inzichtelijk voor de gebruiker zelf op zijn of haar account pagina
			
			echo '<div class="user_events">
				<table id="user_events">
					<tbody>
						<tr>
							<th>Ongekeurde Evenementen</th>
							<th>Goedgekeurde Evenementen</th>
							<th>Afgekeurde Evenementen</th>
						</tr>
						<tr>
							<td class="admin_td">';
								//query om de ongekeurde evenementen op te halen
								$sql_ongekeurd = "SELECT title,id FROM events_status WHERE create_id=:user_id AND status='unapproved'";
								$stmt_ongekeurd = $mysqli->prepare($sql_ongekeurd);
								$stmt_ongekeurd->bindParam( ":user_id", $_GET['id'], PDO::PARAM_INT );
								$stmt_ongekeurd->execute();
								
								if($stmt_ongekeurd->rowCount() == 0) //Geen evenemten van dit type
								{
									echo '<p>Geen events</p>';
								}
								else //Een of meerder evenementen van dit type
								{
									echo '<p>';
									while($on = $stmt_ongekeurd->fetch())
									{
										echo '<a href="index.php?page=evenement&amp;id='.$on['id'].'&amp;semipage=keuren">'.out($on['title']).'</a><br />';
									}
									echo '</p>';
								}
							echo '</td>
							<td class="admin_td">';
								//query om de goedgekeurde evenementen op te halen
								$sql_goedgekeurd = "SELECT title,id FROM events_status WHERE create_id=:user_id AND status='approved'";
								$stmt_goedgekeurd = $mysqli->prepare($sql_goedgekeurd);
								$stmt_goedgekeurd->bindParam( ":user_id", $_GET['id'], PDO::PARAM_INT );
								$stmt_goedgekeurd->execute();
								
								if($stmt_goedgekeurd->rowCount() == 0) //Geen evenemten van dit type
								{
									echo '<p>Geen events</p>';
								}
								else //Een of meerder evenementen van dit type
								{
									echo '<p>';
									while($goed = $stmt_goedgekeurd->fetch())
									{
										echo '<a href="index.php?page=evenement&amp;id='.$goed['id'].'&amp;semipage=agenda_week">'.out($goed['title']).'</a><br />';
									}
									echo '</p>';
								}
							echo '</td>
							<td class="admin_td">';
								//query om de afgekeurde evenementen op te halen
								$sql_afgekeurd = "SELECT title,id FROM events_status WHERE create_id=:user_id AND status='declined'";
								$stmt_afgekeurd = $mysqli->prepare($sql_afgekeurd);
								$stmt_afgekeurd->bindParam( ":user_id", $_GET['id'], PDO::PARAM_INT );
								$stmt_afgekeurd->execute();
								
								if($stmt_afgekeurd->rowCount() == 0) //Geen evenemten van dit type
								{
									echo '<p>Geen events</p>';
								}
								else //Een of meerder evenementen van dit type
								{	
									echo '<p>';
									while($af = $stmt_afgekeurd->fetch())
									{
										echo ''.out($af['title']).'<br />';
									}
									echo '</p>';
								}
							echo '</td>
						</tr>
					</tbody>
				</table>
			</div>';
			
			//Bij het laden van de pagina staat een aangevinkte checkbox voor het bezitten van dat specifieke gebruikersrecht
			//De admin kan de rechten naar eigen inzicht veranderen door de boxes aan of af te vinken en op submit te drukken
			echo '<p>Op dit moment heeft '.$row['name'].' de volgende rechten:</p>
			<form id="admin" action="index.php?page=admin&amp;semipage=lijst_van_gebruikers&amp;id='.$_GET['id'].'" method="post">
				<input type="checkbox" name="admin_check[]" value="submit_event" id="submit_event" />Evenementen aanmaken
				<input type="checkbox" name="admin_check[]" value="approve_event" id="approve_event" />Evenementen keuren
				<input type="checkbox" name="admin_check[]" value="admin_rights" id="admin_rights" />Admin rechten<br />';
			
				echo' <span class="submit_button">
					<button class="button" type="submit">
						<span class="right"><span class="inner">Pas rechten aan</span></span>
					</button>
				</span>
			</form>';
		}
		echo '</div>';
	}
	//Fouten in de query's worden opgevangen en getoond.
	//Alleen functioneel voor het debuggen van de pagina.
	catch(Exception $exception)
	{
		echo '<p>Er is iets fout gegaan</p>';
		var_dump($exception);
	}
}
else
{	
	//Inlogrechten zijn niet correct
	if(!Functions::auth("admin_rights"))
	{
		echo '<h1>Verboden toegang!</h1> 
			<p>
			U heeft niet de benodigde rechten om deze pagina te bezoeken.<br />
			Log in of neem contact op met de administrator!
			</p>';
	}
	//URL is niet correct
	else
	{
		echo '<h1>Onbruikbare URL</h1>
			<p>
				U benadert deze pagina op de verkeerde manier!<br />
				Probeer zo veel mogelijk de website te bedienen via de interface.<br />
				URL-navigatie wordt in veel gevallen niet ondersteund.
			</p>';
	}
}
?>