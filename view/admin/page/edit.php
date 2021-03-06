<form method="post" action="<?=url('/admin/edit/:id', $page->id)?>">
	<h2 class="title-buttons clearfix">
		<?=$page->name?> - <?=$page->display_name?>
		<div class="btn-group pull-right">
			<a class="btn btn-danger" href="<?=url('/admin/delete/:id', $page->id)?>"><span class="glyphicon glyphicon-remove"></span> Ta bort</a>
		</div>
	</h2>

	<?php
	Form::from_object($page, function($f){
		$f->text_field('display_name', 'Namn', ['required' => true]);
		$f->text_field('display_order', 'Sortering', ['required' => true, 'type' => 'number']);
		$f->text_field('href', 'Länk', ['disabled' => true]);
		$f->textarea('text', 'Innehåll', ['rows' => 10, 'class' => 'editor', 'data-preview' => '#preview', 'hint' => 'Sidorna använder <a href="http://daringfireball.net/projects/markdown/"> Markdown</a>, guide till syntax är <a href="https://nitroxy.com/formatting.php"> här</a>. HTML är tillåtet.']);
	}, ['action' => false]);
	?>

	<div class="actions clearfix">
		<a class="btn btn-default pull-left" href="<?=$root?>/admin/edit" data-ajax-cancel>Tillbaka</a>
		<div class="btn-group pull-right">
			<button type="button" class="btn btn-success" data-toggle="collapse" data-target=".image-gallery"><span class="glyphicon glyphicon-picture"></span> Infoga bild</button>
			<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-floppy-save"></span> Spara</button>
		</div>
	</div>

	<ul class="image-gallery collapse">
		<?php foreach ( Image::all() as $image): ?>
			<li class="image-thumbnail" data-target=".editor">
				<img class="img-rounded" src="<?=$image->thumbnail_url?>" data-image="<?=$image->url?>">
			</li>
		<?php endforeach ?>
	</ul>
</form>
