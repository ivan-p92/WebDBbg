// showEvents.js
// bevat de benodigde scripts om de weeklijst van de agenda
// dynamisch te kunnen gebruiken (agenda_week_lijst.php)

// showEvents wordt via initEvents (zie beneden) aangeroepen wanneer
// de weergave van agenda_week_lijst gewijzigd moet worden
// de functie ontvangt een array van initEvents met de aangevinkte categorieën
// elk list item wordt geanaliseerd en ofwel getoond of verborgen (met display
// block/none)
function showEvents(infoArray)
{
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
			if(hasClass(events[i], ""+YEAR+WEEK) && hasClassArray(events[i], classesArray))
			{
				//if(events[i].style.display == 'none') fadein(events[i], 1000); // bij faden
				events[i].style.display = 'block';
				//events[i].style.opacity = 1; // bij faden
				count++;
			}
			else // als een element niet getoond moet worden, krijgt het display:none als eigenschap
			{
				//if(events[i].style.display == 'block') fadeout(events[i], 1000); // bij faden
				events[i].style.display = 'none';
			}
		}
		// als de teller variabele nog steeds nul is, zijn er geen evenementen die
		// getoond moeten wroden en dus wordt de melding daarvan zichtbaar
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

// kijkt of een element een bepaalde class heeft
// BRON: http://www.openjs.com/scripts/dom/class_manipulation.php
function hasClass(ele,cls) 
{
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

// deze functie wordt aangeroepen wanneer er in de tekstvakjes van week en jaar getypt wordt
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
		if(WEEK == 0) { WEEK = 54; YEAR -= 1; setBox2(YEAR) } // jaarwisseling
		WEEK -= 1; // één week terug
		setBox(WEEK); // week weergeven
		
		// jaar weergeven, omdat je zeker wilt zijn dat het er altijd staat,
		// zou ook op 'fout!' kunnen staan
		setBox2(YEAR);
		initEvents(); // evenementen opnieuw weergeven/verbergen
	}
	// zelfde als hierboven, maar dan de andere kant op
	else if (forward)
	{
		if(WEEK == 53) { WEEK = -1; YEAR += 1; setBox2(YEAR) }
		WEEK += 1;
		setBox(WEEK);
		setBox2(YEAR);
		initEvents();
	}
}

// deze functie wordt aangeroepen bij het laden van de pagina
// en stelt het jaar in
function initYear(year)
{
	YEAR = year;
	setBox2(year);
}

// deze functie wordt bij verdere manipulaties van YEAR gebruikt
// de waarde wordt op geldigheid gecontroleerd
function setYear(year)
{
	if(!isNaN(year) && (parseFloat(year) == parseInt(year)) && year >= 2000 && year <= 2100)
	{
		YEAR = year;
		setBox2(year); // tekstvak wordt gevuld
		initEvents(); // lijst wordt opnieuw geladen
	}
	else
	{
		setBox2("Fout!")
	}
}

// deze functie stelt de waarde in van de globale WEEK variabele en stopt die ook in het tekstvak
// ook wordt de ontvangen waarde gecontroleerd
// NB: de weken lopen van 0-53
function setWeek(week)
{
	if(!isNaN(week) && (parseFloat(week) == parseInt(week)) && week >= 0 && week < 54)
	{
		WEEK = parseInt(week);
		setBox(week);
		initEvents();
	}
	else
	{
		setBox("Fout!");
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
	
	showEvents(checked);
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
		} while (obj = obj.offsetParent);
		
		return [curleft,curtop];
	}
}

function showDetails(obj, id)
{
	var coor = findPos(obj);
	var div = document.getElementById(id);
	div.style.left = (coor[0] + 500)+"px";
	div.style.top = coor[1]+"px";
	div.style.opacity = 1;
	div.style.display = "block";
	
}

// deze functie handelt het mouseout event af en roept fadeout aan voor
// de div "event_omschrijving"
// de functie bevat code die ervoor zorgt dat mouseout alleen getriggered wordt
// als de muis daadwerkelijk het list item verlaten heeft. Anders wordt
// het ook getriggered als het over andere elementen binnen het list item gaat.
// Bron: http://codingrecipes.com/onmouseout-fix-on-nested-elements-javascript
// NB: het is voor eigen doeleinden ietwat aangepast
function fixOMO(element, id, event)
{
	var div = document.getElementById(id);
	var current_mouse_target = null;
	if( event.relatedTarget ) {				
		current_mouse_target = event.relatedTarget;
	} else if( event.toElement ) {				
		current_mouse_target = event.toElement;
	}
	if( !is_child_of(element, current_mouse_target) && element != current_mouse_target )
		fadeout(div, 500);
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

// deze functie zorgt voor een geleidelijke overgang dmv een 'fade' effect
// Bron: http://www.lateralcode.com/javascript-fade-effect/
function fadeout(elem)
{
	//var startOpacity = elem.style.opacity || 1;
	elem.style.opacity = 1;//startOpacity;

	(function go() {
		elem.style.opacity -= 0.25;

		// for IE
		//elem.style.filter = 'alpha(opacity=' + elem.style.opacity * 100 + ')';

		if( elem.style.opacity > 0 )
			setTimeout( go, 25 );
		else
			elem.style.display = 'none';
	})();
}

// dezelfde functie als hierboven, maar zo gewijzigd dat het de andere kant op gaat
function fadein(elem, time)
{
	//var startOpacity = elem.style.opacity || 0;
	elem.style.opacity = 0.5;//startOpacity;
	elem.style.display = 'block';
	
	(function go() {
		elem.style.opacity += 1 / ( time / 50 );

		// for IE
		//elem.style.filter = 'alpha(opacity=' + elem.style.opacity * 100 + ')';

		if( elem.style.opacity < 1 )
			setTimeout( go, 50 );
		else
			elem.style.display = 'block';
	})();
}