<ol class="breadcrumb">
  <li><a href="<?=$root?>/">NFO</a></li>
  <li><a href="<?=$root?>/admin">Admin</a></li>
	<li class="active">Schema</li>
</ol>

<div class="row">
	<div class="col-sm-6">
		<h2 class="title-buttons clearfix">
			Välj aktivitet
			<div class="btn-group pull-right">
				<a class="btn btn-default" href="<?=$root?>/admin/timetable-preset" data-ajax="#work"><span class="glyphicon glyphicon-wrench"></span> Grupper</a>
				<a class="btn btn-primary" href="<?=$root?>/admin/timetable/new" data-ajax="#work"><span class="glyphicon glyphicon-plus"></span> Ny aktivitet</a>
			</div>
		</h2>

		<?php foreach ( $grouped as $day => $items ): ?>
			<h3>Dag <?=$day-$first_day+1?><small> - <?=strftime('%A, %Y-%m-%d', $day*86400)?></small></h3>
			<div style="margin-top: 20px;" class="list-group">
				<?php foreach($items as $item): ?>
					<a class="list-group-item" href="<?=$root?>/admin/timetable/<?=$item->id?>" data-ajax="#work">
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
	</div>

	<div class="col-sm-6" id="work">
	</div>
</div>
