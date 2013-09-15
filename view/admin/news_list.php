<h2> Hantera nyheter </h2>
<a class="btn btn-success" href="/admin/news_add"> Lägg till nyhet </a>
<div style="margin-top: 20px;" class="list-group">
<?php
	foreach($news as $n) { ?>
            <a class="list-group-item" href="/admin/news/<?=$n->id?>"> <?=$n->timestamp?> - <?=$n->topic?> </a>
<?  } ?>
<a style="margin-top: 20px;" class="btn btn-default" href="/admin"> Tillbaka </a>
