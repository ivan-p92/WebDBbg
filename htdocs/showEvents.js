function showEvents(week, infoArray)
{
	var events = document.getElementsByClassName("event");
	for (var i=0; i<events.length; i++)
	{
		if(hasClass(events[i], "w_"+week)
		{
			events[i].style.display = 'block';
		}
		else
		{
			events[i].style.display = 'none';
		}
	}	
}