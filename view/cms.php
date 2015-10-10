<?php if(has_right('Sido-moderator')): ?>
	<div class="cms-admin panel panel-default">
		<div class="panel-heading">CMS</div>
		<div class="panel-body">
			<ul>
				<li><a href="<?=$root?>/admin/edit/<?=$id?>" class="cms-edit">Redigera</a></li>
			</ul>
		</div>
	</div>
<?php endif; ?>

<div class="cms">
	<?=$content?>
</div>
