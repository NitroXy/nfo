<h2> Ta bort bild </h2>
<p> Vill du verkligen ta bort bilden "<?=$image?>" ? </p>
<form method="post" action="/admin/image_del?img=<?=$image?>">
	<input class="btn btn-success" type="submit" value="Ja"/>
</form>
<form method="post" action="/admin/images">
	<input class="btn btn-danger" type="submit" value="Nej"/>
</form>
