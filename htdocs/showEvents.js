function showEvents(week, infoArray)
{
	var events = document.getElementsByClassName("event");
	var classesArray = new Array();
	for (var i=0; i<infoArray.length; i++)
	{
		classesArray.push("id_"+infoArray[i]);
	}
	
	for (var i=0; i<events.length; i++)
	{
		if(hasClass(events[i], "w_"+week) && hasClassArray(events[i], classesArray))
		{
			events[i].style.display = 'block';
		}
		else
		{
			events[i].style.display = 'none';
		}
	}	
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

function updateShownEvents()
{
	init(4);
}

function init(week)
{
	var checkboxes = document.getElementsByClassName("catbox");
	var weekbox = document.getElementsById("week_box");
	weekbox.value = week;
	var checked = new Array();
	
	for(var i = 0; i < checkboxes.length; i++)
	{
		if(checkboxes[i].checked)
		{
			checked.push(checkboxes[i].value);
		}
	}
	
	showEvents(week, checked);
}

