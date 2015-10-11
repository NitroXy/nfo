<ol class="breadcrumb">
  <li><a href="<?=$root?>/">NFO</a></li>
  <li class="active"">Admin</li>
</ol>

<div class="row">
	<div class="col-sm-6">
		<h2>Administrationsverktyg</h2>
		<div class="list-group">
			<?php if(has_right('Sido-moderator')): ?>
				<a class="list-group-item" href="<?=$root?>/admin/edit">Sidor</a>
			<?php endif; ?>

			<?php if(has_right('Bild-moderator')): ?>
				<a class="list-group-item" href="<?=$root?>/admin/images">Bilder</a>
			<?php endif; ?>

			<?php if(has_right('Nyhets-moderator')): ?>
				<a class="list-group-item" href="<?=$root?>/admin/news">Nyheter</a>
			<?php endif; ?>

			<?php if(has_right('Schema-moderator')): ?>
				<a class="list-group-item" href="<?=$root?>/admin/timetable">Schema</a>
			<?php endif; ?>
		</div>
	</div>

	<div class="col-sm-6">
		<h2>Event</h2>
		<p>Data om aktuellt event lagras i NFO. Vid nytt event måste man tömma cache för att föra över nytt event.</p>
		<?php global $event; ?>
		<pre><?=json_encode($event->as_json(), JSON_PRETTY_PRINT);?></pre>
		<form action="<?=url('/admin/event')?>" method="post">
			<button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-refresh"></span> Ladda om event-data</button>
		</form>
	</div>
</div>
