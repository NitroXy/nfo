<?php if ( !$this->is_partial() ): ?>
	<ol class="breadcrumb">
		<li><a href="<?=$root?>/">NFO</a></li>
		<li><a href="<?=$root?>/admin">Admin</a></li>
		<li class="active">Schema-grupper</li>
	</ol>
<?php endif; ?>

<h2 class="title-buttons clearfix">
	Schema-grupper
	<div class="btn-group pull-right">
		<a href="<?=$root?>/admin/timetable-preset/new" class="btn btn-primary" data-ajax="#work"><span class="glyphicon glyphicon-plus"></span> Ny grupp</a>
	</div>
</h2>

<?php if ( count($presets) > 0 ): ?>
	<div class="list-group">
		<?php foreach ( $presets as $preset ): ?>
			<a class="list-group-item" href="<?=url('/admin/timetable-preset/:id', $preset->id)?>" data-ajax="#work">
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
	<a href="<?=$root?>/admin" class="btn btn-default pull-left" data-ajax-cancel>Avbryt</a>
</div>
