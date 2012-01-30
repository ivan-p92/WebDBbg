/* liveSearch is zelf gemaakt met jQuery, maar het lukte niet om dit om te schrijven naar javascript (zonder framework)
dit kan voor de beoordeling dus genegeerd worden */
 
$(document).ready(function() {	
	searchBox();	// zorg dat ie op de goede plaats staat
	
	$("#zoek_box").blur(function(e) {		// laat popupje verdwijnen bij deselecten input
		$("#sresult").css("display", "none");
	});
		
	$("#zoek_box").focus(function(e) { // laat popupje verschijnen bij focus van input element
		$("#zoek_box").keyup();
		$("#sresult").css("display", "block");
	});
	
	$("#zoek_box").keyup(function(e) { // deze functie wordt aangeroepen als er een teken is ingevoerd in de input
	
		if(e.keyCode != 40 && e.keyCode != 38 && e.keyCode != 13 && e.keyCode != 27) // als er een echt karakter is ingevoerd, maak een AJAX request en haal de gegevens op
		{
			$.ajax({
			  url: "livesearch.php",
			  data: "q="+$("#zoek_box").val(),
			  success:	function(res) {
							$("#sresult").html(res);
							$("#sresult").css("display", "block");
							$("li.clickable").mousedown(function(e) {	// als er op geklikt wordt, ga naar de juiste pagina
								$("#sresult").css("display", "none");
								window.location.replace("index.php?page=admin&id=" + $(this).find("span.ls_id").html() + "&semipage=lijst_van_gebruikers");
							});
						}
			});
		}

		if(e.keyCode == 13)	// enter
		{					// ga naar juiste pagina als er eenitem geselecteerd is
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
		{					// verander geselecteerd element
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
		{					// verander geselecteerd element
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

// zorg dat de popup altijd op juiste plaats staat
$(window).resize(function() {
	searchBox();
});
 
// functie die popup op juiste plaats zet.
// namelijk direct onder de input
function searchBox() {
 	inputzoek = $("#zoek_box");
	resbox = $("#sresult");
	
	resbox.css("display", "none");
	resbox.css("left", inputzoek.offset().left + "px");
	resbox.css("top", (inputzoek.offset().top + inputzoek.outerHeight()) + "px");
	resbox.html("<ul id=\"livesearch\"><li>Geen resultaten</li></ul>");
}