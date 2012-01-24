<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ne" xml:lang="ne">

<head>
	<title>Welkom bij de openbare agenda van Grand Café L'Ambiance!</title>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<link rel="stylesheet" type="text/css" href="css.css" title="CSS" />
	<link rel="shortcut icon" type="image/x-ico" href="afbeeldingen/favicon.ico" />
</head>

<body>
<div id="maincontainer">
	<div id="header">
	
		<?php
		if(!isset($_GET['notice']))
		{
			$_GET['notice'] = false;
		}
		
		if(!Functions::ingelogd())
		{			
			echo '<div id="inlogbox">
					<form action="index.php?page=login" method="post">
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
		else
		{
			try
			{
				$db = Functions::getDB();
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
			if(Functions::ingelogd())
			{
				$db = Functions::getDB();
				$s = $db->prepare("SELECT permission FROM permissions JOIN users_permissions ON permissions.id = users_permissions.permission_id WHERE users_permissions.user_id = :id");
				$s->bindParam(':id', $_SESSION['userid'], PDO::PARAM_INT);
				$s->execute();
				print_r($s->fetchAll());
			}
			
			if(!isset($_GET['semipage']))
			{
				$semiPage = null;
			}
			else
			{
				$semiPage = $_GET['semipage'];
			}
			
			$menuItems = array('agenda_week' => 'Agenda', 'toevoeg_evenement' => 'Evenement toevoegen', 
				'keuren' => 'Evenementen keuren', 'lijst_van_gebruikers' => 'Gebruikersrechten aanpassen', 'contact' => 'Contact');
				
						
			$showItems = array('agenda_week' => array(), 'toevoeg_evenement' => array('submit_event'), 'keuren' => array('approve_event'), 'lijst_van_gebruikers' => array('admin_rights'), 'contact' => array(), 'registreren' => array());
			
			foreach($menuItems as $fileName => $screenName)
			{
				echo '<li '.(($fileName == PAGE || $semiPage == $fileName) ? 'class="active" ' : '').'><a href="index.php?page='.$fileName.'"><span>'.$screenName.'</span></a></li>';
				if(!isset($showItems[$fileName]))
				{
				
				}
				else
				{
					
				}
			}

			?>
		</ul>
	</div>
	
	<div id="topcontent">
		&nbsp;
	</div>
	<div id="content">
	<!-- End of header.html -->
