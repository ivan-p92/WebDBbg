<!--Pagina voor het toevoegen van een evenement, door middel van een form. Drie cases, standaard, niet ingelogd en aanpassen
webdb1235, toevoeg_evenement.php
-->

<h1>Evenement toevoegen</h1>

<?php
//array voor het weergeven van de juiste maand
$arraymonth = array("bla", "januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus", "september", "oktober", "november", "december");

//case, gebruiker maakt nieuw evenement aan en wil weer aanpassen. Data uit $_SESSION["tijdelijke_evenementswaardes] worden als default gegeven in de velden
if(Functions::auth("submit_event") && isset($_SESSION["tijdelijke_evenementwaardes"])) 
{
	echo'
	<p>Voeg hier een evenement toe, zorg ervoor dat alle velden worden ingevuld</p>
	'
	
	//form, informatie gaat naar link bij action via post methode. Form elementen zitten in een tabel, dit maakt de opmaak in CSS simpeler
	echo'
	<div class="form">
	<form id="input" action="http://websec.science.uva.nl/webdb1235/index.php?page=evenement&amp;semipage=toevoeg_evenement" method="post">
	<table class="formtable" id="event_toevoegen">
	<tbody>
		<tr>
		<td id="eerstecel">Titel</td>
			<td><input id="titel" type="text" name="titel" value="'.$_SESSION["tijdelijke_evenementwaardes"]["titel"].'" /></td>
		</tr>
		<tr id="omschrijving">
		<td>Omschrijving</td>
			<td><textarea name="omschrijving" rows="" cols="">'.$_SESSION["tijdelijke_evenementwaardes"]["omschrijving"].'</textarea></td>
		</tr>
		<tr>
			<td>Begindatum</td>
				<td>
					<select id="datum1" name="datum1">
					';
					//for loop voor het dynamisch genereren van een drop down select list voor de datum, waarin de eerder gekozen data als default wordt geselecteerd
					$datum = $_SESSION["tijdelijke_evenementwaardes"]["datum1"];
					for($i=1; $i<=31; $i++)
					{
						if($i == $datum) echo'<option value="'.$i.'" selected="selected">'.$i.'</option>';
						else echo'<option value="'.$i.'">'.$i.'</option>';
					}
					echo'
					</select>
					<select name="maand1">
					'; 
					//for loop voor het dynamisch genereren van een drop down select list voor de maand, waarin de eerder gekozen maand als default wordt geselecteerd
					$maand = $_SESSION["tijdelijke_evenementwaardes"]["maand1"];
						for($j=1; $j<=12; $j++)
						{
							if($j == $maand) echo'<option value="'.$j.'" selected="selected">'.$arraymonth[$j].'</option>';
							else echo'<option value="'.$j.'">'.$arraymonth[$j].'</option>';
						}
					echo'
					</select>
					<select name="jaar1">
					';
					//for loop voor het dynamisch genereren van een drop down select list voor het jaar, waarin het eerder gekozen jaar als default wordt geselecteerd
					$jaar = $_SESSION["tijdelijke_evenementwaardes"]["jaar1"];
						for($k=2012; $k<=2022; $k++)
						{
							if($k == $jaar) echo'<option value="'.$k.'" selected="selected">'.$k.'</option>';
							else echo'<option value="'.$k.'">'.$k.'</option>';
						}
					echo'
					</select>
				</td>
			</tr>
			<tr>
			<td>Begintijd</td>
				<td>
					<select id="tijd1" name="begintijd">
					';
					//for loop voor het dynamisch genereren van een drop down select list voor de tijd, waarin de eerder gekozen tijd als default wordt geselecteerd
					//tijd kan tot een precisie van 15 minuten worden gekozen
					$begintijd = $_SESSION["tijdelijke_evenementwaardes"]["begintijd"];
					for($uur=00; $uur<=23; $uur++)
					{
					for($counter=1; $counter<=4; $counter++)
						{
							if($counter==1) $minuut="00";
							elseif($counter==2) $minuut="15";
							elseif($counter==3) $minuut="30";
							elseif($counter==4) $minuut="45";
							
							if($uur<10) $uurs="0".$uur;
							else $uurs=$uur;
							
							if($uurs.':'.$minuut == $begintijd) echo'<option value="'.$uurs.':'.$minuut.'" selected="selected">'.$uurs.':'.$minuut.'</option>';
							else echo'<option value="'.$uurs.':'.$minuut.'">'.$uurs.':'.$minuut.'</option>';
						}
					}
					
					
					echo'
					</select>
				</td>
			</tr>
			<tr>
			<td>Einddatum</td>
				<td>
					<select id="datum2" name="datum2">
					';
						//for loop voor het dynamisch genereren van een drop down select list voor de data, waarin de eerder gekozen datum als default wordt geselecteerd
						$datum2 = $_SESSION["tijdelijke_evenementwaardes"]["datum2"];
						for($i=1; $i<=31; $i++)
						{
							if($i == $datum2) echo'<option value="'.$i.'" selected="selected">'.$i.'</option>';
							else echo'<option value="'.$j.'">'.$i.'</option>';
						}
					echo'
					</select>
					<select name="maand2">
					'; 
					//for loop voor het dynamisch genereren van een drop down select list voor de maand, waarin de eerder gekozen maand als default wordt geselecteerd
					$maand = $_SESSION["tijdelijke_evenementwaardes"]["maand2"];
						for($j=1; $j<=12; $j++)
						{
							if($j == $maand) echo'<option value="'.$j.'" selected="selected">'.$arraymonth[$j].'</option>';
							else echo'<option value="'.$j.'">'.$arraymonth[$j].'</option>';
						}
					echo'
					</select>
					<select name="jaar2">
					';
					//for loop voor het dynamisch genereren van een drop down select list voor het jaar, waarin het eerder gekozen jaar als default wordt geselecteerd
					$jaar = $_SESSION["tijdelijke_evenementwaardes"]["jaar2"];
						for($k=2012; $k<=2022; $k++)
						{
							if($k == $jaar) echo'<option value="'.$k.'" selected="selected">'.$k.'</option>';
							else echo'<option value="'.$k.'">'.$k. '</option>';
						}
					echo'
					</select>
				</td>
			</tr>
			<tr>
			<td>Eindtijd</td>
				<td>
					<select id="tijd2" name="eindtijd">
					';
					//for loop voor het dynamisch genereren van een drop down select list voor de tijd, waarin de eerder gekozen tijd als default wordt geselecteerd
					//tijd kan tot een precisie van 15 minuten worden gekozen
					$eindtijd = $_SESSION["tijdelijke_evenementwaardes"]["eindtijd"];
					
					for($uur=00; $uur<=23; $uur++)
					{
					for($counter=1; $counter<=4; $counter++)
						{
							if($counter==1) $minuut="00";
							elseif($counter==2) $minuut="15";
							elseif($counter==3) $minuut="30";
							elseif($counter==4) $minuut="45";
							
							if($uur<10) $uurs="0".$uur;
							else $uurs=$uur;
							
							if($uurs.':'.$minuut == $eindtijd) echo'<option value="'.$uurs.':'.$minuut.'" selected="selected">'.$uurs.':'.$minuut.'</option>';
							else echo'<option value="'.$uurs.':'.$minuut.'">'.$uurs.':'.$minuut.'</option>';
						}
					}
					echo'
					</select>
				</td>
			</tr>
			<tr>
				<td>
					Locatie
				</td>
				<td>
					<input id="locatie" type="text" name="locatie" value="'.$_SESSION["tijdelijke_evenementwaardes"]["locatie"].'" />
				</td>
			</tr>
			<tr>
			<td rowspan="4">Categorie</td>
				<td>
					<input type="checkbox" value="klant" name="categorie[]"'; 
						//if statement kijkt of klant al was aangevinkt, zo ja "check" hem, anders niet
						if(in_array("klant", $_SESSION["tijdelijke_evenementwaardes"]["categorie"]))echo'checked="checked"';
							echo'
					/>Klant
				</td>
			</tr>
			<tr>
				<td>
					<input type="checkbox" value="keuken" name="categorie[]"';  
						//if statement kijkt of keuken al was aangevinkt, zo ja "check" hem, anders niet
						if(in_array("keuken", $_SESSION["tijdelijke_evenementwaardes"]["categorie"]))echo'checked="checked"';
							echo'
					/>Keuken
				</td>
			</tr>
			<tr>
				<td>
					<input type="checkbox" value="afwas" name="categorie[]"';  
						//if statement kijkt of afwassers al was aangevinkt, zo ja "check" hem, anders niet
						if(in_array("afwas", $_SESSION["tijdelijke_evenementwaardes"]["categorie"]))echo'checked="checked"';
							echo'
					/>Afwassers
				</td>
			</tr>
			<tr>
				<td>
					<input type="checkbox" value="bar" name="categorie[]"';  
						//if statement kijkt of bar al was aangevinkt, zo ja "check" hem, anders niet
						if(in_array("bar", $_SESSION["tijdelijke_evenementwaardes"]["categorie"]))echo'checked="checked"';
							echo'
					/>Barpersoneel
				</td>
			</tr>
			<tr>
				<td>&nbsp</td>
				<td class="submit_button">
					<button type="submit" class="button" id="event_aanmaken">
						<span class="right">
							<span class="inner">
								Maak evenement aan
							</span>
						</span>
					</button>
				</td>
			</tr>
	</tbody>
	</table></form></div>
	';
	//leeg de tijdelijk bewaarde evenementwaardes, deze zijn ingevuld en daarom niet meer nodig
	unset($_SESSION["tijdelijke_evenementwaardes"]);
}//einde case 1


