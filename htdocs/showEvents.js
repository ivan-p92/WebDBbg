// showEvents.js
// bevat de benodigde scripts om de weeklijst van de agenda
// dynamisch te kunnen gebruiken (agenda_week_lijst.php)
// ook wordt hier een cookie aangemaakt die de door de gebruiker
// bekeken week en jaar opslaat

// deze functie wordt aangeroepen bij het laden van de pagina
// en stelt het jaar in. YEAR is een globale variabele.
function initYear(year)
{
	YEAR = year;
	setBox2(year); // het tekstvak van het jaar wordt ingevuld
}

// deze functie wordt bij verdere manipulaties van YEAR gebruikt
// de waarde wordt op geldigheid gecontroleerd
// belangrijk verschil met initYear is dat deze functie ook initEvents
// aanroept en daarmee dus gelijk de weergegeven evenementen beïnvloedt
function setYear(year)
{
	// parseFloat en parseInt worden met elkaar vergeleken, zodat ook decimale getallen
	// gedetecteerd worden
	if(!isNaN(year) && (parseFloat(year) == parseInt(year)) && year >= 2000 && year <= 2100)
	{
		YEAR = year;
		setBox2(year); // tekstvak wordt gevuld
		initEvents(); // lijst wordt opnieuw geladen
	}
	else
	{
		setBox2("Fout!"); // foutmelding
	}
}

// deze functie stelt de waarde in van de globale WEEK variabele en stopt die ook in het tekstvak
// ook wordt de ontvangen waarde gecontroleerd en initEvents aangeroepen
// NB: de weken lopen van 0-53
function setWeek(week)
{
	if(!isNaN(week) && (parseFloat(week) == parseInt(week)) && week >= 0 && week < 54)
	{
		WEEK = parseInt(week);
		setBox(week); // tekstvak wordt gewijzigd
		
		// De titel van de pagina wordt ook aangepast: de weergegeven week wordt getoond
		document.getElementById("event_lijst_titel").innerHTML = "Aankomende evenementen - week "+week;
		initEvents(); // lijst zal opnieuw weergegeven worden
	}
	else
	{
		setBox("Fout!"); // foutmelding
	}
}

// deze functie leest de checkboxes uit en geeft het array met de aangevinkte
// categorieën door aan showEvents
function initEvents()
{
	var checkboxes = document.getElementsByClassName("catbox"); // haal checkboxes op
	var checked = new Array();
	
	for(var i = 0; i < checkboxes.length; i++)
	{
		if(checkboxes[i].checked) // als de box aangevinkt is, wordt de categorie in checked gestopt
		{
			checked.push(checkboxes[i].value);
		}
	}
	
	showEvents(checked); // showEvents wordt aangeroepen met checked als argument
}

// showEvents wordt via initEvents (zie hierboven) aangeroepen wanneer
// de weergave van agenda_week_lijst gewijzigd moet worden
// de functie ontvangt een array van initEvents met de aangevinkte categorieën
// elk list item wordt geanaliseerd en ofwel getoond of verborgen (met display
// block/none)
function showEvents(infoArray)
{	
	setCookie(); // cookie wordt aangemaakt/ververst
	var events = document.getElementsByClassName("event"); // alle list items (evenementen)
	var classesArray = new Array(); // nieuw array
	
	if (infoArray.length > 0) // als er aangevinkte categorieën zijn
	{
		// eerst wordt nog 'id_' aan de categorieën geplakt, want zo
		// zijn de categorieën 'opgeslagen' in de class properties van de
		// lijst elementen
		for (var i=0; i<infoArray.length; i++)
		{
			classesArray.push("id_"+infoArray[i]);
		}
		
		var count = 0; // teller variabele
		for (var i=0; i<events.length; i++) // alle evenementen worden nu geanaliseerd
		{
			// er wordt gekeken (met hasClass en hasClassArray) of het evenement
			// in de huidige week en jaar getoond moet worden
			// als dat het geval is krijgt het display:block als eigenschap mee
			if(hasClass(events[i], "d"+YEAR+WEEK) && hasClassArray(events[i], classesArray))
			{
				events[i].style.display = 'block';
				count++;
			}
			else // als een element niet getoond moet worden, krijgt het display:none als eigenschap
			{
				events[i].style.display = 'none';
			}
		}
		// als de teller variabele nog steeds nul is, zijn er geen evenementen die
		// getoond moeten worden en dus wordt de melding daarvan zichtbaar
		// anders wordt deze onzichtbaar
		if(count == 0) document.getElementById("no_events").style.display = "block";
		else document.getElementById("no_events").style.display = "none";
	}
	else // geen categorieën? Alle elementen verborgen
	{
		for (var i=0; i<events.length; i++)
		{
			events[i].style.display = 'none';
			// melding wordt juist getoond
			document.getElementById("no_events").style.display = 'block';
		}
	}
}

