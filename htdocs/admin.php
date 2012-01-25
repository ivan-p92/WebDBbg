<?php
if(Functions::auth("admin_rights"))
{
	try
	{
		$mysqli = Functions::getDB();
		
		$sql = "SELECT name FROM users WHERE id=" . $_GET['id'] . ";";
		$stmt = $mysqli->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch();
				
	echo '<div class="admin">';
		
		
		if($stmt->rowCount() == 0)
		{
			echo '<p>Deze gebruiker bestaat niet</p>';
		}
		elseif(!empty($_POST))
		{
			$sql_delPermission = "DELETE FROM users_permissions WHERE user_id=:user_id";
			$stmt_delPermission = $mysqli->prepare($sql_delPermission);
			$stmt_delPermission->bindParam(":user_id",$_GET['id'],PDO::PARAM_INT);
			$stmt_delPermission->execute();
			
			$sql_addPermission = "INSERT into users_permissions (user_id, permission_id)
							VALUES (:user_id,(SELECT id FROM permissions WHERE permission = :permission));";
			$stmt_addPermission = $mysqli->prepare($sql_addPermission);
			
			foreach( $_POST['admin_check'] as $recht )
			{
				$stmt_addPermission->bindParam(':user_id',$_GET['id'],PDO::PARAM_INT);
				$stmt_addPermission->bindParam(':permission', $recht, PDO::PARAM_STR);
				$stmt_addPermission->execute();
			}
			echo '<h1>Succes!</h1>
				<p>Rechten voor '.$row['name'].' aangepast.</p>';
		}
		elseif(empty($_POST))
		{
						
			$sql_check = "SELECT permission_id FROM users_permissions WHERE user_id=" . $_GET['id'] . ";";
			$stmt_check = $mysqli->prepare($sql_check);
			$stmt_check->execute();
				?>
			
			<script type="text/javascript">
			function check_rechten( id )
			{
				switch(id)
				{
				case 1:
					document.getElementById("submit_event").checked="checked";
					break;
				case 2:
					document.getElementById("approve_event").checked="checked";
					break;
				case 3:
					document.getElementById("admin_rights").checked="checked";
					break;
				default:
					document.write("Permission_id niet correct");
				}
			}
			
			function init()
			{
			<?php
				while($check = $stmt_check->fetch())
				{
					echo "check_rechten(".$check['permission_id'].");\n";
				}
			?>
			}
			
			document.addEventListener("DOMContentLoaded", init, false);
			</script>
			
			<?php
				echo'
				<h1>Admin pagina van '.$row['name'].'</h1>
					<p>U kunt hier zien welke evenementen door '.$row['name'].' aangemaakt/goedgekeurd/afgekeurd zijn.<br />
						Ook kunt u diens rechten hier aanpassen.</p>
					<p>De volgende evenementen zijn door '.$row['name'].' aangemaakt:</p>
					
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
									<td class="admin_td">';
										$sql_ongekeurd = "SELECT title,id FROM events_status WHERE create_id=".$_GET['id']." AND status='unapproved'";
										$stmt_ongekeurd = $mysqli->prepare($sql_ongekeurd);
										$stmt_ongekeurd->execute();
										
										if($stmt_ongekeurd->rowCount() == 0)
										{
											echo '<p>Geen events</p>';
										}
										else
										{
											echo '<p>';
											while($on = $stmt_ongekeurd->fetch())
											{
												echo '<a href="index.php?page=evenement&amp;id='.$on['id'].'&amp;semipage=keuren">'.out($on['title']).'</a><br />';
											}
											echo '</p>';
										}
										echo '</td>
									<td class="admin_td">';
										$sql_goedgekeurd = "SELECT title,id FROM events_status WHERE create_id=".$_GET['id']." AND status='approved'";
										$stmt_goedgekeurd = $mysqli->prepare($sql_goedgekeurd);
										$stmt_goedgekeurd->execute();
										
										if($stmt_goedgekeurd->rowCount() == 0)
										{
											echo '<p>Geen events</p>';
										}
										else
										{
											echo '<p>';
											while($goed = $stmt_goedgekeurd->fetch())
											{
												echo '<a href="index.php?page=evenement&amp;id='.$goed['id'].'&amp;semipage=agenda_week">'.out($goed['title']).'</a><br />';
											}
											echo '</p>';
										}
										echo '</td>
									<td class="admin_td">';
										$sql_afgekeurd = "SELECT title,id FROM events_status WHERE create_id=".$_GET['id']." AND status='declined'";
										$stmt_afgekeurd = $mysqli->prepare($sql_afgekeurd);
										$stmt_afgekeurd->execute();
										
										if($stmt_afgekeurd->rowCount() == 0)
										{
											echo '<p>Geen events</p>';
										}
										else
										{	
											echo '<p>';
											while($af = $stmt_afgekeurd->fetch())
											{
												echo out($af['title'])'<br />';
											}
											echo '</p>';
										}
										echo '</td>
								</tr>
							</tbody>
						</table>
					</div>

					<p>Op dit moment heeft '.$row['name'].' de volgende rechten:</p>
					<form id="admin" action="index.php?page=admin&amp;semipage=lijst_van_gebruikers&amp;id='.$_GET['id'].'" method="post">
					
					<input type="checkbox" name="admin_check[]" value="submit_event" id="submit_event" />Evenementen aanmaken
					<input type="checkbox" name="admin_check[]" value="approve_event" id="approve_event" />Evenementen keuren
					<input type="checkbox" name="admin_check[]" value="admin_rights" id="admin_rights" />Admin rechten<br />';
					
					echo' <span class="submit_button">
								<button class="button" type="submit">
									<span class="right"><span class="inner">Pas rechten aan</span></span>
								</button>
						  </span>
					</form>';
		}
	}
	catch(Exception $exception)
	{
		echo '<p>Er is iets fout gegaan</p>';
		var_dump($exception);
	}
		echo '</div>';
}
else
{
	echo '<h1>Verboden toegang!</h1> 
	<p>U heeft niet de benodigde rechten om deze pagina te bezoeken.<br />
	Log in of neem contact op met de administrator!</p>';
}
?>
