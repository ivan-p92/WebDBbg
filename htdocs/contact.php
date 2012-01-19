<h1>Contact</h1>
<p>Heeft u vragen of opmerkingen, dan horen wij dat graag. <br />
Laat een bericht bij ons achter en wij nemen zo spoedig mogelijk contact met u op.</p>

<form action="index.php?page=contact_dank&semipage=contact" method="post">
	<table class="formtable" id="contact"><tbody>
	<tr>
		<td id="eerstecel">Naam</td>
		<td><input required="required" placeholder="Typ hier uw naam" name="contact_naam" /></td>
	</tr><tr>
		<td>Email</td>
		<td><input required="required" placeholder="Typ hier uw e-mail adres" name="contact_mail" /></td>
	</tr><tr>
		<td>Bericht</td>
		<td><textarea required="required" placeholder="Typ hier uw bericht" rows="10" cols="10" name="contact_message"></textarea></td>
	</tr><tr>
		<td>&nbsp</td>
		<td><span class="submit_button" id="submit_contact">
			<button type="submit" class="button">
				<span class="right">
				<span class="inner">Verstuur bericht</span></span>
			</button></span>
		</td>
	</tr>
	</tbody></table>
</form>
