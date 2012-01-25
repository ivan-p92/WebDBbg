<!--
Pagina waarop iedereen contact kan maken met de beheerders van de site
webdb1235, contact.php
-->
<h1>Contact</h1>

<?php
//if statement, als er iets wordt verstuurd van het formulier kijkt het of het goed is ingevuld
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//als het niet goed is ingevuld volgende message
	if(!isset($_POST['contact_naam']) || !isset($_POST['contact_mail']) || !isset($_POST['contact_message']) || empty($_POST['contact_naam']) || empty($_POST['contact_mail']) || empty($_POST['contact_message']))
	{
		echo '<p class="error">Niet alle velden zijn juist ingevuld</p>';
	}
	//als het wel goed is ingevuld, volgend bericht: 
	else
	{
		echo '<p class="succes">Dank voor uw bericht! Wij nemen zo spoedig mogelijk contact met u op.</p>';
	}

}

try
{
	//als je ingelogd bent, worden je gegevens voor je ingevuld
	$row = null;
	if(Functions::ingelogd())
	{
		$db = Functions::getDB();
		$sql = "SELECT name, email FROM users WHERE id = :id;";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':id', $_SESSION['userid'], PDO::PARAM_INT);
		$stmt->execute();
		
		if($stmt->rowCount() == 1)
		{		
			$row = $stmt->fetch();
		}
	}

}
catch(Exception $e)
{
}

?>
<!--
Het daadwerkelijke contact fomulier, form stuurt informatie naar deze pagina via post method
-->
<p>Heeft u vragen of opmerkingen, dan horen wij dat graag. <br />
Laat een bericht bij ons achter en wij nemen zo spoedig mogelijk contact met u op.</p>

<form action="" method="post">
	<table class="formtable" id="contact"><tbody>
	<tr>
		<td id="eerstecel">Naam</td>
		<td><input <?php echo ((isset($row['name'])) ? 'value="'.out($row['name']).'"' : '');?> required="required" placeholder="Typ hier uw naam" name="contact_naam" /></td>
	</tr><tr>
		<td>Email</td>
		<td><input <?php echo ((isset($row['email'])) ? 'value="'.out($row['email']).'"' : '');?>required="required" placeholder="Typ hier uw e-mail adres" name="contact_mail" /></td>
	</tr><tr>
		<td>Bericht</td>
		<td><textarea required="required" placeholder="Typ hier uw bericht" rows="10" cols="10" name="contact_message"></textarea></td>
	</tr><tr>
		<td>&nbsp</td>
		<td><span class="submit_button" id="submit_contact">
			<button type="submit" class="button">
				<span class="right">
					<span class="inner">
						Verstuur bericht
					</span>
				</span>
			</button></span>
		</td>
	</tr>
	</tbody></table>
</form>
