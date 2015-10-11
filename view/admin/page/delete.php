<h2> Ta bort sida </h2>
<p> Vill du verkligen ta bort sidan "<?=$s->display_name?>"? </p>
<form method="post" action="<?=url('/admin/delete/:id', $s->id)?>">
	<input class="btn btn-danger" type="submit" class="button" value="Ja"/>
	<a class="btn btn-success" href="<?=url('/admin/edit/:id', $s->id)?>">Nej</a>
</form>
