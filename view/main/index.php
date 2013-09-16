<? foreach($newsfeed as $n) { ?>
    <div class="span8">
        <h2> <?=$n['topic']?> </h2>
        <p> <?=$n['text']?> </p> 
        
        <div>
            <span style="float: right" class="label label-primary"> skriven <?=$n['timestamp']?>, utav <?=$n['name']?> </span>
        </div>
        <div style="clear:both"></div>
    </div>
<? } ?>
