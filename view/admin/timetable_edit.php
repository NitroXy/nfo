<?php if ( $item->id ): ?>
	<h2>Redigerar aktivitet</h2>
<?php else: ?>
	<h2>Skapa ny aktivitet</h2>
<?php endif; ?>
<?php
Form::from_object($item, function($f) use($item) {
	$f->text_field('timestamp', 'Tid', ['hint' => 'YYYY-MM-DD HH:MM', 'required' => true]);
	$f->text_field('text', 'Titel', ['required' => true, 'placeholder' => 'Ny aktivitet']);
	$f->text_field('href', 'Länk', ['type' => 'url', 'placeholder' => 'http://example.net']);
	$f->text_field('duration', 'Längd', ['hint' => 'Antal timmar', 'type' => 'number', 'step' => '0.5']);
	$f->text_field('color', 'Färg', ['type' => 'color']);
	$f->group(false, function($f) use($item) {
		$f->submit('Spara', 'save', ['class' => 'pull-right', 'name' => 'save']);
		if ( $item->id ){
			$f->submit('Ta bort', 'remove', ['class' => 'btn-danger pull-right', 'name' => 'remove']);
		}
		$f->link('Avbryt', '/admin/timetable', false, ['class' => 'btn btn-default pull-left']);
	});
}, ['action' => $item->id ? "/admin/timetable/{$item->id}" : "/admin/timetable"]);
?>
