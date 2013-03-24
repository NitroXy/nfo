<h3> Admin-sida för NitroXy <?=$event?> - Info </h3>
<p> Välj nedan vilken sida du vill redigera </p>
<ul class="select_menu">
<? foreach($entries as $entry) { ?>
	<li><a href="/admin/<?=$entry?>"> <?=$entry?> </a></li>
<? } ?>
</ul>
