function showEvents(infoArray)
{
	var week = document.getElementById("week_box").value;

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


function weekSubmitWithKey(keyEvent) 
{
    if (keyEvent.keyCode) var code = keyEvent.keyCode;
	else if (keyEvent.which) var code = keyEvent.which;
	
	if (code == 13)
	{
        var input = document.getElementById("week_box");
        setWeek(input.value);
    }
}

function setBox(val)
{
	document.getElementById("week_box").value = val;
}

function browseWeek(forward)
{
	if (!forward)
	{
		if(WEEK == 1) WEEK = 54;
		WEEK -= 1;
		setBox(WEEK);
		initEvents();
	}
	else if (forward)
	{
		if(WEEK == 53) WEEK = 0;
		WEEK += 1;
		setBox(WEEK);
		initEvents();
	}
}

function setWeek(week)
{
	if(!isNaN(week) && (parseFloat(week) == parseInt(week)) && week > 0 && week < 54)
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

function goToEvent(id)
{
	window.location.replace("index.php?page=evenement&id=" + id + "&semipage=agenda_week");
} 

