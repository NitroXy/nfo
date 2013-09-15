<h4> Information angående att ändra eller lägga till schemaelement </h4>
<p> Datumet måste vara i rätt format, annars läggs inte schemaelementet in, eller kan tiden bli "0000-00-00 00:00:00". Utan det <u>måste</u> vara giltligt format och en giltlig tid. </p>
<p> Länken på schemaelementet är det bäst om du skriver till exempel: </p>
<p class="well">
	/esport
</p>
<p>för att länkarna skall vara bra <u>bör</u> du inte inkludera hela URLen </p>

<hr>
<form method="post" action="/admin/add">
	<table><p>
		<tr><td><span>Tid :</span></td><td> <input type="text" name="timestamp"/></td></tr>
		<tr><td><span>Namn:</span></td><td> <input type="text" name="name"/></td></tr>
		<tr><td><span>Länk: </span></td><td> <input type="text" name="href"/></td></tr>
	</p></table>
	<input type="submit" value="Spara"/>
</form>
