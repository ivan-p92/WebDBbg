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
		
		
		if(e.keyCode != 40 && e.keyCode != 38)
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
		
		if(e.keyCode == 40)	// pijltje naar benee
		{
			var current = -1;
			var total = -1;
			
			$("ul#livesearch li.clickable").each(function(index, element) {
				var tmp = $(element);
				
				if(tmp.hasClass("selected"))
				{
					current = index;
					tmp.removeClass("selected");
				}
				total++;
			});
			
			if(total > 0)
			{
				var next;
				if(current == total)
				{
					next = 0;
				}
				else
				{
					next = current + 1;
				}
				
				$("ul#livesearch li.clickable:nth-child("+ (next + 1) +")").addClass("selected");
			}
		}
		
		if(e.keyCode == 38)	// pijltje omhoog
		{
			var current = -1;
			var total = -1;
			
			$("ul#livesearch li.clickable").each(function(index, element) {
				var tmp = $(element);
				
				if(tmp.hasClass("selected"))
				{
					current = index;
					tmp.removeClass("selected");
				}
				total++;
			});
			
			if(total > 0)
			{
				var next;
				if(current == 0)
				{
					next = (total - 1);
				}
				else
				{
					next = current;
				}
				
				console.log("ul#livesearch li.clickable:nth-child("+ (next + 1) +")");
				$("ul#livesearch li.clickable:nth-child("+ (next + 1) +")").addClass("selected");
			}
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
 