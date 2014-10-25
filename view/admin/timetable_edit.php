<?php
?>
<h2> Redigerar schemaelement </h2>
<form method="post" action="/admin/timetable/<?=$it->id?>">
    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Tid </span>
        <input type="text" name="timestamp" class="form-control" value="<?=$it->timestamp?>"/>
    </div>
    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Text </span>
        <input type="text" name="text" class="form-control" value="<?=$it->text?>"/>
    </div>
    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Länk </span>
        <input type="text" name="href" class="form-control" value="<?=$it->href?>"/>
    </div>
    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Timmar det håller på </span>
        <input type="text" name="duration" class="form-control" value="<?=$it->duration?>"/>
    </div>
    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Färgkod (ex. '#aaa') </span>
        <input type="text" name="color" class="form-control" value="<?=$it->color?>"/>
    </div>

    <input style="margin-top: 15px;" class="btn btn-info" type="submit" value="Spara"/>
    <a href="/admin/timetable_del/<?=$it->id?>" class="btn btn-danger" style="margin-top:15px;float:right;">Ta bort</a>
    
    <br>
    <a style="margin-top: 15px;" class="btn btn-default" href="/admin/timetable/">Tillbaka</a>
</form>
