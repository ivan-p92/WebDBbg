<?php
session_start();
header("Content-type: text/html; charset=utf-8");


include('functions.php');

error_reporting(E_ALL); // E_ALL (alle foutmeldingen) in ontwikkelomgeving, 0 (geen) in  de live omgeving
ini_set('display_errors', true); // true in ontwikkelomgeving, false in  de live omgeving



$ext = '.php'; // de bestandsextensie van de pagina's (nu .html later .php)  

$valid_pages = array("404", "login", "data_verstuur", "agenda_week", "footer", "header", "lijst_van_gebruikers", "tabel_events", "toevoeg_evenement", "account", "agenda_week_blok", "contact_dank", "index", "admin", "agenda_week_lijst", "contact", "evenement", "goodbye", "keuren", "registratie", "bericht");

// controleer of er een page is gespecificeerd in de url, als dat zo is en het is niet leeg en niet gelijk aan index 
if(isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] != 'index')
{
	$page = $_GET['page'];	// stel dat de variabele page in op $_GET['page'] (de page-parameter van de URL)
}
else	// anders (geen geldige page-parameter in de url)
{
	$page = 'agenda_week';	//laad de homepage
}
define('PAGE', $page);

if($page == 'inloggen')
{
	include($page.$ext);
}


include('header.php');		// laad de header (deze moet op elke pagina verschijnen)


if(file_exists($page.$ext) && $page != 'inloggen' && in_array($page, $valid_pages))   // als het gevraagde bestand bestaat, laat dit zien
{
	
	include($page.$ext);	// naam en extensie aan elkaar plakken
}
else
{
	include('404.php');	// anders de 404-pagina laten zien met nette foutmelding
}

include('footer.php');	// elke pagina stopt met de footer

?>

