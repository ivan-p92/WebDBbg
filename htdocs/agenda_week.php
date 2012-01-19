<!-- Header wordt hiervoor geladen -->
<!-- Dit zijn de navigatieknoppen voor de vorige/volgende lijst evenementen-->
<?php

if(!isset($_GET['view']) || empty($_GET['view']))
{
	$_GET['view'] = 'blok';
}

if($_GET['view'] != 'blok' && $_GET['view'] != 'lijst')
{
	$_GET['view'] = 'blok';
}

echo '
	<div id="weergave">
		<a '.(($_GET['view'] == 'blok') ? 'class="active" ' : '').'href="index.php?page=agenda_week&amp;view=blok">Blok</a>
		<a '.(($_GET['view'] == 'lijst') ? 'class="active" ' : '').'href="index.php?page=agenda_week&amp;view=lijst">Lijst</a>
	</div>';


include('agenda_week_'.$_GET['view'].'.php');

?>
