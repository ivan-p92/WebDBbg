<h1>Evenement toevoegen</h1>

<?php
$arraymonth = array("bla", "januari", "februari", "maart", "april", "mei", "juni", "juli", "augustus", "september", "oktober", "november", "december");

if(Functions::auth("submit_event") && isset($_SESSION["tijdelijke_evenementwaardes"])) 
{
	echo'
	<p>Voeg hier een evenement toe, zorg ervoor dat alle velden worden ingevuld</p>
	<div class="form"><form id="input" action="http://websec.science.uva.nl/webdb1235/index.php?page=evenement&amp;semipage=toevoeg_evenement" method="post">
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
			<td><select id="datum1" name="datum1">
	';
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
	$maand = $_SESSION["tijdelijke_evenementwaardes"]["maand1"];
		for($j=1; $j<=31; $j++)
		{
			if($j == $maand) echo'<option value="'.$j.'" selected="selected">'.$arraymonth[$j].'</option>';
			else echo'<option value="'.$i.'">'.$arraymonth[$j].'</option>';
		}
	echo'
	</select>
	<select name="jaar1">
	';
	$jaar = $_SESSION["tijdelijke_evenementwaardes"]["jaar1"];
		for($k=2012; $k<=2022; $k++)
		{
			if($k == $jaar) echo'<option value="'.$k.'" selected="selected">'.$k.'</option>';
			else echo'<option value="'.$k.'">'.$k.'</option>';
		}
	echo'
	</select></td>
		</tr>
		<tr>
			<td>Begintijd</td>
			<td><select id="tijd1" name="begintijd">
	';
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
			</select></td>
		</tr>
		<tr>
			<td>Einddatum</td>
			<td><select id="datum2" name="datum2">
	';
		$datum2 = $_SESSION["tijdelijke_evenementwaardes"]["datum2"];
		for($i=1; $i<=31; $i++)
		{
			if($i == $datum2) echo'<option value="'.$i.'" selected="selected">'.$i.'</option>';
			else echo'<option value="'.$i.'">'.$i.'</option>';
		}
	echo'
	</select>
	<select name="maand2">
	'; 
	$maand = $_SESSION["tijdelijke_evenementwaardes"]["maand2"];
		for($j=1; $j<=31; $j++)
		{
			if($j == $maand) echo'<option value="'.$j.'" selected="selected">'.$arraymonth[$j].'</option>';
			else echo'<option value="'.$i.'">'.$arraymonth[$j].'</option>';
		}
	echo'
	</select>
	<select name="jaar2">
	';
	$jaar = $_SESSION["tijdelijke_evenementwaardes"]["jaar2"];
		for($k=2012; $k<=2022; $k++)
		{
			if($k == $jaar) echo'<option value="'.$k.'" selected="selected">'.$k.'</option>';
			else echo'<option value="'.$k.'">'.$k. '</option>';
		}
	echo'
	</select></td>
		</tr>
		<tr>
			<td>Eindtijd</td>
			<td><select id="tijd2" name="eindtijd">
	';
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
	</select></td>
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
			<td><input type="checkbox" value="klant" name="categorie[]"';  
				if(in_array("klant", $_SESSION["tijdelijke_evenementwaardes"]["categorie"]))echo'checked="checked"';
					echo'/>Klant</td>
		</tr>
		<tr>
			<td><input type="checkbox" value="keuken" name="categorie[]"';  
				if(in_array("keuken", $_SESSION["tijdelijke_evenementwaardes"]["categorie"]))echo'checked="checked"';
					echo'/>Keuken</td>
		</tr>
		<tr>
			<td><input type="checkbox" value="afwas" name="categorie[]"';  
				if(in_array("afwas", $_SESSION["tijdelijke_evenementwaardes"]["categorie"]))echo'checked="checked"';
					echo'/>Afwassers</td>
		</tr>
		<tr>
			<td><input type="checkbox" value="bar" name="categorie[]"';  
				if(in_array("bar", $_SESSION["tijdelijke_evenementwaardes"]["categorie"]))echo'checked="checked"';
					echo'/>Barpersoneel</td>
		</tr>
		<tr>
			<td>&nbsp</td>
			<td class="submit_button">
		<button type="submit" class="button" id="event_aanmaken">
			<span class="right">
			<span class="inner">Maak evenement aan</span></span>
	</button></td>
		</tr>
		</tbody>
	</table></form></div>
';
unset($_SESSION["tijdelijke_evenementwaardes"]);
}
elseif(Functions::auth("submit_event")) 
{
	echo'
	<p>Voeg hier een evenement toe, zorg ervoor dat alle velden worden ingevuld</p>
	<div class="form"><form id="input" action="http://websec.science.uva.nl/webdb1235/index.php?page=evenement&amp;semipage=toevoeg_evenement" method="post">
	<table class="formtable" id="event_toevoegen">
		<tbody>
		<tr>
			<td id="eerstecel">Titel</td>
			<td><input id="titel" type="text" name="titel" /></td>
		</tr>
		<tr id="omschrijving">
			<td>Omschrijving</td>
			<td><textarea name="omschrijving" rows="" cols=""></textarea></td>
		</tr>
		<tr>
			<td>Begindatum</td>
			<td><select id="datum1" name="datum1">
			';
	for($i=1; $i<=31; $i++)
		{
			echo'<option value="'.$i.'">'.$i.'</option>';
		}
	echo'
	</select>
	<select name="maand1">
	'; 
		for($j=1; $j<=31; $j++)
		{
			echo'<option value="'.$i.'">'.$arraymonth[$j].'</option>';
		}
	echo'
	</select>
	<select name="jaar1">
	';
		for($k=2012; $k<=2022; $k++)
		{
			echo'<option value="'.$k.'">'.$k. '</option>';
		}
	echo'
	</select></td>
		</tr>
		<tr>
			<td>Begintijd</td>
	
	<td><select id="tijd1" name="begintijd">
	
	';
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
	</select></td>
		</tr>
		<tr>
			<td>Einddatum</td>
			<td><select id="datum2" name="datum2">
	';
	for($i=1; $i<=31; $i++)
		{
			echo'<option value="'.$i.'">'.$i.'</option>';
		}
	echo'
	</select>
	<select name="maand2">
	'; 
		for($j=1; $j<=31; $j++)
		{
			echo'<option value="'.$i.'">'.$arraymonth[$j].'</option>';
		}
	echo'
	</select>
	<select name="jaar2">
	';
		for($k=2012; $k<=2022; $k++)
		{
			echo'<option value="'.$k.'">'.$k. '</option>';
		}
	echo'
	</select></td>
		</tr>
		<tr>
			<td>Eindtijd</td>
			<td><select id="tijd2" name="eindtijd">
	';
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
	</select></td>
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
			<td><input type="checkbox" value="klant" name="categorie[]" />Klant</td>
		</tr>
		<tr>
			<td><input type="checkbox" value="keuken" name="categorie[]" />Keuken</td>
		</tr>
		<tr>
			<td><input type="checkbox" value="afwas" name="categorie[]" />Afwassers</td>
		</tr>
		<tr>
			<td><input type="checkbox" value="bar" name="categorie[]" />Barpersoneel</td>
		</tr>
		<tr>
			<td>&nbsp</td>
			<td class="submit_button">
		<button type="submit" class="button" id="event_aanmaken">
			<span class="right">
			<span class="inner">Maak evenement aan</span></span>
	</button></td>
		</tr>
		</tbody>
	</table></form></div>
EOT;
}
else
{
	echo '<h1>Verboden toegang!</h1>
    <p>U heeft niet de benodigde rechten om deze pagina te bezoeken.<br />
    Log in of neem contact op met de administrator!</p>';
}
?>