//standaard case. gebruiker wil een nieuw evenement aanmaken, alle opties staan nog open
elseif(Functions::auth("submit_event")) 
{
	
	//form, informatie van het evenement wordt naar link bij action gestuurd via post methode
	echo'
	<p>Voeg hier een evenement toe, zorg ervoor dat alle velden worden ingevuld</p>
	<div class="form">
	<form id="input" action="http://websec.science.uva.nl/webdb1235/index.php?page=evenement&amp;semipage=toevoeg_evenement" method="post">
	<table class="formtable" id="event_toevoegen">
	<tbody>
		<tr>
			<td id="eerstecel">Titel</td>
			<td><input id="titel" type="text" name="titel" /></td>
		</tr>
		<tr id="omschrijving">
			<td>Omschrijving</td>
			<td><textarea name="omschrijving" rows="5" cols=""></textarea></td>
		</tr>
		<tr>
			<td>Begindatum</td>
			<td>
				<select id="datum1" name="datum1">
				';
				//for loop, geeft een dropdown list met de data 1t/m31
				for($i=1; $i<=31; $i++)
					{
						echo'<option value="'.$i.'">'.$i.'</option>';
					}
				echo'
				</select>
				<select name="maand1">
				'; 
				//for loop geeft een drop down list met alle maanden, values 1t/m12 namen worden uit de array $arramonth gehaald
				for($j=1; $j<=12; $j++)
				{
					echo'<option value="'.$j.'">'.$arraymonth[$j].'</option>';
				}
				echo'
				</select>
				<select name="jaar1">
				';
				//for loop geeft de jaren, 10 jaar vooruit
				for($k=2012; $k<=2022; $k++)
				{
					echo'<option value="'.$k.'">'.$k. '</option>';
				}
				echo'
				</select>
			</td>
		</tr>
		<tr>
			<td>Begintijd</td>
	
			<td>
				<select id="tijd1" name="begintijd">
				';
				//for loop die de tijden geeft
				//tijd kan met een precisie tot 15 minuten worden opgegeven
				for($uur=00; $uur<=23; $uur++)
				{
				for($counter=1; $counter<=4; $counter++)
					{
						if($counter==1) $minuut="00";
						elseif($counter==2) $minuut="15";
						elseif($counter==3) $minuut="30";
						elseif($counter==4) $minuut="45";
						
						if($uur<10) $uurs="0".$uur;
						else $uurs=$uur;
						
						echo'<option value="'.$uurs.':'.$minuut.'">'.$uurs.':'.$minuut.'</option>';
					}
				}
				echo'
				</select>
			</td>
		</tr>
		<tr>
			<td>Einddatum</td>
			<td>
				<select id="datum2" name="datum2">
				';
				//for loop geeft dropdown list met de data 1t/m31
				for($i=1; $i<=31; $i++)
					{
						echo'<option value="'.$i.'">'.$i.'</option>';
					}
				echo'
				</select>
				<select name="maand2">
				'; 
				//for loop geeft dropdown list met de maand value 1t/m12 naam komt uit $arraymonth[]
				for($j=1; $j<=12; $j++)
				{
					echo'<option value="'.$j.'">'.$arraymonth[$j].'</option>';
				}
				echo'
				</select>
				<select name="jaar2">
				';
				//for loop geeft dropdown list met jaar 10 vooruit
				for($k=2012; $k<=2022; $k++)
				{
					echo'<option value="'.$k.'">'.$k. '</option>';
				}
				echo'
				</select>
			</td>
		</tr>
		<tr>
			<td>Eindtijd</td>
			<td>
				<select id="tijd2" name="eindtijd">
				';
				//for loop geeft dropdown list met de tijden
				//tijd kan tot op 15 minuten worden opgegeven
				for($uur=00; $uur<=23; $uur++)
				{
				for($counter=1; $counter<=4; $counter++)
					{
						if($counter==1) $minuut="00";
						elseif($counter==2) $minuut="15";
						elseif($counter==3) $minuut="30";
						elseif($counter==4) $minuut="45";
						
						if($uur<10) $uurs="0".$uur;
						else $uurs=$uur;
						
						echo'<option value="'.$uurs.':'.$minuut.'">'.$uurs.':'.$minuut.'</option>';
					}
				}
				echo'
				</select>
			</td>
		</tr>
		<tr>
			<td>
			Locatie
			</td>
			<td>
			<input id="locatie" type="text" name="locatie" />
			</td>
		</tr>
		<tr>
			<td rowspan="4">Categorie</td>
			<td>
				<input type="checkbox" value="klant" name="categorie[]" />Klant
			</td>
		</tr>
		<tr>
			<td>
				<input type="checkbox" value="keuken" name="categorie[]" />Keuken
			</td>
		</tr>
		<tr>
			<td>
				<input type="checkbox" value="afwas" name="categorie[]" />Afwassers
			</td>
		</tr>
		<tr>
			<td>
				<input type="checkbox" value="bar" name="categorie[]" />Barpersoneel
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="submit_button">
			<button type="submit" class="button" id="event_aanmaken">
				<span class="right">
					<span class="inner">
						Maak evenement aan
					</span>
				</span>
			</button>
			</td>
		</tr>
	</tbody>
	</table></form></div>';
}
//niet ingelogd case, als de pagina wordt gepoogd te bereieken zonder dat de client rechten heeft
else
{
	echo '<h1>Verboden toegang!</h1>
    <p>U heeft niet de benodigde rechten om deze pagina te bezoeken.<br />
    Log in of neem contact op met de administrator!</p>';
}
?>
