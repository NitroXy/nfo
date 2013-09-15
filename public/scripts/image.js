/*
	Opens a new "form" to insert a new or already uploaded image to
	the textarea with id="text"
*/
function image_add() {
	$.ajaxSetup({
		cache: false
	});

	/* Must have a holder .. */
	var holder = $("#holder");
	if(holder == null) {
		alert("Kontakta administratören, det är något fel på denna sidans bildfunktion.");
	} else {
		holder.html("<div class=\"panel-heading\"> Välj bild </div> <div class=\"panel-body\"> <div class=\"panel-body\"> <p> För att lägga till nya bilder måste du gå in på \"Hantera bilder\" i Administrationspanelen. Välj bland redan upplagda bilder: </p><div class=\"image_picker\"> </div></div>");
		$(".image_picker").load("/admin/image_embedded_pick");
		holder.dialog({ 
			minWidth: 900,
			modal: true
		});
	}
}

function image_insert(path) {
	var before = $("#text").val();
	$("#text").val(before + " \n![a](/" + path + ")\n");
	$("#holder").dialog("close");
}
