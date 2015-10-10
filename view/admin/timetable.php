<h3>Välj aktivitet</h3>
<a class="btn btn-primary" href="<?=$root?>/admin/timetable/new"><span class="glyphicon glyphicon-plus"></span> Lägg till</a>
<div style="margin-top: 20px;" class="list-group">
	<?php foreach($items as $item): ?>
		<a class="list-group-item" href="<?=$root?>/admin/timetable/<?=$item->id?>">
			<span class="color-preview" style="background-color: <?=$item->color?>;"></span>
			<?=$item->timestamp?> - <?=$item->text?> (<?=$item->short_name?>)
		</a>
	<?php endforeach; ?>
</div>
