<h3> Välj schemaelement </h3>
<a class="btn btn-success" href="/admin/timetable_add">Lägg till</a>
<div style="margin-top: 20px;" class="list-group">
    <?php foreach($meh as $it) { ?>
    <a class="list-group-item" href="/admin/timetable/<?=$it->id?>"><?=$it->timestamp?> - <?=$it->text?></a>
    <?php } ?>
</div>
