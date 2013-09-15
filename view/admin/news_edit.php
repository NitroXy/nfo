<h2> Redigera nyhet </h2>
<p><b> Notera: när du ändrar en nyhet så läggs den längst upp på listan över nyheter </b></p>
<form method="post" action="/admin/news/<?=$n->id?>">
    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Rubrik </span>
        <input type="text" name="topic" class="form-control" value="<?=$n->topic?>"/>
    </div>
    
    <textarea class="form-control" name="text" id="text" rows="30"><?=$n->text?></textarea>

    <a style="margin-top: 15px" class="btn btn-success" href="#" onclick="image_add()">Infoga bild</a>
    <a style="margin-top: 15px;" class="btn btn-warning" href="#" onclick="preview()">Förhandsgranska</a>
    <input style="margin-top: 15px;" class="btn btn-info" type="submit" value="Spara"/>
    
    <a style="margin-top: 15px; float: right" class="btn btn-danger" href="/admin/news_del/<?=$n->id?>">Ta bort</a>

    <br>
    <a style="margin-top: 15px;" class="btn btn-default" href="/admin/news/">Tillbaka</a>
</form>

