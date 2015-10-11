<?php if ( !$this->is_partial() ): ?>
	<ol class="breadcrumb">
		<li><a href="<?=$root?>/">NFO</a></li>
		<li><a href="<?=$root?>/admin">Admin</a></li>
		<li><a href="<?=$root?>/admin/timetable">Schema</a></li>
		<?php if ( $item->id ): ?>
			<li class="active"><?=$item->text?></li>
		<?php else: ?>
			<li class="active">Ny aktivitet</li>
		<?php endif; ?>
	</ol>
<?php endif; ?>

<script>var presets = <?php echo json_encode($presets); ?></script>

<form action="<?=$item->id ? "$root/admin/timetable/{$item->id}" : "$root/admin/timetable"?>" method="post">
	<h2 class="title-buttons clearfix">
		<?php if ( $item->id ): ?>
			Redigera aktivitet
		<?php else: ?>
			Skapa ny aktivitet
		<?php endif; ?>

		<div class="btn-group pull-right">
			<button name="remove" type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Ta bort</button>
			<button name="save" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save"></span> Spara</button>
		</div>
	</h2>

	<?php if ( !$this->is_partial() ): ?><div class="row"><div class="col-sm-6"><?php endif; ?>
	<?php
		Form::from_object($item, function($f) use($item) {
			$f->fieldset('Aktivitet', function($f){
				$f->text_field('text', 'Titel', ['required' => true, 'placeholder' => 'Ny aktivitet']);
				$f->text_field('short_name', 'Kortnamn', ['required' => true, 'placeholder' => 'Aktivitet', 'hint' => 'Kortnamnet ersätter namnet i mobilversionen', 'max-length' => 10]);
				$f->text_field('href', 'Länk', ['type' => 'url', 'placeholder' => 'http://example.net']);
			});
			$f->fieldset('Tid', function($f){
				$f->text_field('timestamp', 'Tid', ['hint' => 'YYYY-MM-DD HH:MM', 'required' => true]);
				$f->text_field('duration', 'Längd', ['hint' => 'Antal timmar', 'type' => 'number', 'step' => '0.5']);
			});
			$f->fieldset('Visuellt utseende', function($f){
				$f->select(FormSelect::from_selection($f, 'preset_id', 'name', SchemePreset::all(), 'Grupp', ['null' => true, 'hint' => 'Vilken schema-grupp den här aktiviteten tillhör. Om en grupp är vald används färg, ikon osv från gruppen.', 'class' => 'preset-selector']));
				$f->text_field('color', 'Färg', ['type' => 'color', 'class' => 'hidden-preset']);
			});
			$f->link('Avbryt', url('/admin/timetable'), false, ['class' => 'btn btn-default', 'data-ajax-cancel' => true]);
		}, ['action' => false]);
		?>
	<?php if ( !$this->is_partial() ): ?></div></div><?php endif; ?>
</form>
