<form method="post" action="<?=url('/admin/edit/:id', $id)?>">
	<h2 class="title-buttons clearfix">
		<?=$s->name?> - <?=$s->display_name?>
		<div class="btn-group pull-right">
			<a class="btn btn-danger" href="<?=url('/admin/delete:id', $s->id)?>"><span class="glyphicon glyphicon-remove"></span> Ta bort</a>
			<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-floppy-save"></span> Spara</button>
		</div>
	</h2>

	<?php
	Form::from_object($s, function($f){
		$f->text_field('display_name', 'Namn', ['required' => true]);
		$f->text_field('display_order', 'Sortering', ['required' => true, 'type' => 'number']);
		$f->text_field('href', 'Länk', ['disabled' => true]);
		$f->textarea('text', 'Innehåll', ['rows' => 10, 'data-preview' => '#preview', 'hint' => 'Sidorna använder <a href="http://daringfireball.net/projects/markdown/"> Markdown</a>, guide till syntax är <a href="https://nitroxy.com/formatting.php"> här</a>. HTML är tillåtet.']);
	}, ['action' => false]);
	?>

	<div class="actions clearfix">
		<a class="btn btn-default pull-left" href="<?=$root?>/admin/edit" data-ajax-cancel>Tillbaka</a>
		<a class="btn btn-success pull-right" href="#" onclick="image_add()"><span class="glyphicon glyphicon-picture"></span> Infoga bild</a>
	</div>
</form>
