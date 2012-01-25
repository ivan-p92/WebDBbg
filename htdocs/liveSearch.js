
function initLiveSearch()
{
	el = $("#zoek_box");
	box = $("#sresult");
	
	box.css("left", el.offset().left+"px");
	box.css("top", el.offset().top+"px");
	

}

document.addEventListener("DOMContentLoaded", initLiveSearch, false);
