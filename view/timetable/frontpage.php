<h2>NitroXy Schema: </h2>
<div id="schedule" class="schedule-days-<?=count($days)?>">

<?php $hour_height = 30; ?>

<style type="text/css">
	.schedule-content {
		height: <?=$hour_height*24 ?>px;
	}
</style>

<?php foreach ( $days as $day_index => $day ): ?>
	<div class="schedule-day scedule-day-col-<?=$day->columns?>">
		<div class="schedule-day-header">
			<h3>Dag <?=$day_index+1?> <small><?=strftime('%A, %d %b', $day->begin)?></small></h3>
		</div>
		<div class="schedule-content">
			<?php foreach($day->items as $item): ?>
				<?php $bg = implode(',', $item->background); ?>
				<div class="schedule-item schedule-item-<?=$item->luminance>160?'dark':'light'?>" style="width: <?=$item->size?>%; height: <?=$hour_height * $item->hours + 1?>px; top: <?=$hour_height * $item->start - 1?>px; left: <?=$item->offset?>%; background: linear-gradient(rgba(<?=$bg?>, 1), rgba(<?=$bg?>,0.8));">
					<?=$item->data->text?>
				</div>
			<?php endforeach ?>
		</div>
	</div>
<?php endforeach; ?>

<?php
/*
  <table class="timetable" cellspacing="0" cellpadding="0" border="0">
		<colgroup>
			<col width="80"/>
			<?php foreach ( array_keys($slots) as $_ ): ?>
				<col/>
			<?php endforeach; ?>
		</colgroup>
		<thead>
    <tr>
      <th>Timma</th>
			<?php foreach ( array_keys($slots) as $day ): ?>
        <th>
					Dag <?=$day+1?><br/>
					<small><?=strftime('%A', $this->timestamp_from_days($day + $start))?></small>
				</th>
      <?php endforeach; ?>
    </tr>
		</thead>
		<tbody>
			<?php for ( $hour = 0; $hour < 24; $hour++ ): ?>
				<tr>
					<th><?=sprintf('%02d:00', $hour)?></th>
					<?php foreach ( $slots as $rows ): ?>
						<?php $items = $rows[$hour]; $n = count($items) ?>
						<td class="<?php if ( $n > 0 ): ?>has-item overlap-<?=$n?><?php endif; ?>">
							<?php foreach ( $items as $item ): ?>
								<div class="item item-<?=$item->luminance>160?'dark':'light'?><?php if ( $item->first ) echo ' first' ?>" style="background-color: <?=$item->background?>;">
									<?php if ( $item->first ): ?>
									<span class="icon"></span>
	<span class="visible-xs"><?=$item->short_name?></span>
										<span class="hidden-xs"><?=$item->text?></span>
									<?php else: ?>
										&nbsp;
									<?php endif; ?>
								</div>
							<?php endforeach ?>
						</td>
					<?php endforeach; ?>
				</tr>
			<?php endfor; ?>
		</tbody>
  </table>
  */
  ?>
</div>
