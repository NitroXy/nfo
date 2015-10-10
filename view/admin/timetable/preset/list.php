<ol class="breadcrumb">
  <li><a href="<?=$root?>/">NFO</a></li>
  <li><a href="<?=$root?>/admin">Admin</a></li>
  <li class="active">Schema-grupper</li>
</ol>

<h1>Schema-grupper</h1>

<div class="row">
	<div class="col-sm-6">
		<?php if ( count($presets) > 0 ): ?>
			<div class="list-group">
				<?php foreach ( $presets as $preset ): ?>
					<a class="list-group-item" href="<?=url('/admin/timetable-preset/:id', $preset->id)?>">
						<span class="icon-preview">
							<?php if ( $preset->have_icon() ): ?>
								<img src="<?=$preset->icon_url?>"/>
							<?php endif; ?>
						</span>
						<span class="color-preview" style="background-color: <?=$preset->color?>;"></span>
						<?=$preset->name?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php else: ?>
			<p>Just nu finns det inga grupper</p>
		<?php endif; ?>

		<div class="actions">
			<a href="<?=$root?>/admin" class="btn btn-default pull-left">&laquo; Tillbaka</a>
			<a href="<?=$root?>/admin/timetable-preset/new" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span> Ny grupp</a>
		</div>
	</div>
</div>
