<ol class="breadcrumb">
  <li><a href="<?=$root?>/">NFO</a></li>
  <li class="active"">Admin</li>
</ol>

<h2> Administration - Var försiktig! </h2>

<div class="row">
	<div class="col-sm-6">
		<p> Välkommen till administrationssidan, du kan välja vad du vill göra nedan: </p>
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
</div>
