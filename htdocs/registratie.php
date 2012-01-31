<!--
Pagina waar nieuwe gebruikers zich kunnen registreren
webdb1235, registratie.php
-->

<?php
//alleen mensen die niet ingelogd zijn kunnen zich registreren, als iemeand die al is ingelogd op de een of andere manier deze pagina probeert te bereiken
//krijgt hij een foutmelding te zien
if(Functions::ingelogd())
{
	echo '<h1>Oeps</h1><p>Je kan je niet registreren als je al ingelogd bent</p>';
}
else
{
?>

<h1>Registratie formulier</h1>

<div class="form">
<?php
//als de gebruiker het formulier onjuist invlut krijgt hij een van de volgende foutmeldingen
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	try
	{
		//kijk of een van de velden leeg is, of niet is meegestuurd. als niet zeg: alle velden zijn verplicht
		if(!isset($_POST['naamVolledig']) || !isset($_POST['mail']) || !isset($_POST['pswd']) 
			|| !isset($_POST['pswd2']) || empty($_POST['naamVolledig']) || empty($_POST['mail']) || empty($_POST['pswd']) || empty($_POST['pswd2']))
		{
			throw new Exception("Alle velden zijn verplicht");
		}
		
		//kijk of het nieuwe wachtwoord twee keer hetzelfde is ingevuld, als niet geef bericht
		if($_POST['pswd'] != $_POST['pswd2'])
		{
			throw new Exception("Wachtwoorden zijn ongelijk");
		}
		
		//kijk of het wachtwoord lang genoeg is, anders dit melden
		if(strlen($_POST['pswd']) < 4)
		{
			throw new Exception("Wachtwoord moet minimaal 4 tekens hebben");
		}
		
		//als alles ok is data versturen en nieuwe gebruiker creeeren in de database
		try
		{
			$db = Functions::getDB();
			$sql = "INSERT INTO users (id, email, password, name) VALUES (NULL, :email, :password, :name);";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':email', $_POST['mail'], PDO::PARAM_STR);
			$stmt->bindParam(':password', Functions::hashPass($_POST['pswd']), PDO::PARAM_STR);
			$stmt->bindParam(':name', $_POST['naamVolledig'], PDO::PARAM_STR);
			$stmt->execute();
			
			//log nieuwe gebruiker gelijk in
			$_SESSION['userid'] = $db->lastInsertId();
		}
		catch(Exception $e)	// we vangen een database fout op en rethrowen dit met een nette foutmelding
		{
			if($stmt->errorCode() == '23000')		// SQLSTATE 23000 = unique key violation (dus, emailadres bestaat al daar dat de enige unique key is)
			{
				throw new Exception("Dit emailadres is al in gebruik", 0 , $e);
			}
			throw new Exception("Technisch probleem, excuses", 0, $e);
		}			
		
		//als registratie succesvol is, geef hier bericht van
		echo '<p class="succes">Registratie gelukt, u bent nu direct ingelogd<br /><a href="index.php">Voltooien</a></p>';
	}
	catch(Exception $e)
	{
		echo '<p class="error">'.$e->getMessage().'</p>';
	}
}
?>
<!--
Het daadwerkelijke form, stuurt de informatie naar deze pagina dus action is leeg, verstuurt informatie via de post methode
-->
<form id="register" action="" method="post">
	<table>
		<tbody>
			<tr>
				<td>Volledige naam: </td>
				<td><input type="text" id="naamVolledig" name="naamVolledig" /></td>
			</tr>
			<tr>
				<td>Emailadres: </td>
				<td><input type="text" id="mail" name="mail" /></td>
			</tr>
			<tr>
				<td>Wachtwoord: </td>
				<td><input type="password" id="pswd" name="pswd" /></td>
			</tr>
			<tr>
				<td>Wachtwoord nogmaals: </td>
				<td><input type="password" id="pswd2" name="pswd2" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="submit_button">
					<button type="submit" class="button">
						<span class="right">
							<span class="inner">
								Registreer
							</span>
						</span>
					</button>
				</td>
			</tr>
		</tbody>
	</table>
</form>
</div>
<?php
}
?>
