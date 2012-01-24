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

if(!Functions::ingelogd())
{
	echo '<h1>Geen rechten</h1><p>U kunt deze pagina niet bekijken omdat u onvoldoende rechten heeft.</p>';
}
else
{
	try
	{
		$db = Functions::getDB();
		
		$sqlUserInfo = "SELECT email, name FROM users WHERE id = :id;";
		$stmtUserInfo = $db->prepare($sqlUserInfo);
		$stmtUserInfo->bindParam(":id", $_SESSION['userid'], PDO::PARAM_INT);
		$stmtUserInfo->execute();
		
		$sqlUserRights = "SELECT permissions.permission FROM permissions JOIN users_permissions ON users_permissions.permission_id = permissions.id WHERE users_permissions.user_id = :id;";
		$stmtUserRights = $db->prepare($sqlUserRights);
		$stmtUserRights->bindParam(':id', $_SESSION['userid'], PDO::PARAM_INT);
		$stmtUserRights->execute();
		

	
		if($stmt->rowCount() != 1)
		{
			echo '<h1>Foutje</h1><p>Deze gebruiker bestaat niet (meer).</p>';
		}
		else
		{
			$userInfo = $stmtUserInfo->fetch();
			?>
			
			<h1>Account informatie</h1>

			<form class="right" id="wijzigww" action="" method="post">
				<h3 class="big nopadding">Wachtwoord aanpassen</h3>
				<?php
				if($_SERVER['REQUEST_METHOD'] == 'POST')
				{
					try
					{
						if(!isset($_POST['newpswd']) || !isset($_POST['newpswd2']) || !isset($_POST['oldpswd'])
						{
							throw new Exception("Vul alle velden in");
						}
						
						if($_POST['newpswd'] != $_POST['newpswd2'])
						{
							throw new Exception("Nieuwe wachtwoorden ongelijk");
						}
						
						if(strlen($_POST['newpswd']) < 4)
						{
							throw new Exception("Minimaal 4 tekens");
						}
						
						try
						{
							$sql = "UPDATE users SET password = :password_new WHERE id = :id AND password = :password_old;";
							$stmt = $db->prepare($sql);
							$stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
							$stmt->bindParam(':password_new', Functions::hashPass($_POST['newpswd']), PDO::PARAM_STR);
							$stmt->bindParam(':password_old', Functions::hashPass($_POST['oldpswd']), PDO::PARAM_STR);
							$stmt->execute();
						}
						catch(Exception $e)
						{
							throw new Exception("Technische fout", 0, $e);
						}
						
						if($stmt->rowCount() != 1)
						{
							throw new Exception("Oud wachtwoord incorrect");
						}						
					}
					catch(Exception $e)
					{
						echo '<p class="error">'.$e->getMessage().'</p>';
					}
				}
				?>
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
			
			<h3 class="big nopadding">Persoonlijke informatie</h3>

			<p class="nomargintop">
				<span class="b block paddingtop">Naam:</span>
				<?php echo $userInfo['name']; ?><br />
				<span class="b block paddingtop">Accountnaam (email):</span>
				<?php echo $userInfo['email']; ?><br />
				<span class="b block paddingtop">Huidige permissies:</span>
				<?php
				if($stmtUserRights->rowCount() == 0)
				{
					echo 'Geen rechten';
				}
				else
				{
					while($rightsRow = $stmtUserRights->fetch())
					{
						echo translateRights($rightsRow['permission']).'<br />';
					}
				}
			echo '</p>';
			
			echo '<h3 class="big nopadding">Deze evenementen zijn door u aangemaakt:</h3>';	
			
			$sqlEvents = "SELECT * FROM `events_status` WHERE create_id = :user_id ORDER BY `status` ASC, `create_date` DESC";
			$stmtEvents = $db->prepare($sqlEvents);
			$stmtEvents->bindParam(':user_id', $_SESSION['userid'], PDO::PARAM_INT);
			$stmtEvents->execute();
			
			if($stmtEvents->rowCount() == 0)
			{
				echo '<p class="nomargintop">U heeft nog geen events aangemaakt</p>';
			}
			else
			{
				$events = array('approved' => array(), 'unapproved' => array(), 'declined' => array());
				while($row = $stmtEvents->fetch())
				{
					$events[$row['status']][] = $row;
				}
						
				if(count($events['unapproved']) != 0)
				{
					echo '<span class="b block paddingtop">Nog te keuren:</span>';
					foreach($events['unapproved'] as $value)
					{
						echo '<a class="colorinherit underlineswap" href="index.php?page=evenement&amp;id='.$value['id'].'&amp;semipage=agenda_week">- '.$value['title'].'</a><br />';
					}
				}
				
				if(count($events['approved']) != 0)
				{
					echo '<span class="b block paddingtop">Goedgekeurde evenementen:</span>';
					foreach($events['approved'] as $value)
					{
						echo '<a class="colorinherit underlineswap" href="index.php?page=evenement&amp;id='.$value['id'].'&amp;semipage=agenda_week">- '.$value['title'].'</a><br />';
					}
				}
				
				if(count($events['declined']) != 0)
				{
					echo '<span class="b block paddingtop">Afgekeurde evenementen:</span>';
					foreach($events['declined'] as $value)
					{
						echo '<a class="colorinherit underlineswap" href="index.php?page=evenement&amp;id='.$value['id'].'&amp;semipage=agenda_week">- '.$value['title'].'</a><br />';
					}
				}
			?>
				<!--
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
				-->
			<?php
			}// End Else ~If(Er zijn geen events)
		}// End Else ~If(user bestaat)
	}
	catch(Exception $e)
	{
		echo $e.'<br /><h1>Foutje</h1><p>Excuses, technische fout</p>';
	}
}
?>