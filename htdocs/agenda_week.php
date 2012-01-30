<!-- Header wordt hiervoor geladen -->

<?php
// deze pagina heeft nu geen doel meer, eerste diende deze pagina
// om verschillende weergaven te kunnen gebruiken
if(!isset($_GET['view']) || empty($_GET['view']))
{
	$_GET['view'] = 'lijst'; // standaard weergave indien niets ingevoerd
}

if($_GET['view'] != 'lijst' && $_GET['view'] != 'blok')
{
	$_GET['view'] = 'lijst'; // standaard weergave indien ongeldig ingevoerd
}


include('agenda_week_'.$_GET['view'].'.php');

?>
