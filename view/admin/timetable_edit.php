<?php if ( $item->id ): ?>
	<h2>Redigerar aktivitet</h2>
<?php else: ?>
	<h2>Skapa ny aktivitet</h2>
<?php endif; ?>
<?php
Form::from_object($item, function($f) use($item) {
	$f->fieldset('Aktivitet', function($f){
		$f->text_field('text', 'Titel', ['required' => true, 'placeholder' => 'Ny aktivitet']);
		$f->text_field('short_name', 'Kortnamn', ['required' => true, 'placeholder' => 'Aktivitet', 'hint' => 'Kortnamnet visas i mobil']);
		$f->text_field('href', 'Länk', ['type' => 'url', 'placeholder' => 'http://example.net']);
	});
	$f->fieldset('Tid', function($f){
		$f->text_field('timestamp', 'Tid', ['hint' => 'YYYY-MM-DD HH:MM', 'required' => true]);
		$f->text_field('duration', 'Längd', ['hint' => 'Antal timmar', 'type' => 'number', 'step' => '0.5']);
	});
	$f->fieldset('Visuellt utseende', function($f){
		$f->select(FormSelect::from_selection($f, 'preset_id', 'name', SchemePreset::all(), 'Mall', ['null' => true, 'hint' => 'Fördefinierad mall.', 'class' => 'preset-selector']));
		$f->text_field('color', 'Färg', ['type' => 'color', 'class' => 'hidden-preset']);
	});
	$f->group(false, function($f) use($item) {
		global $root;
		$f->submit('Spara', 'save', ['class' => 'pull-right', 'name' => 'save']);
		if ( $item->id ){
			$f->submit('Ta bort', 'remove', ['class' => 'btn-danger pull-right', 'name' => 'remove']);
		}
		$f->link('Avbryt', "$root/admin/timetable", false, ['class' => 'btn btn-default pull-left']);
	});
}, ['action' => $item->id ? "$root/admin/timetable/{$item->id}" : "$root/admin/timetable"]);
