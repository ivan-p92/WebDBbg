<h1>Evenement toevoegen</h1>

<?php
if(Functions::auth("submit_event") && in_array("tijdelijke_evenementwaardes",$_SESSION)) 
{
	echo'
	<p>DEBUG Voeg hier een evenement toe, zorg ervoor dat alle velden worden ingevuld</p>
	<div class="form"><form id="input" action="http://websec.science.uva.nl/webdb1235/index.php?page=evenement&amp;semipage=toevoeg_evenement" method="post">
	<table class="formtable" id="event_toevoegen">
		<tbody>
		<tr>
			<td id="eerstecel">Titel</td>
			<td><input id="titel" type="text" name="titel" />'.$_SESSION["tijdelijke_evenementwaardes"]["titel"].'</td>
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
	<option value="01">januari</option>
	<option value="02">februari</option>
	<option value="03">maart</option>
	<option value="04">april</option>
	<option value="05">mei</option>
	<option value="06">juni</option>
	<option value="07">juli</option>
	<option value="08">augustus</option>
	<option value="09">september</option>
	<option value="10">oktober</option>
	<option value="11">november</option>
	<option value="12">december</option>
	</select>
	<select name="jaar1">
	<option value="2012">2012</option>
	<option value="2013">2013</option>
	<option value="2014">2014</option>
	<option value="2015">2015</option>
	<option value="2016">2016</option>
	</select></td>
		</tr>
		<tr>
			<td>Begintijd</td>
			<td><select id="tijd1" name="begintijd">
	<option value="00:00">00:00</option>
	<option value="00:15">00:15</option>
	<option value="00:30">00:30</option>
	<option value="00:45">00:45</option>
	<option value="01:00">01:00</option>
	<option value="01:15">01:15</option>
	<option value="01:30">01:30</option>
	<option value="01:45">01:45</option>
	<option value="02:00">02:00</option>
	<option value="02:15">02:15</option>
	<option value="02:30">02:30</option>
	<option value="02:45">02:45</option>
	<option value="03:00">03:00</option>
	<option value="03:15">03:15</option>
	<option value="03:30">03:30</option>
	<option value="03:45">03:45</option>
	<option value="04:00">04:00</option>
	<option value="04:15">04:15</option>
	<option value="04:30">04:30</option>
	<option value="04:45">04:45</option>
	<option value="05:00">05:00</option>
	<option value="05:15">05:15</option>
	<option value="05:30">05:30</option>
	<option value="05:45">05:45</option>
	<option value="06:00">06:00</option>
	<option value="06:15">06:15</option>
	<option value="06:30">06:30</option>
	<option value="06:45">06:45</option>
	<option value="07:00">07:00</option>
	<option value="07:15">07:15</option>
	<option value="07:30">07:30</option>
	<option value="07:45">07:45</option>
	<option value="08:00">08:00</option>
	<option value="08:15">08:15</option>
	<option value="08:30">08:30</option>
	<option value="08:45">08:45</option>
	<option value="09:00">09:00</option>
	<option value="09:15">09:15</option>
	<option value="09:30">09:30</option>
	<option value="09:45">09:45</option>
	<option value="10:00">10:00</option>
	<option value="10:15">10:15</option>
	<option value="10:30">10:30</option>
	<option value="10:45">10:45</option>
	<option value="11:00">11:00</option>
	<option value="11:15">11:15</option>
	<option value="11:30">11:30</option>
	<option value="11:45">11:45</option>
	<option value="12:00">12:00</option>
	<option value="12:15">12:15</option>
	<option value="12:30">12:30</option>
	<option value="12:45">12:45</option>
	<option value="13:00">13:00</option>
	<option value="13:15">13:15</option>
	<option value="13:30">13:30</option>
	<option value="13:45">13:45</option>
	<option value="14:00">14:00</option>
	<option value="14:15">14:15</option>
	<option value="14:30">14:30</option>
	<option value="14:45">14:45</option>
	<option value="15:00">15:00</option>
	<option value="15:15">15:15</option>
	<option value="15:30">15:30</option>
	<option value="15:45">15:45</option>
	<option value="16:00">16:00</option>
	<option value="16:15">16:15</option>
	<option value="16:30">16:30</option>
	<option value="16:45">16:45</option>
	<option value="17:00">17:00</option>
	<option value="17:15">17:15</option>
	<option value="17:30">17:30</option>
	<option value="17:45">17:45</option>
	<option value="18:00">18:00</option>
	<option value="18:15">18:15</option>
	<option value="18:30">18:30</option>
	<option value="18:45">18:45</option>
	<option value="19:00">19:00</option>
	<option value="19:15">19:15</option>
	<option value="19:30">19:30</option>
	<option value="19:45">19:45</option>
	<option value="20:00">20:00</option>
	<option value="20:15">20:15</option>
	<option value="20:30">20:30</option>
	<option value="20:45">20:45</option>
	<option value="21:00">21:00</option>
	<option value="21:15">21:15</option>
	<option value="21:30">21:30</option>
	<option value="21:45">21:45</option>
	<option value="22:00">22:00</option>
	<option value="22:15">22:15</option>
	<option value="22:30">22:30</option>
	<option value="22:45">22:45</option>
	<option value="23:00">23:00</option>
	<option value="23:15">23:15</option>
	<option value="23:30">23:30</option>
	<option value="23:45">23:45</option>
	</select></td>
		</tr>
		<tr>
			<td>Einddatum</td>
			<td><select id="datum2" name="datum2">
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	<option value="13">13</option>
	<option value="14">14</option>
	<option value="15">15</option>
	<option value="16">16</option>
	<option value="17">17</option>
	<option value="18">18</option>
	<option value="19">19</option>
	<option value="20">20</option>
	<option value="21">21</option>
	<option value="22">22</option>
	<option value="23">23</option>
	<option value="24">24</option>
	<option value="25">25</option>
	<option value="26">26</option>
	<option value="27">27</option>
	<option value="28">28</option>
	<option value="29">29</option>
	<option value="30">30</option>
	<option value="31">31</option>
	</select>
	<select name="maand2">
	<option value="01">januari</option>
	<option value="02">februari</option>
	<option value="03">maart</option>
	<option value="04">april</option>
	<option value="05">mei</option>
	<option value="06">juni</option>
	<option value="07">juli</option>
	<option value="08">augustus</option>
	<option value="09">september</option>
	<option value="10">oktober</option>
	<option value="11">november</option>
	<option value="12">december</option>
	</select>
	<select name="jaar2">
	<option value="2012">2012</option>
	<option value="2013">2013</option>
	<option value="2014">2014</option>
	<option value="2015">2015</option>
	<option value="2016">2016</option>
	</select></td>
		</tr>
		<tr>
			<td>Eindtijd</td>
			<td><select id="tijd2" name="eindtijd">
	<option value="00:00">00:00</option>
	<option value="00:15">00:15</option>
	<option value="00:30">00:30</option>
	<option value="00:45">00:45</option>
	<option value="01:00">01:00</option>
	<option value="01:15">01:15</option>
	<option value="01:30">01:30</option>
	<option value="01:45">01:45</option>
	<option value="02:00">02:00</option>
	<option value="02:15">02:15</option>
	<option value="02:30">02:30</option>
	<option value="02:45">02:45</option>
	<option value="03:00">03:00</option>
	<option value="03:15">03:15</option>
	<option value="03:30">03:30</option>
	<option value="03:45">03:45</option>
	<option value="04:00">04:00</option>
	<option value="04:15">04:15</option>
	<option value="04:30">04:30</option>
	<option value="04:45">04:45</option>
	<option value="05:00">05:00</option>
	<option value="05:15">05:15</option>
	<option value="05:30">05:30</option>
	<option value="05:45">05:45</option>
	<option value="06:00">06:00</option>
	<option value="06:15">06:15</option>
	<option value="06:30">06:30</option>
	<option value="06:45">06:45</option>
	<option value="07:00">07:00</option>
	<option value="07:15">07:15</option>
	<option value="07:30">07:30</option>
	<option value="07:45">07:45</option>
	<option value="08:00">08:00</option>
	<option value="08:15">08:15</option>
	<option value="08:30">08:30</option>
	<option value="08:45">08:45</option>
	<option value="09:00">09:00</option>
	<option value="09:15">09:15</option>
	<option value="09:30">09:30</option>
	<option value="09:45">09:45</option>
	<option value="10:00">10:00</option>
	<option value="10:15">10:15</option>
	<option value="10:30">10:30</option>
	<option value="10:45">10:45</option>
	<option value="11:00">11:00</option>
	<option value="11:15">11:15</option>
	<option value="11:30">11:30</option>
	<option value="11:45">11:45</option>
	<option value="12:00">12:00</option>
	<option value="12:15">12:15</option>
	<option value="12:30">12:30</option>
	<option value="12:45">12:45</option>
	<option value="13:00">13:00</option>
	<option value="13:15">13:15</option>
	<option value="13:30">13:30</option>
	<option value="13:45">13:45</option>
	<option value="14:00">14:00</option>
	<option value="14:15">14:15</option>
	<option value="14:30">14:30</option>
	<option value="14:45">14:45</option>
	<option value="15:00">15:00</option>
	<option value="15:15">15:15</option>
	<option value="15:30">15:30</option>
	<option value="15:45">15:45</option>
	<option value="16:00">16:00</option>
	<option value="16:15">16:15</option>
	<option value="16:30">16:30</option>
	<option value="16:45">16:45</option>
	<option value="17:00">17:00</option>
	<option value="17:15">17:15</option>
	<option value="17:30">17:30</option>
	<option value="17:45">17:45</option>
	<option value="18:00">18:00</option>
	<option value="18:15">18:15</option>
	<option value="18:30">18:30</option>
	<option value="18:45">18:45</option>
	<option value="19:00">19:00</option>
	<option value="19:15">19:15</option>
	<option value="19:30">19:30</option>
	<option value="19:45">19:45</option>
	<option value="20:00">20:00</option>
	<option value="20:15">20:15</option>
	<option value="20:30">20:30</option>
	<option value="20:45">20:45</option>
	<option value="21:00">21:00</option>
	<option value="21:15">21:15</option>
	<option value="21:30">21:30</option>
	<option value="21:45">21:45</option>
	<option value="22:00">22:00</option>
	<option value="22:15">22:15</option>
	<option value="22:30">22:30</option>
	<option value="22:45">22:45</option>
	<option value="23:00">23:00</option>
	<option value="23:15">23:15</option>
	<option value="23:30">23:30</option>
	<option value="23:45">23:45</option>
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
';
}
elseif(Functions::auth("submit_event")) 
{
	echo <<<EOT
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
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	<option value="13">13</option>
	<option value="14">14</option>
	<option value="15">15</option>
	<option value="16">16</option>
	<option value="17">17</option>
	<option value="18">18</option>
	<option value="19">19</option>
	<option value="20">20</option>
	<option value="21">21</option>
	<option value="22">22</option>
	<option value="23">23</option>
	<option value="24">24</option>
	<option value="25">25</option>
	<option value="26">26</option>
	<option value="27">27</option>
	<option value="28">28</option>
	<option value="29">29</option>
	<option value="30">30</option>
	<option value="31">31</option>
	</select>
	<select name="maand1">
	<option value="01">januari</option>
	<option value="02">februari</option>
	<option value="03">maart</option>
	<option value="04">april</option>
	<option value="05">mei</option>
	<option value="06">juni</option>
	<option value="07">juli</option>
	<option value="08">augustus</option>
	<option value="09">september</option>
	<option value="10">oktober</option>
	<option value="11">november</option>
	<option value="12">december</option>
	</select>
	<select name="jaar1">
	<option value="2012">2012</option>
	<option value="2013">2013</option>
	<option value="2014">2014</option>
	<option value="2015">2015</option>
	<option value="2016">2016</option>
	</select></td>
		</tr>
		<tr>
			<td>Begintijd</td>
			<td><select id="tijd1" name="begintijd">
	<option value="00:00">00:00</option>
	<option value="00:15">00:15</option>
	<option value="00:30">00:30</option>
	<option value="00:45">00:45</option>
	<option value="01:00">01:00</option>
	<option value="01:15">01:15</option>
	<option value="01:30">01:30</option>
	<option value="01:45">01:45</option>
	<option value="02:00">02:00</option>
	<option value="02:15">02:15</option>
	<option value="02:30">02:30</option>
	<option value="02:45">02:45</option>
	<option value="03:00">03:00</option>
	<option value="03:15">03:15</option>
	<option value="03:30">03:30</option>
	<option value="03:45">03:45</option>
	<option value="04:00">04:00</option>
	<option value="04:15">04:15</option>
	<option value="04:30">04:30</option>
	<option value="04:45">04:45</option>
	<option value="05:00">05:00</option>
	<option value="05:15">05:15</option>
	<option value="05:30">05:30</option>
	<option value="05:45">05:45</option>
	<option value="06:00">06:00</option>
	<option value="06:15">06:15</option>
	<option value="06:30">06:30</option>
	<option value="06:45">06:45</option>
	<option value="07:00">07:00</option>
	<option value="07:15">07:15</option>
	<option value="07:30">07:30</option>
	<option value="07:45">07:45</option>
	<option value="08:00">08:00</option>
	<option value="08:15">08:15</option>
	<option value="08:30">08:30</option>
	<option value="08:45">08:45</option>
	<option value="09:00">09:00</option>
	<option value="09:15">09:15</option>
	<option value="09:30">09:30</option>
	<option value="09:45">09:45</option>
	<option value="10:00">10:00</option>
	<option value="10:15">10:15</option>
	<option value="10:30">10:30</option>
	<option value="10:45">10:45</option>
	<option value="11:00">11:00</option>
	<option value="11:15">11:15</option>
	<option value="11:30">11:30</option>
	<option value="11:45">11:45</option>
	<option value="12:00">12:00</option>
	<option value="12:15">12:15</option>
	<option value="12:30">12:30</option>
	<option value="12:45">12:45</option>
	<option value="13:00">13:00</option>
	<option value="13:15">13:15</option>
	<option value="13:30">13:30</option>
	<option value="13:45">13:45</option>
	<option value="14:00">14:00</option>
	<option value="14:15">14:15</option>
	<option value="14:30">14:30</option>
	<option value="14:45">14:45</option>
	<option value="15:00">15:00</option>
	<option value="15:15">15:15</option>
	<option value="15:30">15:30</option>
	<option value="15:45">15:45</option>
	<option value="16:00">16:00</option>
	<option value="16:15">16:15</option>
	<option value="16:30">16:30</option>
	<option value="16:45">16:45</option>
	<option value="17:00">17:00</option>
	<option value="17:15">17:15</option>
	<option value="17:30">17:30</option>
	<option value="17:45">17:45</option>
	<option value="18:00">18:00</option>
	<option value="18:15">18:15</option>
	<option value="18:30">18:30</option>
	<option value="18:45">18:45</option>
	<option value="19:00">19:00</option>
	<option value="19:15">19:15</option>
	<option value="19:30">19:30</option>
	<option value="19:45">19:45</option>
	<option value="20:00">20:00</option>
	<option value="20:15">20:15</option>
	<option value="20:30">20:30</option>
	<option value="20:45">20:45</option>
	<option value="21:00">21:00</option>
	<option value="21:15">21:15</option>
	<option value="21:30">21:30</option>
	<option value="21:45">21:45</option>
	<option value="22:00">22:00</option>
	<option value="22:15">22:15</option>
	<option value="22:30">22:30</option>
	<option value="22:45">22:45</option>
	<option value="23:00">23:00</option>
	<option value="23:15">23:15</option>
	<option value="23:30">23:30</option>
	<option value="23:45">23:45</option>
	</select></td>
		</tr>
		<tr>
			<td>Einddatum</td>
			<td><select id="datum2" name="datum2">
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	<option value="13">13</option>
	<option value="14">14</option>
	<option value="15">15</option>
	<option value="16">16</option>
	<option value="17">17</option>
	<option value="18">18</option>
	<option value="19">19</option>
	<option value="20">20</option>
	<option value="21">21</option>
	<option value="22">22</option>
	<option value="23">23</option>
	<option value="24">24</option>
	<option value="25">25</option>
	<option value="26">26</option>
	<option value="27">27</option>
	<option value="28">28</option>
	<option value="29">29</option>
	<option value="30">30</option>
	<option value="31">31</option>
	</select>
	<select name="maand2">
	<option value="01">januari</option>
	<option value="02">februari</option>
	<option value="03">maart</option>
	<option value="04">april</option>
	<option value="05">mei</option>
	<option value="06">juni</option>
	<option value="07">juli</option>
	<option value="08">augustus</option>
	<option value="09">september</option>
	<option value="10">oktober</option>
	<option value="11">november</option>
	<option value="12">december</option>
	</select>
	<select name="jaar2">
	<option value="2012">2012</option>
	<option value="2013">2013</option>
	<option value="2014">2014</option>
	<option value="2015">2015</option>
	<option value="2016">2016</option>
	</select></td>
		</tr>
		<tr>
			<td>Eindtijd</td>
			<td><select id="tijd2" name="eindtijd">
	<option value="00:00">00:00</option>
	<option value="00:15">00:15</option>
	<option value="00:30">00:30</option>
	<option value="00:45">00:45</option>
	<option value="01:00">01:00</option>
	<option value="01:15">01:15</option>
	<option value="01:30">01:30</option>
	<option value="01:45">01:45</option>
	<option value="02:00">02:00</option>
	<option value="02:15">02:15</option>
	<option value="02:30">02:30</option>
	<option value="02:45">02:45</option>
	<option value="03:00">03:00</option>
	<option value="03:15">03:15</option>
	<option value="03:30">03:30</option>
	<option value="03:45">03:45</option>
	<option value="04:00">04:00</option>
	<option value="04:15">04:15</option>
	<option value="04:30">04:30</option>
	<option value="04:45">04:45</option>
	<option value="05:00">05:00</option>
	<option value="05:15">05:15</option>
	<option value="05:30">05:30</option>
	<option value="05:45">05:45</option>
	<option value="06:00">06:00</option>
	<option value="06:15">06:15</option>
	<option value="06:30">06:30</option>
	<option value="06:45">06:45</option>
	<option value="07:00">07:00</option>
	<option value="07:15">07:15</option>
	<option value="07:30">07:30</option>
	<option value="07:45">07:45</option>
	<option value="08:00">08:00</option>
	<option value="08:15">08:15</option>
	<option value="08:30">08:30</option>
	<option value="08:45">08:45</option>
	<option value="09:00">09:00</option>
	<option value="09:15">09:15</option>
	<option value="09:30">09:30</option>
	<option value="09:45">09:45</option>
	<option value="10:00">10:00</option>
	<option value="10:15">10:15</option>
	<option value="10:30">10:30</option>
	<option value="10:45">10:45</option>
	<option value="11:00">11:00</option>
	<option value="11:15">11:15</option>
	<option value="11:30">11:30</option>
	<option value="11:45">11:45</option>
	<option value="12:00">12:00</option>
	<option value="12:15">12:15</option>
	<option value="12:30">12:30</option>
	<option value="12:45">12:45</option>
	<option value="13:00">13:00</option>
	<option value="13:15">13:15</option>
	<option value="13:30">13:30</option>
	<option value="13:45">13:45</option>
	<option value="14:00">14:00</option>
	<option value="14:15">14:15</option>
	<option value="14:30">14:30</option>
	<option value="14:45">14:45</option>
	<option value="15:00">15:00</option>
	<option value="15:15">15:15</option>
	<option value="15:30">15:30</option>
	<option value="15:45">15:45</option>
	<option value="16:00">16:00</option>
	<option value="16:15">16:15</option>
	<option value="16:30">16:30</option>
	<option value="16:45">16:45</option>
	<option value="17:00">17:00</option>
	<option value="17:15">17:15</option>
	<option value="17:30">17:30</option>
	<option value="17:45">17:45</option>
	<option value="18:00">18:00</option>
	<option value="18:15">18:15</option>
	<option value="18:30">18:30</option>
	<option value="18:45">18:45</option>
	<option value="19:00">19:00</option>
	<option value="19:15">19:15</option>
	<option value="19:30">19:30</option>
	<option value="19:45">19:45</option>
	<option value="20:00">20:00</option>
	<option value="20:15">20:15</option>
	<option value="20:30">20:30</option>
	<option value="20:45">20:45</option>
	<option value="21:00">21:00</option>
	<option value="21:15">21:15</option>
	<option value="21:30">21:30</option>
	<option value="21:45">21:45</option>
	<option value="22:00">22:00</option>
	<option value="22:15">22:15</option>
	<option value="22:30">22:30</option>
	<option value="22:45">22:45</option>
	<option value="23:00">23:00</option>
	<option value="23:15">23:15</option>
	<option value="23:30">23:30</option>
	<option value="23:45">23:45</option>
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
