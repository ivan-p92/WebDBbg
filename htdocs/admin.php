	<?php
try
{
	$mysqli = Functions::getDB();
	
	$sql = "SELECT name FROM users WHERE id=" . $_GET['id'] . ";";
	$stmt = $mysqli->prepare($sql);
	$stmt->execute();
			
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
			document.getElementById("create").checked="checked";
			break;
		case 2:
			document.getElementById("approve").checked="checked";
			break;
		case 3:
			document.getElementById("admin").checked="checked";
			break;
		default:
			document.write("Permission_id niet correct");
		}
	}
	<?php
		while($check = $stmt_check->fetch())
		{
			echo 'check_rechten('.$check['permission_id'].');';
		}
	?>
</script>
			
<div class="admin">
	
	<?php


	
	if($stmt->rowCount() == 0)
	{
		echo '<p>Deze gebruiker bestaat niet</p>';
	}
	else
	{
		$row = $stmt->fetch();
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
					</tbody>
				</table>
			</div>

			<p>Op dit moment heeft '.$row['name'].' de volgende rechten:</p>
			<form id="admin" action="" method="get">
			
			<input type="checkbox" value="create" id="create" />Evenementen aanmaken
			<input type="checkbox" value="approve" id="approve" />Evenementen keuren
			<input type="checkbox" value="admin" id="admin" />Admin rechten<br />';
			
		
			
			echo' <span id="submit_rechten" class="submit_button"><button href="#" class="button" type="submit">
					<span class="right">
					<span class="inner">Pas rechten aan</span></span>
			</button>
			</form>';
	}
}
catch(Exception $exception)
{
	echo '<p>Er is iets fout gegaan</p>';
}
?>
</div>
