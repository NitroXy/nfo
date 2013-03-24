<?
$item_length = count($names);
for($i = 0; $i < $item_length; $i++) {
?>
	<h3>Du redigerar '<?=$names[$i]?>'</h3>
	<form method="post" action="/admin/update/<?=$mainname?>/<?=$names[$i]?>">
		<textarea cols="80" rows=20" name="text"> <?=$contents[$i]?> </textarea>
		<br>
		<input type="submit" value="Spara"/>
	</form>
<? } ?>
