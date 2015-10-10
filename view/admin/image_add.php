<h2>Ladda upp bild</h2>

<div class="row">
	<div class="col-sm-6">
		<p>Tänk på att inte ladda upp för stora bilder, då detta ökar laddningstiden på hemsidan extremt mycket!</p>

		<form action="<?=$root?>/admin/image_add" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label class="control-label" for="file">Filnamn</label>
				<input class="form-control" type="file" name="file" id="file"/>
			</div>

			<div class="actions clearfix">
				<a class="btn btn-default pull-left" href="<?=$root?>/admin/images">Avbryt</a>
				<input class="btn btn-primary pull-right" type="submit" name="submit" value="Ladda upp">
			</div>
		</form>
	</div>
