function findPos(obj) {
	var curleft = curtop = 0;
	if(obj.offsetParent) {
	do {
		curleft += obj.offsetLeft;
		curtop += obj.offsetTop;
	} while (obj = obj.offsetParent);
	
	return [curleft, curtop];
}


function initLiveSearch()
{
	alert(document.getElementById("zoek_box").offsetTop);
}

document.addEventListener("DOMContentLoaded", initLiveSearch, false);
