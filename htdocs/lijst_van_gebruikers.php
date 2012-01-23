<div class="userlist">
	<table id="sort_table">
		<tr>
			<td id="sort_name">
				Sorteren op:
			</td>
			<td id="sorteer">
				<select name="sorteer">
				<option value="-------">-------</option>
				<option value="Naam">Naam</option>
				<option value="Rechten">Rechten</option>
				<option value="ID">ID</option>
				</select>
			</td>
			<td id="recht_checkbox">
				<form action="" method="post">
					<ul>
						<li><input type="checkbox" value="aanmaken" />Aanmaken</li>
						<li><input type="checkbox" value="keuren" />Keuren</li>
						<li><input type="checkbox" value="admin" />Admin</li>
					</ul>
				</form>
			</td>
			<td id="zoek">
				<span id="zoek_text">Zoek:</span>
				<input type="text" id="zoek_box" name="zoek" />
			</td>
		</tr>
	</table>
	
	<h1>Lijst van gebruikers</h1>
		<p>
			Klik op een gebruiker om gegevens van deze gebruiker te bekijken en zijn rechten aan te passen
		</p>
	
		<?php
		
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
					echo '<li>';
					echo '<a href="index.php?page=admin&amp;id='.$row['id'].'&amp;semipage=lijst_van_gebruikers">'.$row['name'].'</a>';
					echo '</li>';
				}
			}
		}
	}
	else
    {
        echo 'Er zit een fout in de query: '.$mysqli->error;
    }

?>

	<ul id="userlistlist">
		<li>
			<a href="index.php?page=admin&amp;semipage=lijst_van_gebruikers">Freek Boutkan</a>
		</li>
		<li>
			<a href="index.php?page=admin&amp;semipage=lijst_van_gebruikers">Ivan Plantevin</a>
		</li>
		<li>
			<a href="index.php?page=admin&amp;semipage=lijst_van_gebruikers">Vincent Velthuis</a>
		</li>
		<li>
			<a href="index.php?page=admin&amp;semipage=lijst_van_gebruikers">David Woudenberg</a>
		</li>
	</ul>	
</div> 
