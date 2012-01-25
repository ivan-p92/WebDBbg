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
	array = findPos(document.getElementById("zoek_box"));
	box = document.getElementById("sresult");
	
	box.style.left = array[0]+"px"
	box.style.top = array[1]+"px";
}

document.addEventListener("DOMContentLoaded", initLiveSearch, false);
