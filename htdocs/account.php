<?php

function translateRights($right)
{
	switch($right)
	{
		case "submit_event":
			return 'Evenement toevoegen';
		break;
		case "approve_event":
			return 'Evenement keuren';
		break;
		case "admin_rights":
			return 'Veranderen gebruikersrechten';
		break;
		default:
			return $right;
		break;
	}
}

if(!Functions::ingelogd() || !isset($_GET['id']) || !ctype_digit($_GET['id']))
{
	echo '<h1>Geen rechten</h1><p>U kunt deze pagina niet bekijken omdat u onvoldoende rechten heeft.</p>';
}
else
{
	try
	{
		$db = Functions::getDB();
		
		$sqlUserInfo = "SELECT name FROM users WHERE id = :id;";
		$stmtUserInfo = $db->prepare($sqlUserInfo);
		$stmtUserInfo->bindParam(':id', $_GET['id'], PDO:PARAM_INT);
		$stmtUserInfo->execute();
		
		$sqlUserRights = "SELECT permissions.permission FROM permissions JOIN users_permissions ON users_permissions.permission_id = permission.id WHERE users_permissions.user_id = :id;";
		$stmtUserRights = $db->prepare($sqlUserRights);
		$stmtUserRights->bindParam(':id', $_GET['id'], PDO:PARAM_INT);
		$stmtUserRights->execute();
		
	}
	
	if($stmt->rowCount() != 1)
	{
		echo '<h1>Foutje</h1><p>Deze gebruiker bestaat niet (meer).</p>';
	}
	else
	{
		$userInfo = $stmt->fetch();
?>


	<h1>Account informatie</h1>

	<p> Op deze pagina vindt u informatie over uw account. <br />
		U kunt in het onderstaande formulier ook uw wachtwoord wijzigen.</p>

	<p>
		Naam: <?php echo $userInfo['name']; ?><br />
		Accountnaam (email): <?php echo $userInfo['email']; ?><br />
		Huidige permissies: <?php while($rightsRow = $stmtUserRights->fetch()){ echo translateRights($rightsRow['permission']).'<br />';}?>
	</p>

	<p>Deze evenementen zijn door u aangemaakt:</p>
	<div class="user_events">
		<table id="user_events">
			<tbody>
				<tr>
					<th>
					Ongekeurde Evenementen
					</th>
					<th>
					Goedgekeurde Evenementen
					</th>
					<th>
					Afgekeurde Evenementen
					</th>
				</tr>
				<tr>
					<td>
						<ul>
						<li>
							<a href="index.php?page=evenement">TEST</a>
						</li>
						</ul>
					</td>
					<td>
						<ul>
						<li>
							<a href="index.php?page=evenement">TEST</a>
						</li>
						</ul>
					</td>
					<td>
						<ul>
						<li>
							<a href="index.php?page=evenement">TEST</a>
						</li>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
	</div>

	<form id="wijzigww" action="" method="post">
		<table id="wijzigww_tabel">
			<tbody>
				<tr>
					<td>Oud wachtwoord: </td>
					<td><input type="password" id="oldpswd" name="mail" required="" /></td>
				</tr>
				<tr>
					<td>Nieuw wachtwoord: </td>
					<td><input type="password" id="newpswd" name="pswd" required="" /></td>
				</tr>
				<tr>
					<td>Wachtwoord nogmaals: </td>
					<td><input type="password" id="newpswd2" name="pswd2" required="" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td id="wijzigww_buttons" class="submit_button">
						<button type="submit" class="button" id="wwopslaan"><span class="right"><span class="inner">Wachtwoord opslaan</span></span></button><br />
						<button type="reset" class="button" id="wwreset"><span class="right"><span class="inner">Velden wissen</span></span></button>
					</td>
				</tr>
			</tbody>
		</table>
	</form>
	
<?php
	}
}
?>