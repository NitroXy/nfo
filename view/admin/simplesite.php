<h3> Riktlinjer </h3>
<p> Du redigerar här med något som kallas för Markdown. <a href="https://nitroxy.com/formatting.php">Här</a> är en snabbguide.

<p> Länkar som referrerar till en annan del på <u>denna</u> sidan <b>bör</b> skrivas på liknande sätt: </p>
<div class="well well-sm">
	/esport
</div>
<p> För att inte länkarna skall förstöras vid förflyttning utav sidan. </p>
<hr>
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
