<ol class="breadcrumb">
	<li><a href="<?=$root?>/">NFO</a></li>
	<li><a href="<?=$root?>/admin">Admin</a></li>
	<li class="active">Sidor</li>
</ol>

<div class="row">
	<div class="col-sm-6">
		<h2 clas="title-buttons">
			Välj sida<span class="hidden-xs hidden-sm"> att redigera</span>
			<div class="btn-group pull-right">
				<a href="<?=$root?>/admin/add" class="btn btn-primary" data-ajax="#work"><span class="glyphicon glyphicon-plus"></span> Ny sida</a>
			</div>
		</h2>
		<div class="list-group">
			<?php foreach($sites as $site): ?>
				<a class="list-group-item" href="<?=$root?>/admin/edit/<?=$site->id?>" data-ajax="#work"> <?=$site->name?> - <?=$site->display_name?></a>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="col-sm-6" id="work">
	</div>
</div>
