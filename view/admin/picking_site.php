<h3> Välj sida att redigera </h3>
<div class="list-group">
<?php
    foreach($sites as $site) { ?>
        <a class="list-group-item" href="/admin/edit/<?=$site->id?>"> <?=$site->name?> - <?=$site->display_name?> </a>
<?php  } ?>
</div>

<a href="/admin/add" class="btn btn-default"> Lägg till sida </a>
<a href="/admin" style="float: right" class="btn btn-default btn-sm"> Tillbaka </a>
