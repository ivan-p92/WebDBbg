<div class="admin">
	
	<?php

$mysqli = Functions::getDB();

	$sql = "SELECT name FROM users WHERE id=" . $_GET['id'] . ";";

	if($stmt = $mysqli->prepare($sql))
    {
		if(!$stmt->execute())
		{
			echo 'Het uitvoeren van de query is mislukt: '.$stmt->error.' in query: '.$sql;
		}
		else
		{echo'
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
			<ul>
			<li>
			geen
			</li>
			</ul>
			<p>
			Geef '.$row['name'].' de volgende rechten:
			</p>
			<form id="admin" action="" method="get">
			<input type="checkbox" value="create" />Evenementen aanmaken
			<input type="checkbox" value="approve" />Evenementen keuren
			<input type="checkbox" value="admin" />Admin rechten<br />
			<span id="submit_rechten" class="submit_button"><button href="#" class="button" type="submit">
					<span class="right">
					<span class="inner">Pas rechten aan</span></span>
			</button>
			</form>'
		
		}
	}
	else
    {
        echo 'Er zit een fout in de query: '.$mysqli->error;
    }
?>
</div>
