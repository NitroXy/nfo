<form method="post" action="<?=url('/admin/edit/:id', $id)?>">
	<h2 class="title-buttons clearfix">
		<?=$s->name?> - <?=$s->display_name?>
		<div class="btn-group pull-right">
			<a class="btn btn-danger" href="<?=url('/admin/delete:id', $s->id)?>">Ta bort</a>
			<button class="btn btn-primary" type="submit">Spara</button>
		</div>
	</h2>

	<p> Sidorna använder <a href="http://daringfireball.net/projects/markdown/"> Markdown</a>, guide till syntax är <a href="https://nitroxy.com/formatting.php"> här</a>. </p>

    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Namn </span>
        <input type="text" name="name" class="form-control" value="<?=$s->display_name?>"/>
    </div>

    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Position </span>
        <input type="text" name="order" class="form-control" value="<?=$s->display_order?>"/>
    </div>

    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Länk </span>
        <input type="text" name="href" class="form-control" disabled value="<?=$s->name?>"/>
    </div>

    <textarea class="form-control" name="text" id="text" rows="10"><?=$s->text?></textarea>

    <a style="margin-top: 15px" class="btn btn-success" href="#" onclick="image_add()">Infoga bild</a>
    <a style="margin-top: 15px;" class="btn btn-warning" href="#" onclick="preview()">Förhandsgranska</a>

    <a style="margin-top: 20px;" class="btn btn-default" href="<?=$root?>/admin/edit" data-ajax-cancel>Tillbaka</a>
</form>
