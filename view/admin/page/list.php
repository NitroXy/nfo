<h3>Välj sida att redigera</h3>

<div class="row">
	<div class="col-sm-6">
		<div class="list-group">
			<?php foreach($sites as $site): ?>
				<a class="list-group-item" href="<?=$root?>/admin/edit/<?=$site->id?>"> <?=$site->name?> - <?=$site->display_name?> </a>
			<?php endforeach; ?>
		</div>

		<div class="actions">
			<a href="<?=$root?>/admin" class="btn btn-default pull-left">Tillbaka</a>
			<a href="<?=$root?>/admin/add" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span> Lägg till sida</a>
		</div>
	</div>
</div>
