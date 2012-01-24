<?php
if(Functions::ingelogd())
{
	echo '<h1>Oeps</h1><p>Je kan je niet registreren als je al ingelogd bent</p>';
}
else
{
?>

	<h1>Registratie formulier</h1>

	<div class="form">
		Alle velden zijn verplicht
		<?php
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			try
			{
				if(!isset($_POST['naamVolledig']) || !isset($_POST['mail']) || !isset($_POST['pswd']) || !isset($_POST['pswd2']) || empty($_POST['naamVolledig']) || empty($_POST['mail']) || empty($_POST['pswd']) || empty($_POST['pswd2']))
				{
					throw new Exception("Alle velden zijn verplicht");
				}
				
				if($_POST['pswd'] != $_POST['pswd2'])
				{
					throw new Exception("Wachtwoorden zijn ongelijk");
				}
				
				if(strlen($_POST['pswd']) < 4)
				{
					throw new Exception("Wachtwoord moet minimaal 4 tekens hebben");
				}
				
				try
				{
					$db = Functions::getDB();
					$sql = "INSERT INTO users (id, email, password, name) VALUES (NULL, :email, :password, :name);";
					$stmt = $db->prepare($sql);
					$stmt->bindParam(':email', $_POST['mail'], PDO::PARAM_STR);
					$stmt->bindParam(':password', Functions::hashPass($_POST['pswd']), PDO::PARAM_STR);
					$stmt->bindParam(':name', $_POST['naamVolledig'], PDO::PARAM_STR);
					$stmt->execute();
					
					$_SESSION['userid'] = $db->lastInsertId();
				}
				catch(Exception $e)
				{
					throw new Exception("Technisch probleem, excuses", 0, $e);
				}			
				
				echo '<p class="succes">Registratie gelukt, u bent nu direct ingelogd</p>';
			}
			catch(Exception $e)
			{
				echo '<p class="error">'.$e->getMessage().'</p>';
			}
		}
		?>
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
						<td class="submit_button"><button type="submit" class="button"><span class="right"><span class="inner">Registreer</span></span></button></td>
					</tr>
				</tbody>
			</table>
		</form>
	</div>
<?php
}
?>
