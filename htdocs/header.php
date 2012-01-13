<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ne" xml:lang="ne">

<head>
	<title>Welkom bij de openbare agenda van De Zuipschuit!</title>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<link rel="stylesheet" type="text/css" href="css.css" title="CSS" />
	<link rel="shortcut icon" type="image/x-icon" href="afbeeldingen/favicon.ico" />
</head>

<body>
<div id="maincontainer">
	<div id="header">
			<form class="inloggen" action="">
				<fieldset>
					<legend>Inloggen</legend>
					<label for="naam">Gebruikersnaam:</label>
					<input id="naam" type="text" name="naam" />
					<label for="pwd">Wachtwoord:</label>
					<input id="pwd" type="password" name="pwd" />
					<input id="inlogbutton" type="submit" value="Inloggen" />
				</fieldset>
			</form>
			
			<!--
			<div class="ingelogd">
				<fieldset>
					<legend>Ingelogd als</legend>
					<p>gebruiker: 'naam'</p>
					<button>Uitloggen</button>
				</fieldset>
			</div>
			-->
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
			
			$menuItems = array('agenda_week' => 'Agenda', 'toevoeg_evenement' => 'Evenement toevoegen', 'keuren' => 'Evenement goedkeuren');
			
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
