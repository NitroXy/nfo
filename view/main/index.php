<? foreach($newsfeed as $n) { ?>
<div class="newsitem">
	<h2> <?=$n['topic']?> </h2>
	
	<!-- Markdown parsed text -->
	<p> <?=$n['text']?> </p>

	<div class="small">
		<span> skriven </span>
		<span class="date"><?=$n['timestamp']?> </span>
		,
		<span class="name"><?=$n['name']?> </span>
	</div>
	<hr>
</div>
<? } ?>
