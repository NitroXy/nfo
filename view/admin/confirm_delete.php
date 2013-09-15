<h2> Ta bort bild </h2>
<p> Vill du verkligen ta bort bilden "<?=$image?>" ? </p>
<form method="post" action="/admin/image_del?img=<?=$image?>">
	<input type="submit" value="Ja"/>
</form>
<form method="post" action="/admin/images">
	<input type="submit" value="Nej"/>
</form>
