<!-- Header wordt hiervoor geladen -->
<!-- Dit zijn de navigatieknoppen voor de vorige/volgende lijst evenementen-->

<div id="weergave">
<<<<<<< HEAD
	<a href="index.php?page=agenda&amp;view=blok">Blok weergave</a>
	<a href="index.php?page=agenda&amp;view=lijst">Lijst weergave</a>
=======
	<a href="index.php?page=agenda_week&amp;view=blok">Blok weergave</a>
	<a href="index.php?page=agenda_week&amp;view=lijst">Lijst weergave</a>
>>>>>>> 4c377e75dd9533e5f0b311864ac4f2b50a746b42
</div>
<?php

if(!isset($_GET['view']) || empty($_GET['view']))
{
	$_GET['view'] = 'blok';
}

if($_GET['view'] != 'blok' && $_GET['view'] != 'lijst')
{
	$_GET['view'] = 'blok';
}

include('agenda_week_'.$_GET['view'].'.php');

?>