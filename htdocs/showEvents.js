function showEvents(week, infoArray)
{
	var events = document.getElementsByClassName("event");
	for (var i=0; i<events.length; i++)
	{
		if(hasClass(events[i], "w_"+week))
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

// BRON: http://javascript.about.com/library/blweekyear.htm
function getWeek() 
{
	var onejan = new Date(Date.getFullYear(),0,1);
	return Math.ceil((((this - onejan) / 86400000) + onejan.getDay()+1)/7);
} 

function init()
{
	showEvents(getWeek(), new Array());
}

document.addEventListener("DOMContentLoaded", init, false);