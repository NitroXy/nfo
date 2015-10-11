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

<?php if ( $item->id ): ?>
	<h2>Redigerar aktivitet</h2>
<?php else: ?>
	<h2>Skapa ny aktivitet</h2>
<?php endif; ?>

<script>var presets = <?php echo json_encode($presets); ?></script>

<?php if ( !$this->is_partial() ): ?>
<div class="row">
	<div class="col-sm-6">
<?php endif; ?>
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
	$f->group(false, function($f) use($item) {
		global $root;
		$f->submit('Spara', 'save', ['class' => 'pull-right', 'name' => 'save']);
		if ( $item->id ){
			$f->submit('Ta bort', 'remove', ['class' => 'btn-danger pull-right', 'name' => 'remove']);
		}
		$f->link('Avbryt', "$root/admin/timetable", false, ['class' => 'btn btn-default pull-left', 'data-ajax-cancel' => true]);
	});
}, ['action' => $item->id ? "$root/admin/timetable/{$item->id}" : "$root/admin/timetable"]);
?>
<?php if ( !$this->is_partial() ): ?>
	</div>
</div>
<?php endif; ?>
