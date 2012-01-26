<script type="text/javascript">
	function showhide (numberOfInputs)
	{
		var userBoxes = document.getElementsByClassName('user_box');	// haal alle li's op
		var userBox;	// declaar var userBox, nodig voor loop
		
		// zoek uit welke classes getoond moeten worden
		// selecteer elke checkbox en kijk of ze gechecked zijn of niet
		var showClasses = array();
		var i;
		for (i = 1; i <= numberOfInputs; i++)
		{
			var input = document.getElementById("input_" + i);
			if(input)
			{
				if(input.checked)
				{
					showClasses.push("id_recht_" + input.value);
				}
			}
		}
		
		console.log(showClasses);
		
		for(userBox in userBoxes)	// loop door alle li's 
		{
		
		}
	}

</script>
<?php
if(Functions::auth("admin_rights"))
{
	echo'
	<div class="userlist">
		<span id="sresult">
		</span>
		<table id="sort_table">
			<tr>
				<td id="sort_name">
					Toon gebruikers met de volgende rechten:
				</td>
				<td id="recht_checkbox">
					<form action="" method="post">
						<ul>
							<li><input type="checkbox" id="input_1" value="aanmaken" onclick="showhide(3)" checked="checked" />Aanmaken</li>
							<li><input type="checkbox" id="input_2" value="keuren" onclick="showhide(3)" checked="checked" />Keuren</li>
							<li><input type="checkbox" id="input_3" value="admin" onclick="showhide(3)" checked="checked" />Admin</li>
						</ul>
					</form>
				</td>
				<td id="zoek">
					<span id="zoek_text">Zoek:</span>
					<input type="text" id="zoek_box" name="zoek" />
					<span id="result"></span>
				</td>
			</tr>
		</table>
		
		<h1>Lijst van gebruikers</h1>
			<p>
				Klik op een gebruiker om gegevens van deze gebruiker te bekijken en zijn rechten aan te passen
			</p>
		';
		
			
		$mysqli = Functions::getDB();

		$sql = "SELECT id, name FROM users;";

		if($stmt = $mysqli->prepare($sql))
		{
			if(!$stmt->execute())
			{
				echo 'Het uitvoeren van de query is mislukt: '.$stmt->error.' in query: '.$sql;
			}
			else
			{
				if($stmt->rowCount() == 0)
				{
					echo '<p>Er zijn geen gebruikers gevonden.</p>';
				}
				else
				{
					echo '<ul id="userlistlist">';
					while($row = $stmt->fetch())
					{
						$sql_recht = "SELECT permission_id FROM users_permissions WHERE user_id=:id";
						$stmt_recht = $mysqli->prepare($sql_recht);
						$stmt_recht->bindParam(":id",$row['id'],PDO::PARAM_INT);
						$stmt_recht->execute();						
						
						$classes = 'user_box';
						
						while($recht = $stmt_recht->fetch())
						{
							switch($recht['permission_id'])
							{
								case 1: 
									$classes .= ' id_recht_aanmaken';
									break;
								case 2:
									$classes .= ' id_recht_keuren';
									break;
								case 3:
									$classes .= ' id_recht_admin';
									break;
							}
						}
						echo '<li class="'.$classes.'">';
						echo '<a href="index.php?page=admin&amp;id='.$row['id'].'&amp;semipage=lijst_van_gebruikers">'.$row['name'].'</a>';
						echo '</li>';
					}
					echo '</ul>';
				}
			}
		}
		else
		{
			echo 'Er zit een fout in de query: '.$mysqli->error;
		}
	echo '</div>';
}
else
{
	echo '<h1>Verboden toegang!</h1> <p>U moet inloggen om deze pagina te kunnen bekijken!</p>';
}
?>	
