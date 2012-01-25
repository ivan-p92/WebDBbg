function findPos(obj)
{
	var curleft = curtop = 0;
	if(obj.offsetParent) {
		do {
			curleft += obj.offsetLeft;
			curtop += obj.offsetTop;
		} while (obj = obj.offsetParent);
	}
	
	return [curleft, curtop];
}


function initLiveSearch()
{
	alert(findPos(document.getElementById("zoek_box")));
}

document.addEventListener("DOMContentLoaded", initLiveSearch, false);
