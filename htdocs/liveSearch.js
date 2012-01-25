$(document).ready(function() {	
	searchBox();
	
		
	$("#zoek_box").focus(function(e) {
		$("#sresult").css("display", "block");
	});
	
	$("#zoek_box").keyup(function(e) {
		var a = "q="+$("#zoek_box").val();
		
		$.ajax({
		  url: "livesearch.php",
		  data: a,
		  success: function(res) { $("#sresult").html(res); }
		});
	});
	
	$("li.clickable").mouseover(function(e) {
		alert('d');
	});
});
	

	
 
$(window).resize(function() {
	searchBox();
})


 
function searchBox() {
 	inputzoek = $("#zoek_box");
	resbox = $("#sresult");
	
	resbox.css("display", "none");
	resbox.css("left", inputzoek.offset().left + "px");
	resbox.css("top", (inputzoek.offset().top + inputzoek.outerHeight()) + "px");
	resbox.html("<ul id=\"livesearch\"><li>Gen resultaten</li></ul>");
}
 