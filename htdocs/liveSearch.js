$(document).ready(function() {	
	searchBox();
	
	$("#zoek_box").blur(function(e) {
		$("#sresult").css("display", "none");
	});
		
	$("#zoek_box").focus(function(e) {
		$("#zoek_box").keyup();
		$("#sresult").css("display", "block");
	});
	
	$("#zoek_box").keyup(function(e) {
		
		
		if(e.keyCode != 40)
		{
			$.ajax({
			  url: "livesearch.php",
			  data: "q="+$("#zoek_box").val(),
			  success:	function(res) {
							$("#sresult").html(res);
							$("li.clickable").mousedown(function(e) {
								$("#zoek_box").val($(this).html());
								$("#sresult").css("display", "none");
							});
						}
			});
		}
		
		if(e.keyCode == 40)
		{
			a = $("li.clickable.selected");
			console.log(a);
		}
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
	resbox.html("<ul id=\"livesearch\"><li>Geen resultaten</li></ul>");
}
 