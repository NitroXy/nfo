<h2 class="title-buttons clearfix">
	Välj aktivitet
	<a class="btn btn-primary pull-right" href="<?=$root?>/admin/timetable/new"><span class="glyphicon glyphicon-plus"></span> Lägg till</a>
</h2>

<?php foreach ( $grouped as $day => $items ): ?>
	<h3>Dag <?=$day-$first_day+1?><small> - <?=strftime('%A, %Y-%m-%d', $day*86400)?></small></h3>
	<div style="margin-top: 20px;" class="list-group">
		<?php foreach($items as $item): ?>
			<a class="list-group-item" href="<?=$root?>/admin/timetable/<?=$item->id?>">
				<span class="icon-preview">
					<?php if ( $item->have_icon() ): ?>
						<img src="<?=$item->icon_url?>"/>
					<?php endif; ?>
				</span>
				<span class="color-preview" style="background-color: <?=$item->get_color()?>;"></span>
				<?=strftime('%H:%M', strtotime($item->timestamp))?> - <?=$item->text?> (<?=$item->short_name?>)
			</a>
		<?php endforeach; ?>
	</div>
<?php endforeach; ?>
