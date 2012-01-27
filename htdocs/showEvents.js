function showEvents(infoArray)
{
	var events = document.getElementsByClassName("event");
	var classesArray = new Array();
	for (var i=0; i<infoArray.length; i++)
	{
		classesArray.push("id_"+infoArray[i]);
	}
	
	var count = 0;
	for (var i=0; i<events.length; i++)
	{
		if(hasClass(events[i], "w_"+WEEK) && hasClass(events[i], "y_"+YEAR) && hasClassArray(events[i], classesArray))
		{
			if(events[i].style.display == 'none') fadein(events[i], 2000); // bij faden
			//events[i].style.display = 'block';
			//events[i].style.opacity = 1; // bij faden
			count++;
		}
		else
		{
			//if(events[i].style.display == 'block') fadeout(events[i], 1000); // bij faden
			events[i].style.display = 'none';
		}
	}
	if(count == 0) document.getElementById("no_events").style.display = "block";
	else document.getElementById("no_events").style.display = "none";
}

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


function dateSubmitWithKey(keyEvent, wk) // wk true als week, anders wordt jaar ingesteld 
{
    if (keyEvent.keyCode) var code = keyEvent.keyCode;
	else if (keyEvent.which) var code = keyEvent.which;
	
	if (code == 13)
	{
		if(wk)
		{
			var input = document.getElementById("week_box");
			setWeek(input.value);
		}
		else
		{
			var input = document.getElementById("jaar_box");
			setYear(input.value);
		}
	}
}

function setBox(val)
{
	document.getElementById("week_box").value = val;
}

function setBox2(val)
{
	document.getElementById("jaar_box").value = val;
}

function browseWeek(forward)
{
	if (!forward)
	{
		if(WEEK == 0) { WEEK = 54; YEAR -= 1; setBox2(YEAR) }
		WEEK -= 1;
		setBox(WEEK);
		setBox2(YEAR);
		initEvents();
	}
	else if (forward)
	{
		if(WEEK == 53) { WEEK = -1; YEAR += 1; setBox2(YEAR) }
		WEEK += 1;
		setBox(WEEK);
		setBox2(YEAR);
		initEvents();
	}
}

function initYear(year)
{
	YEAR = year;
	setBox2(year);
}

function setYear(year)
{
	if(!isNaN(year) && (parseFloat(year) == parseInt(year)) && year >= 2000 && year <= 2100)
	{
		YEAR = year;
		setBox2(year);
		initEvents();
	}
	else
	{
		setBox2("Fout!")
	}
}

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

function initEvents()
{
	var checkboxes = document.getElementsByClassName("catbox");
	var checked = new Array();
	
	for(var i = 0; i < checkboxes.length; i++)
	{
		if(checkboxes[i].checked)
		{
			checked.push(checkboxes[i].value);
		}
	}
	
	showEvents(checked);
}

function goToEventA(id)
{
	window.location.replace("index.php?page=evenement&id=" + id + "&semipage=agenda_week");
} 

function goToEventK(id)
{
	window.location.replace("index.php?page=evenement&id=" + id + "&semipage=keuren");
}

// Bron: http://www.lateralcode.com/javascript-fade-effect/
function fadeout(elem, time)
{
	//var startOpacity = elem.style.opacity || 1;
	elem.style.opacity = 1;//startOpacity;

	(function go() {
		elem.style.opacity -= 1 / ( time / 50 );

		// for IE
		//elem.style.filter = 'alpha(opacity=' + elem.style.opacity * 100 + ')';

		if( elem.style.opacity > 0 )
			setTimeout( go, 50 );
		else
			elem.style.display = 'none';
	})();
}

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