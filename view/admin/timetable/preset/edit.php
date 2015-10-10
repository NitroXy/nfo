<ol class="breadcrumb">
  <li><a href="<?=$root?>/">NFO</a></li>
  <li><a href="<?=$root?>/admin">Admin</a></li>
  <li><a href="<?=$root?>/admin/timetable-preset">Schema-mallar</a></li>
	<?php if ( $preset->id ): ?>
		<li class="active"><?=$preset->name?></li>
	<?php else: ?>
		<li class="active">Ny mall</li>
	<?php endif; ?>
</ol>

<h1>Schema-mallar</h1>

<div class="row">
	<div class="col-sm-6">
		<?php
		Form::from_object($preset, function($f) use ($preset) {
			$icon_attr = [];
			if ( $preset->have_icon() ){
				$icon_attr = ['remove' => true, 'current' => "<img src=\"{$preset->icon_url}\"/>"];
			}

			$f->text_field('name', 'Namn', ['required' => true]);
			$f->text_field('color', 'Färg', ['type' => 'color']);
			$f->upload_field('icon', 'Ikon', $icon_attr);
			$f->group(false, function($f) use($preset) {
				global $root;
				$f->submit('Spara', 'save', ['class' => 'pull-right', 'name' => 'save']);
				if ( $preset->id ){
					$f->submit('Ta bort', 'remove', ['class' => 'btn-danger pull-right', 'name' => 'remove']);
				}
				$f->link('Avbryt', "$root/admin/timetable-preset", false, ['class' => 'btn btn-default pull-left']);
			});
		}, ['action' => $preset->id ? "$root/admin/timetable-preset/{$preset->id}" : "$root/admin/timetable-preset", 'enctype' => 'multipart/form-data']);
		?>
	</div>
</div>
