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
		<!--<div id="inlogbox">
			<form action="" method="post">
				<input id="naam" type="text" placeholder="Email adres" name="naam" />
				<input id="pwd" type="password" placeholder="Wachtwoord" name="pwd" />
				<input id="inlogbutton" type="submit" value="" title="inloggen" />				
			</form>
			<span id="registratielink"><a href="index.php?page=registratie" title="registreren">Registreren </a></span>
		</div>
		-->
			
		
		<div class="ingelogd">
			<div id="ingelogd_info">
				<p>Ingelogd als: <a href="index.php?page=account" title="Account Informatie">Jan-Pieter de Vries</a></p>
				<p><a href="index.php?page=goodbye">Uitloggen</a></p>
			</div>
		</div>
		
	</div>
	<div id="menu">
		<ul>
			<?php
			
			if(!isset($_GET['semipage']))
			{
				$semiPage = null;
			}
			else
			{
				$semiPage = $_GET['semipage'];
			}
			
			$menuItems = array('agenda_week' => 'Agenda', 'toevoeg_evenement' => 'Evenement toevoegen', 
				'keuren' => 'Evenement goedkeuren', 'lijst_van_gebruikers' => 'Gebruikers rechten aanpassen', 'contact' => 'Contact');
			
			foreach($menuItems as $fileName => $screenName)
			{
				echo '<li '.(($fileName == PAGE || $semiPage == $fileName) ? 'class="active" ' : '').'><a href="index.php?page='.$fileName.'"><span>'.$screenName.'</span></a></li>';
			}

			?>
		</ul>
	</div>
	
	<div id="topcontent">
		&nbsp;
	</div>
	<div id="content">
	<!-- End of header.html -->
