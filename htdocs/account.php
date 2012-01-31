<?php
//functie voor het vertalen van de rechten naar het nederlands
//
function translateRights($right)
{
	switch($right)
	{
		case "submit_event":
			return 'Evenement toevoegen';
		break;
		case "approve_event":
			return 'Evenement keuren';
		break;
		case "admin_rights":
			return 'Gebruikersrechten aanpassen';
		break;
		default:
			return $right;
		break;
	}
}

if(!Functions::ingelogd()) // voor deze pagina moet je zijn ingelogd en de juiste rechten hebben
{
	echo '<h1>Geen rechten</h1><p>U kunt deze pagina niet bekijken omdat u onvoldoende rechten heeft.</p>';
}
else // gebruiker mag  hier komen
{
	try
	{
		$db = Functions::getDB();	// vraag de database connectie op
		
		// Haal accountinformatie op van de ingelogde persoon
		$sqlUserInfo = "	SELECT
								email,
								name
							FROM
								users
							WHERE
								id = :id;";
								
		$stmtUserInfo = $db->prepare($sqlUserInfo);
		$stmtUserInfo->bindParam(":id", $_SESSION['userid'], PDO::PARAM_INT);
		$stmtUserInfo->execute();
		
		// haal de rechten van de gebruiker op
		$sqlUserRights = "	SELECT
								permissions.permission
							FROM
								permissions
							JOIN
								users_permissions
							ON
								users_permissions.permission_id = permissions.id
							WHERE
								users_permissions.user_id = :id;";
								
		$stmtUserRights = $db->prepare($sqlUserRights);
		$stmtUserRights->bindParam(':id', $_SESSION['userid'], PDO::PARAM_INT);
		$stmtUserRights->execute();
		

		// gebruiker bestaat niet meer!
		if($stmtUserInfo->rowCount() != 1)
		{
			echo '<h1>Foutje</h1><p>Deze gebruiker bestaat niet (meer).</p>';
		}
		else // gebruiker bestaat, fetch de data
		{
			$userInfo = $stmtUserInfo->fetch();
			?>
			
			<h1>Account informatie</h1>

			<form class="right" id="wijzigww" action="" method="post"> <!-- action="", dus zelfde pagina --> 
				<h3 class="big nopadding">Wachtwoord aanpassen</h3>
				<?php
				if($_SERVER['REQUEST_METHOD'] == 'POST')	// het formulier (veranderww) is verzonden
				{
					try // probeer het wachtwoord te veranderen
					{
						// controle aanwezigheid alle data uit formulier
						if(!isset($_POST['pswdo']) || !isset($_POST['pswd']) || !isset($_POST['pswd2']) || empty($_POST['pswdo']) || empty($_POST['pswd']) || empty($_POST['pswd2']))
						{
							throw new Exception("Vul alle velden in");
						}
						
						// zijn er geen fouten in het wachtwoord?
						if($_POST['pswd'] != $_POST['pswd2'])
						{
							throw new Exception("Nieuwe wachtwoorden ongelijk");
						}
						
						// is het wachtwoord lang genoeg?
						if(strlen($_POST['pswd']) < 4)
						{
							throw new Exception("Minimaal 4 tekens");
						}
						
						if($_POST['pswd'] == $_POST['pswdo'])
						{
							throw new Exception ("Nieuwe wachtwoord is gelijk aan het oude wachtwoord");
						}
						
						try // genestelde try
						{
							// Data is correct, nu de db in
							$sql = "	UPDATE
											`users`
										SET
											`password` = :password_new
										WHERE
											`id` = :id
										AND
											`password` = :password_old;";
			
							$stmt = $db->prepare($sql);
							$stmt->bindParam(':id', $_SESSION['userid'], PDO::PARAM_INT);
							$stmt->bindParam(':password_new', Functions::hashPass($_POST['pswd']), PDO::PARAM_STR);
							$stmt->bindParam(':password_old', Functions::hashPass($_POST['pswdo']), PDO::PARAM_STR);
							$stmt->execute();								
						}
						catch(Exception $e)
						{
							throw new Exception("Technische fout", 0, $e); // rethrow de exception om een userfriendly error message te maken
						}
						
						if($stmt->rowCount() != 1)
						{
							// als er geen rij is aangepast was het oude wachtwoord incorrect
							throw new Exception("Oud wachtwoord incorrect");
						}
						// als we tot dit punt zijn gekomen is alles gelukt, dit laten we de gebruiker weten
						echo '<p class="succes">Wachtwoord veranderd</p>';
					}
					catch(Exception $e)
					{
						// er is iets mis gegaan, laat een foutmelding zien.
						echo '<p class="error">'.$e->getMessage().'</p>';
					}
				}
				?>
				<table id="wijzigww_tabel">
					<tbody>
						<tr>
							<td>Oud wachtwoord: </td>
							<td><input type="password" name="pswdo" /></td>
						</tr>
						<tr>
							<td>Nieuw wachtwoord: </td>
							<td><input type="password" name="pswd" /></td>
						</tr>
						<tr>
							<td>Wachtwoord nogmaals: </td>
							<td><input type="password" name="pswd2" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td id="wijzigww_buttons" class="submit_button">
								<button type="submit" class="button" id="wwopslaan"><span class="right"><span class="inner">Wachtwoord opslaan</span></span></button><br />
								<button type="reset" class="button" id="wwreset"><span class="right"><span class="inner">Velden wissen</span></span></button>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
			
			<h3 class="big nopadding">Persoonlijke informatie</h3>

			<p class="nomargintop">
				<span class="b block paddingtop">Naam:</span>
				<?php echo out($userInfo['name']); ?><br />
				<span class="b block paddingtop">Accountnaam (email):</span>
				<?php echo out($userInfo['email']); ?><br />
				<span class="b block paddingtop">Huidige permissies:</span>
				<?php
				if($stmtUserRights->rowCount() == 0)
				{
					// geen rijen met rechten, deze gebruiker is dus rechtloos
					echo 'Geen rechten';
				}
				else // wel rijen met rechten
				{
					while($rightsRow = $stmtUserRights->fetch())
					{
						// print deze rechten onder elkaar
						echo translateRights($rightsRow['permission']).'<br />';
					}
				}
			echo '</p>';
			
			echo '<h3 class="big nopadding">Deze evenementen zijn door u aangemaakt:</h3>';	
			
			// Haal alle events op die de gebruiker heeft aangemaakt
			$sqlEvents = "	SELECT
								*
							FROM
								`events_status`
							WHERE
								create_id = :user_id
							ORDER BY
								`status` ASC,
								`create_date` DESC";
								
			$stmtEvents = $db->prepare($sqlEvents);
			$stmtEvents->bindParam(':user_id', $_SESSION['userid'], PDO::PARAM_INT);
			$stmtEvents->execute();
			
			if($stmtEvents->rowCount() == 0) // geen events
			{
				echo '<p class="nomargintop">U heeft nog geen events aangemaakt</p>';
			}
			else // wel events
			{
				
				//stop de events even in een handige ass. array
				//gesorteerd per status
				$events = array('approved' => array(), 'unapproved' => array(), 'declined' => array());
				while($row = $stmtEvents->fetch())
				{
					$events[$row['status']][] = $row;
				}
				
				//de volgende drie if blokken printen een lijst van evenementen (gegroepeerd per status)
				// als er geen events zijn met de bepaalde status wordt er niets getoond.
				
				// 1/3
				if(count($events['unapproved']) != 0)
				{
					echo '<span class="b block paddingtop">Nog te keuren:</span>';
					foreach($events['unapproved'] as $value)
					{
						echo '<a class="colorinherit underlineswap" href="index.php?page=evenement&amp;id='.$value['id'].'&amp;semipage=keuren">- '.out($value['title']).'</a><br />';
					}
				}
				
				// 2/3
				if(count($events['approved']) != 0)
				{
					echo '<span class="b block paddingtop">Goedgekeurde evenementen:</span>';
					foreach($events['approved'] as $value)
					{
						echo '<a class="colorinherit underlineswap" href="index.php?page=evenement&amp;id='.$value['id'].'&amp;semipage=agenda_week">- '.out($value['title']).'</a><br />';
					}
				}
				
				// 3/3
				if(count($events['declined']) != 0)
				{
					echo '<span class="b block paddingtop">Afgekeurde evenementen:</span>';
					foreach($events['declined'] as $value)
					{
						echo '- '.out($value['title']).'<br />';
					}
				}
			}// End Else ~If(Er zijn geen events)
		}// End Else ~If(user bestaat)
	}
	catch(Exception $e)
	{
		// vermoedelijk mislukte query
		echo '<br /><h1>Foutje</h1><p>Excuses, technische fout</p>';
	}
}
?>