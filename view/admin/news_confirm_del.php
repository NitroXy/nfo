<h2> Ta bort nyhet </h2>
<p> Vill du verkligen ta bort nyheten "<?=$n->topic?>"? </p>
<form method="post" action="/admin/news_del/<?=$n->id?>">
	<input class="btn btn-danger" type="submit" value="Ja"/>
        <a href="/admin/news" class="btn btn-success">Nej</a>
</form>
