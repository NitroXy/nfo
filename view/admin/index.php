<h2> Administration - Var försiktig! </h2>
<p> Välkommen till administrationssidan, du kan välja vad du vill göra nedan: </p>
<div class="list-group">
        <?php if(has_right('Sido-moderator')) { ?>
            <a class="list-group-item" href="<?=$root?>/admin/edit"> Redigera sidor </a>
        <?php } ?>

        <?php if(has_right('Bild-moderator')) { ?>
            <a class="list-group-item" href="<?=$root?>/admin/images"> Hantera bilder </a>
        <?php } ?>

        <?php if(has_right('Nyhets-moderator')) { ?>
            <a class="list-group-item" href="<?=$root?>/admin/news"> Hantera nyheter </a>
        <?php } ?>

        <?php if(has_right('Schema-moderator')) { ?>
            <a class="list-group-item" href="<?=$root?>/admin/timetable"> Hantera schema </a>
        <?php } ?>
</div>

<h3> Förklaringar: </h3>
<p> I <i>"Redigera sidor"</i> kan du ändra på sidornas text samt vilka bilder som syns. </p>
<p> I <i>"Hantera bilder"</i> kan du ladda upp eller ta bort bilder som <b>kan</b> visas på hemsidan, dvs. bilder som du kan använda i antingen sidorna eller dina nyhetsinlägg. </p>
<p> I <i>"Hantera nyheter"</i> kan du ändra befintliga nyheter eller skapa nya </p>
<p> I <i>"Hantera schema"</i> kan du ändra befintliga schemainlägg eller skapa nya </p>
