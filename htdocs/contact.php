<!--
Pagina waarop iedereen contact kan maken met de beheerders van de site
webdb1235, contact.php
-->
<h1>Contact</h1>

<?php
//if statement, als er iets wordt verstuurd van het formulier kijkt het of het goed is ingevuld
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	try
	{
		//als het niet goed is ingevuld throw exception met bericht
		if(!isset($_POST['contact_naam']) || !isset($_POST['contact_mail']) || !isset($_POST['contact_message']) || !isset($_POST['contact_subject']) //als hij niet is ingevuld
			|| empty($_POST['contact_naam']) || empty($_POST['contact_mail']) || empty($_POST['contact_message']) || empty($_POST['contact_subject'])//als het leeg is ingevuld
			|| strlen($_POST['contact_naam']) > 64 || strlen($_POST['contact_mail']) > 256 || strlen($_POST['contact_subject']) > 64 ) //als naam of mail te lang is voor de database
		{
			throw new Exception('<p class="error">Niet alle velden zijn juist ingevuld</p>');
		}
		
		//zet het bericht in de database, als het formulier wel is ingevuld
		
		//conectie met database tot stand brengen
		$database = Functions::getDB();
		
		//de daadwerkelijke query
		$sql2 = "INSERT INTO messages (id, name, email, message, subject, datetime) VALUES (NULL, :name, :email, :message, :subject, NOW());";
		
		//bereid query voor
		$stmt2 = $database->prepare($sql2);
		
		//zet de waardes van de parameters
		$stmt2->bindParam(':name', $_POST['contact_naam'], PDO::PARAM_STR);
		$stmt2->bindParam(':email', $_POST['contact_mail'], PDO::PARAM_STR);
		$stmt2->bindParam(':message', $_POST['contact_message'], PDO::PARAM_STR);
		$stmt2->bindParam(':subject', $_POST['contact_subject'], PDO::PARAM_STR);	
		//voor de query uit
		$stmt2->execute();
		
		//volgend bericht, bevestigt een succesvolle versturing
		echo '<p class="succes">Dank voor uw bericht! Wij nemen zo spoedig mogelijk contact met u op.</p>';
		
	}//als er een fout in het ingevulde form zit	
	catch(Exception $e)
	{
		echo $e->getMessage();
	}
}


//als je ingelogd bent, worden je gegevens voor je ingevuld
try
{
	$row = null;
	if(Functions::ingelogd())
	{
	
		//leg connectie met database
		$db = Functions::getDB();
		
		//sql query om informatie op te vragen
		$sql = "SELECT name, email FROM users WHERE id = :id;";
		
		//bereid de query voor
		$stmt = $db->prepare($sql);
		
		//zet de waardes van de parameters
		$stmt->bindParam(':id', $_SESSION['userid'], PDO::PARAM_INT);
		
		//voer de query uit
		$stmt->execute();
		
		//als er iets wordt gevonden, zet het in de variabele row
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
	<table class="formtable" id="contact">
		<tbody>
		<tr>
			<td id="eerstecel">Naam</td>
			<td>
				<input type="text" <?php echo ((isset($row['name'])) ? 'readonly="readonly" value="'.out($row['name']).'"' : '');?> 
				required="required" placeholder="Typ hier uw naam" name="contact_naam" />
			</td>
		</tr>
		<tr>
			<td>Email</td>
			<td>
				<input type="text" <?php echo ((isset($row['email'])) ? 'readonly="readonly" value="'.out($row['email']).'"' : '');?>
				required="required" placeholder="Typ hier uw e-mail adres" name="contact_mail" />
			</td>
		</tr>		
		<tr>
			<td>Onderwerp</td>
			<td>
				<input type="text" required="required" placeholder="Typ hier een onderwerp" name="contact_subject" />
			</td>
		</tr>		
		<tr>
			<td>Bericht</td>
			<td>
				<textarea required="required" placeholder="Typ hier uw bericht" rows="10" cols="10" name="contact_message"></textarea>
			</td>
		</tr>
		<tr>
			<td>&nbsp</td>
			<td>
				<span class="submit_button" id="submit_contact">
					<button type="submit" class="button">
						<span class="right">
							<span class="inner">
								Verstuur bericht
							</span>
						</span>
					</button>
				</span>
			</td>
		</tr>
		</tbody>
	</table>
</form>
