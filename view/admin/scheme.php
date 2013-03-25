<h4> Välj schema element att ändra </h4>
<?php
foreach($items as $item) { ?>
	<p> 
		<div class="scheme_item">
			<span class="datetime"><?=$item->timestamp?></span> 
			<a href="/admin/scheme/<?=$item->id?>"> <?=$item->text?> </a>
		</div>
	</p>
<? } ?>
<a href="/admin/add"> Lägg till </a>

