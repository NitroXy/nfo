<h2> Ta bort sida </h2>
<p> Vill du verkligen ta bort sidan "<?=$s->display_name?>"? </p>
<form method="post" action="/admin/delete/<?=$s->id?>">
	<input class="btn btn-danger" type="submit" class="button" value="Ja"/>
        <a class="btn btn-success" href="/admin/edit/<?=$s->id?>">Nej</a>
</form>
