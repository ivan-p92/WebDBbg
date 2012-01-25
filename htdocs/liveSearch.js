$(document).ready(function() {	
	searchBox();
	
	$("#zoek_box").blur(function(e) {
		$("#sresult").css("display", "none");
	});
	
	$("#zoek_box").focus(function(e) {
		$("#sresult").css("display", "block");
	});
	
	$("#zoek_box").keyup(function(e) {
		var a = "q="+$("#zoek_box").val();
		
		$.ajax({
		  url: "livesearch.php",
		  cache: false,
		  data: a,
		  success: function(html){	$("#sresult").html(html); 	}
		});
	});	
	
	$("#zoek_box ul#livesearch li.clickable").click(function() {
		$("#zoek_box").val($(this).html());
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
	resbox.html("<ul id=\"livesearch\"><li>Geen resultaten</li></ul>");
}
 