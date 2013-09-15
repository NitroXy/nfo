<h3> Redigerar sidan '<?=$s->name?> - <?=$s->display_name?>' </h3>

<p> Sidorna använder <a href="http://daringfireball.net/projects/markdown/"> Markdown</a>, guide till syntax är <a href="https://nitroxy.com/formatting.php"> här</a>. </p>

<form method="post" action="/admin/edit/<?=$id?>"/>
    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Namn </span>
        <input type="text" name="name" class="form-control" value="<?=$s->display_name?>"/>
    </div>

    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Position </span>
        <input type="text" name="order" class="form-control" value="<?=$s->display_order?>"/>
    </div>

    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Länk </span>
        <input type="text" name="href" class="form-control" disabled value="<?=$s->name?>"/>
    </div>
    
    <textarea class="form-control" name="text" id="text" rows="30"><?=$s->text?></textarea>

    <a style="margin-top: 15px" class="btn btn-success" href="#" onclick="image_add()">Infoga bild</a>
    <a style="margin-top: 15px;" class="btn btn-warning" href="#" onclick="preview()">Förhandsgranska</a>
    <input style="margin-top: 15px;" class="btn btn-info" type="submit" value="Spara"/>
    
    <a style="margin-top: 15px; float: right" class="btn btn-danger" href="/admin/delete/<?=$s->id?>">Ta bort</a>

    <br>
    <a style="margin-top: 20px;" class="btn btn-default" href="/admin/edit">Tillbaka</a>
</form>
