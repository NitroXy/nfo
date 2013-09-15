<h3> Lägg till nyhet </h3>
<form method="post" action="/admin/news_add">
    <div style="padding-top: 5px; padding-bottom: 5px;" class="input-group">
        <span class="input-group-addon"> Rubrik </span>
        <input type="text" name="topic" class="form-control"/>
    </div>
    
    <textarea class="form-control" name="text" id="text" rows="30"></textarea>

    <a style="margin-top: 15px" class="btn btn-success" href="#" onclick="image_add()">Infoga bild</a>
    <a style="margin-top: 15px;" class="btn btn-warning" href="#" onclick="preview()">Förhandsgranska</a>
    <input style="margin-top: 15px;" class="btn btn-info" type="submit" value="Spara"/>

</form>
