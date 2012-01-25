
function initLiveSearch()
{
	el = $("#zoek_box");
	box = $("#sresult");
	
	alert(el.offset());
	
	box.style.left = findPosX(el)+"px"
	box.style.top = findPosY(el)+"px";
}

document.addEventListener("DOMContentLoaded", initLiveSearch, false);
