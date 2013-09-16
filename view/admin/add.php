<h2> Lägg till sida </h2>
<p> Sidorna använder <a href="http://daringfireball.net/projects/markdown/"> Markdown</a>, guide till syntax är <a href="http://daringfireball.net/projects/markdown/syntax"> här</a>. </p>
<p> För att bygga submenyer (dvs. andra gradens menyer eller så kallade dropdowns, en meny i en meny) manipulerar du "Länken" på ett sådant vis. Till exempel, för att bygga E-Sports <i>länknät</i> ser länkarna ut såhär:<p>
<p>
<table class="table">
    <tr>
        <th> Länk </th>
        <th> Beskrivning </th>
    </tr>
    <tr>
        <td> /esport </td>
        <td> Basen, det som kommer synas i menyn ovan. </td>
    </tr>
    <tr>
        <td> /esport/LoL </td>
        <td> En undersida till E-Sport, dvs. League of Legends, som automatiskt kommer hamna under '/esport' i menyn. </td>
    </tr>
    <tr>
        <td> /esport/sc2 </td>
        <td> En undersida till E-Sport, dvs. Starcraft 2, som automatiskt kommer hamna under '/esport' i menyn. </td>
    </tr>
    <tr> 
        <td> osv </td>
        <td> ... </td>
    </tr>
</table>
</p>
<p class="alert alert-info well-sm"> <b>Notera:</b> om du lämnar positionsfältet tomt läggs det automatiskt längst bak. </p>

<form id="form" method="post" action="/admin/add">
    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Namn </span>
        <input type="text" name="name" class="form-control"/>
    </div>

    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Position </span>
        <input type="text" name="order" class="form-control"/>
    </div>

    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Länk </span>
        <input type="text" name="href" class="form-control"/>
    </div>
    
    <textarea class="form-control" name="text" id="text" rows="30"></textarea>

    <a style="margin-top: 15px" class="btn btn-success" href="#" onclick="image_add()">Infoga bild</a>
    <a style="margin-top: 15px;" class="btn btn-warning" href="#" onclick="preview()">Förhandsgranska</a>
    <input style="margin-top: 15px;" class="btn btn-info" type="submit" value="Spara"/>

    <br>
    <a style="margin-top: 15px;" class="btn btn-default" href="/admin/edit">Tillbaka</a>

</form>

<script>
	$('#form').submit(function() {
		if($("#name").val() == "") {
			alert("Du måste ange ett namn på den nya sidan.");
			return false;
		}
		if($("#href").val() == "") {
			alert("Du måste ange en länk på den nya sidan.");
			return false;
		}
		if($("#text").val() == "") {
			alert("Du måste skriva lite innehåll för den nya sidan.");
			return false;
		}
		return true;
	});
</script>

