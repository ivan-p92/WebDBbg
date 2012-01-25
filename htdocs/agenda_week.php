<!-- Header wordt hiervoor geladen -->
<!-- Dit zijn de navigatieknoppen voor de vorige/volgende lijst evenementen-->
<?php

if(!isset($_GET['view']) || empty($_GET['view']))
{
	$_GET['view'] = 'lijst';
}

if($_GET['view'] != 'lijst' && $_GET['view'] != 'block')
{
	$_GET['view'] = 'lijst';
}

echo '
	<div id="weergave">
		<a '.(($_GET['view'] == 'blok') ? 'class="active" ' : '').'href="index.php?page=agenda_week&amp;view=blok">Blok</a><span></span>
		<a '.(($_GET['view'] == 'lijst') ? 'class="active" ' : '').'href="index.php?page=agenda_week&amp;view=lijst">Lijst</a>
	</div>';


include('agenda_week_'.$_GET['view'].'.php');

?>