// hasClass kijkt of een element een bepaalde class heeft
// BRON: http://www.openjs.com/scripts/dom/class_manipulation.php
function hasClass(ele,cls) 
{
	return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
}

// hasClassArray is wel zelf geschreven
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

// deze functie wordt aangeroepen wanneer er in de tekstvakjes van week en jaar getypt wordt.
// er wordt alleen gehandeld als het 'enter' betreft (code 13)
function dateSubmitWithKey(keyEvent, wk) // wk true als week, anders wordt jaar ingesteld 
{
	// twee methodes, voor compatibiliteit
    if (keyEvent.keyCode) var code = keyEvent.keyCode;
	else if (keyEvent.which) var code = keyEvent.which;
	
	// alleen als 'enter' ingetoetst werd, wordt er gehandeld
	if (code == 13)
	{
		if(wk) // week instellen
		{
			var input = document.getElementById("week_box");
			setWeek(input.value); // setWeek wordt aangeroepen
		}
		else // jaar instellen
		{
			var input = document.getElementById("jaar_box");
			setYear(input.value); // setYear wordt aangeroepen
		}
	}
}

// instellen van het week tekstvak
function setBox(val)
{
	document.getElementById("week_box").value = val;
}

// instellen van het jaar tekstvak
function setBox2(val)
{
	document.getElementById("jaar_box").value = val;
}

// deze functie wordt aangeroepen door de pijlknoppen
// forward is 'true' als vooruit gebladerd wordt en 'false'
// als juist achteruit gebladerd wordt
// de functie zorgt ook voor de 'jaarwisseling'
function browseWeek(forward)
{
	if (!forward)
	{
		if(WEEK == 0) // jaarwisseling 
		{
			WEEK = 54; 
			YEAR = parseInt(YEAR - 1);
			setBox2(YEAR);
		} 
		WEEK -= 1; // één week terug
		setBox(WEEK); // week weergeven
		// heading aanpassen
		document.getElementById("event_lijst_titel").innerHTML = "Aankomende evenementen - week "+WEEK;
		
		// jaar weergeven, omdat je zeker wilt zijn dat het er altijd staat,
		// zou ook op 'fout!' kunnen staan
		setBox2(YEAR);
		initEvents(); // evenementen opnieuw weergeven/verbergen
	}
	// zelfde als hierboven, maar dan de andere kant op
	else if (forward)
	{
		if(WEEK == 53) 
		{ 
			WEEK = -1; 
			YEAR = parseInt(YEAR + 1);
			setBox2(YEAR);
		}
		WEEK += 1;
		setBox(WEEK);
		document.getElementById("event_lijst_titel").innerHTML = "Aankomende evenementen - week "+WEEK;
		setBox2(YEAR);
		initEvents();
	}
}


// implementatie voor onclick functie van de agenda list items
function goToEventA(id)
{
	window.location.replace("index.php?page=evenement&id=" + id + "&semipage=agenda_week");
} 

// deze is voor de 'keuren' pagina
function goToEventK(id)
{
	window.location.replace("index.php?page=evenement&id=" + id + "&semipage=keuren");
}

// bepaalt de huidige positie van een opgevraagd element
// Bron: http://www.quirksmode.org/js/findpos.html
function findPos(obj) 
{
	var curleft = curtop = 0;
	if (obj.offsetParent) 
	{
		do 
		{
			curleft += obj.offsetLeft;
			curtop += obj.offsetTop;
		// als obj gelijk is aan offsetParent, is het resultaat
		// van de toekenning van obj in de while conditie 'false'
		// dus stopt het op dat punt
		} while (obj = obj.offsetParent);
		
		return [curleft,curtop];
	}
}

// showDetails maakt de omschrijving van een evenement zichtbaar
// obj is het evenement, id is de id van de omschrijving
function showDetails(obj, id)
{
	// de plaats van het evenement op de pagina wordt bepaald
	var coor = findPos(obj);
	
	// evenementomschrijving wordt opgehaald
	var div = document.getElementById(id);
	// de omschrijving wordt juist gepositioneerd en zichtbaar gemaakt
	div.style.left = (coor[0] + 500)+"px";
	div.style.top = coor[1]+"px";
	div.style.display = 'block';
}

