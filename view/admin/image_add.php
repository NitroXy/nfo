<h2> Ladda upp bild </h2>
<p> Tänk på att inte ladda upp för stora bilder, då detta ökar laddningstiden på hemsidan extremt mycket! </p>
<form action="/admin/image_add" method="post" enctype="multipart/form-data">
	<label class="form-control" for="file"> Filnamn: </label>
	<input class="form-control" type="file" name="file" id="file"> <br><br>
	<input class="btn btn-info" type="submit" name="submit" value="Ladda upp">
</form>
<a href="/admin/images"> Tillbaka </a>
