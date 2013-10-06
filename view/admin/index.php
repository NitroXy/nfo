<h2> Administration - Var försiktig! </h2>
<p> Välkommen till administrationssidan, du kan välja vad du vill göra nedan: </p>
<div class="list-group">
        <? if(has_right('Sido-moderator')) { ?>
            <a class="list-group-item" href="/admin/edit"> Redigera sidor </a> 
        <? } ?>

        <? if(has_right('Bild-moderator')) { ?>
            <a class="list-group-item" href="/admin/images"> Hantera bilder </a> 
        <? } ?>

        <? if(has_right('Nyhets-moderator')) { ?>
            <a class="list-group-item" href="/admin/news"> Hantera nyheter </a> 
        <? } ?>

        <? if(has_right('Schema-moderator')) { ?>
            <a class="list-group-item" href="/admin/timetable"> Hantera schema </a>
        <? } ?>
</div>

<h3> Förklaringar: </h3>
<p> I <i>"Redigera sidor"</i> kan du ändra på sidornas text samt vilka bilder som syns. </p>
<p> I <i>"Hantera bilder"</i> kan du ladda upp eller ta bort bilder som <b>kan</b> visas på hemsidan, dvs. bilder som du kan använda i antingen sidorna eller dina nyhetsinlägg. </p>
<p> I <i>"Hantera nyheter"</i> kan du ändra befintliga nyheter eller skapa nya </p>
<p> I <i>"Hantera schema"</i> kan du ändra befintliga schemainlägg eller skapa nya </p>
