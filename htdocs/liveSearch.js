$(document).ready(function() {	
	
});
 
$(window).resize(function() {
	alert('jaja');
	searchBox();
})
 
 
function searchBox()
 {
 	inputzoek = $("#zoek_box");
	resbox = $("#sresult");
	
	resbox.css("left", inputzoek.offset().left + "px");
	resbox.css("top", (inputzoek.offset().top + inputzoek.outerHeight()) + "px");
}
 