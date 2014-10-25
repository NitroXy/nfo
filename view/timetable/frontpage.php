<div id="scheme">
	<h2>NitroXy Schema: </h2>
    <table class="timetable table">
        <tr>
            <th> Timma </th>
            <?  $i = 1;
                foreach($scheme as $d => $days) { ?>
                <th colspan="<?=$spans[$d]?>"> Dag <?=$i++?> </th>
            <? } ?>
        </tr>
        <?
            $minhour = 1;
            $maxhour = 24;

            $skipr = [ ];
            foreach($scheme as $i => $days) {
                $skipr[$i] = [ ];
            }

            for($h = $minhour; $h <= $maxhour; $h++) {
                echo "<tr>";
                echo "<td>{$h}:00</td>";
                foreach($scheme as $d => $day) {
                    if(isset($day[$h])) {
                        $txt = $day[$h][0];
                        $dur = $day[$h][1];
                        $color = $day[$h][2];
                        if($color == "") {
                            $color = "#aaa";
                        }
                        echo "<td style='background: {$color}' rowspan='{$dur}'>{$txt} ({$dur})</td>";

                        if($dur > 1) {
                            for($j = $h; $j < $h + $dur; $j++) {
                                if(!isset($skipr[$d][$j])) {
                                    $skipr[$d][$j] = 1;
                                } else {
                                    $skipr[$d][$j] += 1;
                                }
                            }
                            for($j = $skipr[$d][$h]; $j < $spans[$d]; $j++) {
                                echo "<td></td>";
                            }
                        }

                        if(isset($skipr[$d][$h])) {
                        }
                    } else { 
                        if(!isset($skipr[$d][$h])) {
                            for($j = 1; $j <= $spans[$d]; $j++) {
                                echo "<td></td>";
                            }
                        } else {
                            for($j = $skipr[$d][$h]; $j < $spans[$d]; $j++) {
                                echo "<td></td>";
                            }
                        }
                    }
                }
                echo "</tr>";
            }
        ?>
    </table>
</div>

<?
	if($newsfeed != '') { ?>
      <h3>Nyhetsflöde</h3>
      <?=$newsfeed?>
<? } ?>
