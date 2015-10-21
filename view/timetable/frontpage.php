<?php $hour_height = 30; ?>
<style type="text/css">
.schedule-content {
	height: <?=$hour_height*24 ?>px;
}
.schedule-clock {
	height: <?=$hour_height?>px;
	line-height: <?=$hour_height?>px;
}
</style>

<div id="schedule" class="schedule-days-<?=count($days)?>">
	<h2>NitroXy Schema</h2>
	<?php foreach ( $days as $day_index => $day ): ?>
		<div class="schedule-day scedule-day-col-<?=$day->columns?>">
			<div class="schedule-day-header">
				<a href="#schedule-day-<?=$day_index?>" data-toggle="collapse" data-parent="#schedule" class="">
					<span class="pull-right glyphicon glyphicon-chevron-down"></span>
					<h3>Dag <?=$day_index+1?> <small><?=strftime('<span>%A,</span> <span>%d %b</span>', $day->begin)?></small></h3>
				</a>
			</div>
			<div class="schedule-content collapse" id="schedule-day-<?=$day_index?>" style="height: 0px;">
				<div class="schedule-inner">
					<?php for ( $i = 0; $i < 24; $i++ ): ?>
						<p class="schedule-clock"><span><?=sprintf('%02d:00', ($i+4)%24)?></span></p>
					<?php endfor; ?>
					<?php foreach($day->items as $item): ?>
						<?php $bg = implode(',', $item->background); ?>
						<div class="<?=$this->item_classes($item);?>" style="height: <?=$hour_height * $item->hours + 1?>px; top: <?=$hour_height * $item->start - 1?>px; left: <?=$item->offset?>%; background: <?php if ( $item->data->have_icon() ): ?>url(<?=$item->data->icon_url?>) no-repeat top 5px right 5px, <?php endif; ?>linear-gradient(rgba(<?=$bg?>, 1), rgba(<?=$bg?>,0.8));">
							<?=$item->data->text?>
						</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
