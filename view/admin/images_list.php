<h2>Hantera bilder</h2>
<a href="<?=$root?>/admin/image_add" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Lägg till bild</a>

<div id="images">
	<?php foreach($images as $image): ?>
		<a href='<?=$root?>/admin/images/?img=<?=$image?>'><img class="img-rounded" src="/<?=$image?>"></a>
	<?php endforeach ?>
</div>

<a href="<?=$root?>/admin" class="btn btn-default">Tillbaka</a>
