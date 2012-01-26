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
		
		
		if(e.keyCode != 40 && e.keyCode != 38 && e.keyCode != 13)
		{
			$.ajax({
			  url: "livesearch.php",
			  data: "q="+$("#zoek_box").val(),
			  success:	function(res) {
							$("#sresult").html(res);
							$("#sresult").css("display", "block");
							$("li.clickable").mousedown(function(e) {
								$("#sresult").css("display", "none");
								window.location.replace("index.php?page=admin&id=" + $(this).find("span.ls_id").html() + "&semipage=lijst_van_gebruikers");
							});
						}
			});
		}
		
		if(e.keyCode == 27)	// escape
		{
			$("#zoek_box").blur();
		}
		
		if(e.keyCode == 13)	// enter
		{
			$("ul#livesearch li.clickable").each(function(index, element) {
					var tmp = $(element);
					
					if(tmp.hasClass("selected"))
					{
						$("#sresult").css("display", "none");						
						window.location.replace("index.php?page=admin&id=" + tmp.find("span.ls_id").html() + "&semipage=lijst_van_gebruikers");
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
			
			if(total >= 0)
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
				
				var temp  = $("ul#livesearch li.clickable:nth-child("+ (next + 1) +")");
				temp.addClass("selected");
				$("#zoek_box").val(temp.find("span.ls_name").html());
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
			
			if(total >= 0)
			{
				var next;
				if(current == 0)
				{
					next = total;
				}
				else
				{
					next = current - 1;
				}

				var temp = $("ul#livesearch li.clickable:nth-child("+ (next + 1) +")");
				temp.addClass("selected");
				$("#zoek_box").val(temp.find("span.ls_name").html());
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
 