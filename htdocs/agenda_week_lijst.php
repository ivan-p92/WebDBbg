<!-- div#weeklijst container bevat de lijst van de evenementen 
     De hoofdstructuur ervan is een unordered list -->
<div id="event_lijst_container">
	<h1 id="event_lijst_titel">Aankomende evenementen</h1>
	<ul class="event_lijst">

		<!-- Elk list item is een evenement -->
		<li class="event">
			<p class="eendags_event">
				<span class="begin_datum">
					<span class="jaar">2012</span>
					<span class="dd-mm">16<br />JAN</span>
				</span>
			</p>
			<div class="event_details">
				<p class="event_titel">
					<a class="event_link" href="index.php?page=evenement&amp;semipage=agenda_week">Titel van het event</a>
				</p>
				<p class="begintijd">11:00u - 19:00u</p>
			</div>
		</li>

		<li class="event">
			<p class="eendags_event">
				<span class="begin_datum">
					<span class="jaar">2012</span>
					<span class="dd-mm">18 JAN<br />19 JAN</span>
				</span>
			</p>
			<div class="event_details">
				<p class="event_titel">
					<a class="event_link" href="index.php?page=evenement&amp;semipage=agenda_week">Titel van het event</a>
				</p>
				<p class="begintijd">12:00u - 3:00u</p>
			</div>
		</li>
	</ul>
</div>