// fixOMO (fixOnMouseOut) handelt het mouseout event af en maakt de omschrijving
// van het betreffende evenement weer onzichtbaar
// de functie bevat code die ervoor zorgt dat mouseout alleen getriggered wordt
// als de muis daadwerkelijk het list item verlaten heeft. Anders wordt
// het ook getriggered als het over andere elementen binnen het list item gaat.
// BRON: http://codingrecipes.com/onmouseout-fix-on-nested-elements-javascript
// NB: het is voor eigen doeleinden ietwat aangepast
// element is het evenement waarop gehovered wordt/verlaten wordt
// id is de id van de omschrijving
// event is het muisevent
function fixOMO(element, id, event)
{
	// div is de omschrijving van het evenement
	var div = document.getElementById(id);
	var current_mouse_target = null;
	if( event.relatedTarget ) {				
		current_mouse_target = event.relatedTarget;
	} else if( event.toElement ) {				
		current_mouse_target = event.toElement;
	}
	// alleen als de list item echt verlaten is, dus niet als je je op een 
	// genest element in de list item bevindt, wordt de omschrijving onzichtbaar 
	if( !is_child_of(element, current_mouse_target) && element != current_mouse_target )
		div.style.display = 'none';
}

// deze functie wordt door fixOMO (fixOnMouseOut) aangeroepen om te kijken of 
// een bepaald element genest is in een ander element
// Bron: http://codingrecipes.com/onmouseout-fix-on-nested-elements-javascript
function is_child_of(parent, child) {
	if( child != null ) 
	{			
		while( child.parentNode ) 
		{
			if( (child = child.parentNode) == parent )
				return true;
		}
	}
	return false;
}

// hier volgen de cookie functies die de door de gebruiker gekozen
// categorieën en week/jaar opslaat

// setcookie stelt de cookie (opnieuw) in
function setCookie()
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + 1); // 1 dag houdbaar
	var name = 'sorteerWaardes'; // naam van cookie
	
	// de waarde van de cookie is week:jaar, dus week en jaar gescheiden
	// door een dubbele punt
	var c_value = ""+WEEK+":"+YEAR+"; expires="+exdate.toUTCString();
	document.cookie = name + "=" + c_value;
}

// getCookie geeft de waarde van de cookie
function getCookie(name)
{
	//nameEQ is gewoon de naam van de cookie met '=' eraan vast
	var nameEQ = name + "=";
	
	// de cookie wordt gesplitst op ';'
	var ca = document.cookie.split(';');
	// het verkregen array wordt onderzocht op de naam van de cookie
	// zodra nameEQ gevonden is, wordt de waarde van de cookie (dus
	// alles ná nameEQ.length gereturned
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

// setFromCookie stelt het huidige jaar en week in vanuit de cookie
function setFromCookie()
{	
	cookie = getCookie("sorteerWaardes"); // cookie wordt opgehaald
	var valArray = cookie.split(':'); // waarde wordt gesplitst (dus week en jaar gesplitst)
	initYear(valArray[1]); // jaar wordt ingesteld
	setWeek(valArray[0]); // week wordt ingesteld en daarmee de lijst herladen
}

// checkCookie wordt door agenda_week_lijst.php aangeroepen om te kijken of de cookie er al/nog is
// zo ja, dan wordt setFromCookie aangeroepen
// zo nee, dan worden jaar en week gewoon ingesteld
// NB: het huidige jaar en week worden altijd in de globale variabelen
// CURRENTWEEK en CURRENTYEAR opgeslagen
function checkCookie(year, week)
{
	// de checkboxes worden allemaal aangevinkt
	document.getElementById("klantbox").checked = true;
	document.getElementById("keukenbox").checked = true;
	document.getElementById("afwasbox").checked = true;
	document.getElementById("barbox").checked = true;
	// huidige week en jaar worden opgeslagen
	CURRENTWEEK = week;
	CURRENTYEAR = year;
	// cookie wordt opgehaald
	var sorteerWaardes = getCookie("sorteerWaardes");
	
	if (sorteerWaardes != null && sorteerWaardes != "")
	{
		setFromCookie();
	}
	else
	{
		initYear(year);
		setWeek(week);
	}
}

// backToNow stelt jaar en week in op het huidige jaar en week
// dit gebeurt dmv de globale variabelen CURRENTYEAR en CURRENTWEEK
function backToNow()
{
	initYear(CURRENTYEAR);
	setWeek(CURRENTWEEK);
}
