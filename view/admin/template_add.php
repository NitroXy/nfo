<h2> Redigerar schemaelement </h2>
<p> Notera: att när du skriver in tiden inkluderar detta datum i detta format "YYYY-MM-DD h:mm:ss" (om detta är oklart fråga Tech)</p>
<form method="post" action="/admin/timetable_add">
    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Tid </span>
        <input type="text" name="timestamp" class="form-control"/>
    </div>
    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Text </span>
        <input type="text" name="text" class="form-control"/>
    </div>
    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Länk </span>
        <input type="text" name="href" class="form-control"/>
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
    
    <br>
    <a style="margin-top: 15px;" class="btn btn-default" href="/admin/timetable/">Tillbaka</a>
</form>
