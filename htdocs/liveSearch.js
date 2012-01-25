
function initLiveSearch()
{
	inputzoek = $("#zoek_box");
	resbox = $("#sresult");
	
	resbox.css("left", inputzoek.offset().left + "px");
	resbox.css("top", (inputzoek.offset().top + inputzoek.height()) + "px");
	

}

document.addEventListener("DOMContentLoaded", initLiveSearch, false);
