<h1>Account informatie</h1>

<p> Op deze pagina vindt u informatie over uw account. <br />
    U kunt in het onderstaande formulier ook uw wachtwoord wijzigen.</p>

<p>Accountnaam (email): Het betreffende email-adres<br />
   Huidige permissies: Evenementen toevoegen/goedkeuren/admin</p>

<p>Deze evenementen zijn door u aangemaakt:</p>
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

<form id="wijzigww" action="" method="get">
<table id="wijzigww_tabel">
<tbody>
	<tr>
	<td>Oud wachtwoord: </td><td><input type="password" id="oldpswd" name="mail" required="" /></td>
	</tr>
	<tr>
	<td>Nieuw wachtwoord: </td><td><input type="password" id="newpswd" name="pswd" required="" /></td>
	</tr>
	<tr>
	<td>Wachtwoord nogmaals: </td><td><input type="password" id="newpswd2" name="pswd2" required="" /></td>
	</tr>
	<tr>
	<td>&nbsp;</td>
`	<td class="submit_button" id="wijzigww_buttons">
		<button type="submit" class="button"><span class="right"><span class="inner">Wachtwoord opslaan</span></span></button><br />
		<button type="reset" class="button"><span class="right"><span class="inner">Velden wissen</span></span></button>
	</td>
	</tr>
</tbody>
</table>
</form>
