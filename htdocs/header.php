<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ne" xml:lang="ne">

<head>
	<title>Grand Café L'Ambiance</title><!--Titel van tabblad en pagina-->
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<link rel="stylesheet" type="text/css" href="css.css" title="CSS" /><!--Opmaak uit css.css-->
	<link rel="shortcut icon" type="image/x-ico" href="afbeeldingen/favicon.ico" />
	
	<?php
	//Javascript uit liveSearch.js wordt alleen gebruikt in lijst_van_gebruikers
	//Deze wordt gebruikt voor de zoekbalk op die pagina
	if(PAGE == 'lijst_van_gebruikers')
	{
		echo '<script type="text/javascript" src="jquery.js"></script><script type="text/javascript" src="liveSearch.js"></script>';
	}
	?>
	<script type="text/javascript" src="showEvents.js"></script>
</head>

<body>
<div id="maincontainer">
	<div id="header">
	
		<?php
		//Meldingen voor de inlogbox worden verkregen uit de URL
		//Mogelijkheden zijn incomplete_form en invalid_login
		if(!isset($_GET['notice']))
		{
			$_GET['notice'] = false;
		}
		
		//Als je niet ingelogd bent, krijg je een inlogbox te zien
		//Ook is het mogelijk je te registreren via de inlogbox
		if(!Functions::ingelogd())
		{			
			echo '<div id="inlogbox">
					<form action="https://websec.science.uva.nl/webdb1235/index.php?page=login" method="post">
						<input id="naam" type="text" placeholder="Email adres" name="naam" />
						<input id="pwd" type="password" placeholder="Wachtwoord" name="pwd" />
						<input id="inlogbutton" type="submit" value="" title="inloggen" />				
					</form>
					<span id="registratielink">
						<a href="index.php?page=registratie" title="registreren">Registreren </a>
						'.(($_GET['notice'] == 'incomplete_form') ? '<span class="error small">Vul alle velden in!</span>' : '').'
						'.(($_GET['notice'] == 'invalid_login') ? '<span class="error small">Verkeerde gegevens</span>' : '').'
					</span>
				</div>';
		}
		//Als je wel ingelogd bent, wordt gebruikersnaam weergegeven
		//en er is een mogelijkheid om uit te loggen
		else
		{
			try
			{
				$db = Functions::getDB();
				//SQL-query om gebruikersnaam op te halen
				$stmt = $db->prepare("SELECT name FROM users WHERE id = :id;");
				$stmt->bindParam(':id', $_SESSION['userid'], PDO::PARAM_INT);
				$stmt->execute();
				$row = $stmt->fetch();
				
				echo '<div class="ingelogd">
						<div id="ingelogd_info">
							<p>Ingelogd als: <a href="index.php?page=account" title="Account Informatie">'.out($row['name']).'</a></p>
							<p><a href="goodbye.php">Uitloggen</a></p>
						</div>
					</div>';
			}
			//Mocht er iets fout gaan met de connectie met de database
			//dan wordt er een foutmelding gegeven.
			catch(Exception $e)
			{
				echo '<div class="ingelogd">
						<div id="ingelogd_info">
							<p class="error">Informatie kon niet worden opgehaald</p>
							<p><a href="goodbye.php">Uitloggen</a></p>
						</div>
					</div>';
			}
		}
	?>
		
	</div>
	<div id="menu">
		<ul>
			<?php
			//Unorderded list met tab-bladen
			$menuItems = array('agenda_week' => 'Agenda');//Standaard tab-blad
			
			//Extra tabbladen worden weergegeven voor ingelogde gebruikers,
			//afhankelijk van de gebruikersrechten
			if(Functions::ingelogd())
			{
				$db = Functions::getDB();
				//SQL-query om de gebruikersrechten op te maken
				$s = $db->prepare("SELECT permission FROM permissions JOIN users_permissions ON permissions.id = users_permissions.permission_id WHERE users_permissions.user_id = :id");
				$s->bindParam(':id', $_SESSION['userid'], PDO::PARAM_INT);
				$s->execute();
				
				//Zolang er nog rechten zijn, doorloop database en voeg extra tab-bladen toe
				while($row = $s->fetch())
				{
					switch($row['permission'])
					{
						case "submit_event"://Recht om evenementen toe te voegen
							$menuItems['toevoeg_evenement'] = 'Evenement toevoegen';
						break;
						case "approve_event"://Recht om evenementen te keuren
							try
							{
								$menuItems['keuren'] = 'Evenementen keuren';
								$stmt = $db->prepare("SELECT COUNT(*) AS aantal FROM events_status WHERE status = 'unapproved';");
								$stmt->execute();
								$row = $stmt->fetch();
								$menuItems['keuren'] .= ' ('.$row['aantal'].')';
								
							}
							catch(Exception $e)
							{
								
							}							
						break;
						case "admin_rights"://Administrator rechten om profielinformatie aan te passen
							$menuItems['lijst_van_gebruikers'] = 'Admin';
						break;
					}
				}
			}
			//Extra registratie tab-blad voor niet ingelogde gebruikers
			else
			{
				$menuItems['registratie'] = 'Registreren';
			}
			$menuItems['contact'] = 'Contact' ;//Standaard tab-blad
			
			//Semipage wordt gebruikt om bij te houden uit welk tab-blad de gebruiker kwam
			//Zo heeft evenement.php bijvoorbeeld meerdere weergaven, afhankelijk van de semipage
			if(!isset($_GET['semipage']))
			{
				$semiPage = null;
			}
			else
			{
				$semiPage = $_GET['semipage'];
			}	
			
			//Maakt van elke tab een link
			foreach($menuItems as $fileName => $screenName)
			{
				echo '<li '.(($fileName == PAGE || $semiPage == $fileName) ? 'class="active" ' : '').'><a href="index.php?page='.$fileName.'"><span>'.$screenName.'</span></a></li>';
			}

			?>
		</ul>
	</div>
	
	<!--Lege regel wordt met css een background meegegeven (afbeeldingen/content-top-background.jpg)
	Dit zorgt voor het afronden van de hoeken aan de bovenkant van de content-->
	<div id="topcontent">
		&nbsp;
	</div>
	<div id="content">
	<!-- End of header.html -->
