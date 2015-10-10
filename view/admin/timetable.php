<h3>Välj aktivitet</h3>
<a class="btn btn-primary" href="<?=$root?>/admin/timetable/new"><span class="glyphicon glyphicon-plus"></span> Lägg till</a>
<div style="margin-top: 20px;" class="list-group">
	<?php foreach($items as $item): ?>
		<a class="list-group-item" href="<?=$root?>/admin/timetable/<?=$item->id?>">
			<span class="icon-preview">
				<?php if ( $item->have_icon() ): ?>
					<img src="<?=$item->icon_url?>"/>
				<?php endif; ?>
			</span>
			<span class="color-preview" style="background-color: <?=$item->get_color()?>;"></span>
			<?=$item->timestamp?> - <?=$item->text?> (<?=$item->short_name?>)
		</a>
	<?php endforeach; ?>
</div>
