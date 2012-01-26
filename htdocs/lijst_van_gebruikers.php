<script type="text/javascript">
	
	// BRON: http://www.openjs.com/scripts/dom/class_manipulation.php
	function hasClass(ele,cls) {
		return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
	}
	
	// deze is wel zelf geschreven
	// geeft true terug als element (ele) ten minste 1 van de classes uit de array met classes (clsArray) bevat.
	// anders false
	function hasClassArray(ele, clsArray)
	{
		for(var i = 0; i < clsArray.length; i++)
		{
			if(hasClass(ele, clsArray[i]))
			{
				return true;			// stop de functie, class is gevonden
			}
		}
		return false;	// class niet gevonden, dus return false
	}


	function showhide (numberOfInputs)
	{		
		// zoek uit welke classes getoond moeten worden
		// selecteer elke checkbox en kijk of ze gechecked zijn of niet
		var showClasses = new Array();
		var i;
		for (i = 1; i <= numberOfInputs; i++)
		{
			var input = document.getElementById("input_" + i);
			if(input)
			{
				if(input.checked)		// deze checkbox is gechecked, users met deze rechten willen we zien.
				{
					showClasses.push("id_recht_" + input.value);
				}
			}
		}
		
		
		var userBoxes = document.getElementsByClassName('user_box');	// haal alle li's op
		for(var userBoxIndex = 0; userBoxIndex < userBoxes.length; userBoxIndex++)	// loop door alle li's 
		{
			if(showClasses.length == 0 || hasClassArray(userBoxes[userBoxIndex], showClasses))
			{
				userBoxes[userBoxIndex].style.visibility = "visible";
			}
			else
			{
				userBoxes[userBoxIndex].style.visibility = "hidden";
			}
		}
	}
	
	function showUser(id)
	{
		window.location.replace("index.php?page=admin&amp;id=" + id + "&amp;semipage=lijst_van_gebruikers");
	}
	
	function init()
	{
		showhide(3);
	}
	
	document.addEventListener("DOMContentLoaded", init, false);
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
					Gebruikers met (mi. 1 van) de volgende rechten:
				</td>
				<td id="recht_checkbox">
					<form action="" method="post">
						<ul>
							<li><input type="checkbox" id="input_1" value="aanmaken" onclick="showhide(3)" />Aanmaken</li>
							<li><input type="checkbox" id="input_2" value="keuren" onclick="showhide(3)" />Keuren</li>
							<li><input type="checkbox" id="input_3" value="admin" onclick="showhide(3)" />Admin</li>
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
						echo '<li onclick="showUser('.$row['id'].')" class="'.$classes.'">';
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
	
	//haal een lijst met de berichten op
	
	//leg connectie met database
	$db = Functions::getDB();

	//sql query om informatie op te vragen
	$sql = "SELECT id, name FROM messages;";

	//bereid de query voor
	$stmt = $db->prepare($sql);

	//voer de query uit
	$stmt->execute();
	
	$message_list="";
	
	while($messages=$stmt->fetch())
	{
		$message_list = $message_list.'<li><a href="index.php?page=bericht&amp;semipage=lijst_van_gebruikers&amp;messageid='.out($messages['id']).'>"'
			.out($messages['name']).'</a></li>';
	} 
	
	if($message_list != "")
	{
		echo '
		<div id="message_list">
			<ul>
				'.$message_list.'
			</ul>
		</div>
		';
	}
	else echo'<div id="message_list">Er zijn op dit moment geen berichten</div>';
}
else
{
	echo '<h1>Verboden toegang!</h1> <p>U moet inloggen om deze pagina te kunnen bekijken!</p>';
}
?>	
