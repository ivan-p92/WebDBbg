<!-- Header wordt hiervoor geladen -->
<!-- Dit zijn de navigatieknoppen voor de vorige/volgende lijst evenementen-->
<?php

if(!isset($_GET['view']) || empty($_GET['view']))
{
	$_GET['view'] = 'lijst';
}

if($_GET['view'] != 'lijst' && $_GET['view'] != 'blok')
{
	$_GET['view'] = 'lijst';
}


include('agenda_week_'.$_GET['view'].'.php');

?>
