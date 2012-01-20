<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	print_r($_POST);
}
?>


<form action="" method="post">
		<input type="checkbox" name="bla[]" value="klant" />Klant
<input type="checkbox" name="bla[]" value="keuken" />Keuken
	<input type="checkbox" name="bla[]" value="afwas" />Afwassers
	<input type="checkbox" name="bla[]" value="bar" />Barpersoneel
	<input type="submit" />
	</form>