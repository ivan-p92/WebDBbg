$(document).ready(function() {	
	searchBox();
	
	
	$("#zoek_box").focus(function(e) {
		$("#sresult").css("display", "block");
	});
});
 
$(window).resize(function() {
	searchBox();
})


 
 
function searchBox()
 {
 	inputzoek = $("#zoek_box");
	resbox = $("#sresult");
	
	resbox.css("display", "none");
	resbox.css("left", inputzoek.offset().left + "px");
	resbox.css("top", (inputzoek.offset().top + inputzoek.outerHeight()) + "px");
}
 