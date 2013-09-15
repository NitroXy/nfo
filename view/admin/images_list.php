<h2> Hantera bilder </h2>
<a href="/admin/image_add" class="btn btn-success"> Lägg till bild </a> 
<div id="images">
<?php
	foreach($images as $image) { ?>
		<a href='/admin/images/?img=<?=$image?>'><img class="img-rounded" src="/<?=$image?>"></a>
<?  } ?>
</div>
<br>

<a href="/admin" class="btn btn-default">Tillbaka</a>
