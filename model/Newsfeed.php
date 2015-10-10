<?php

class Newsfeed {
	public static function Render() {
		$items = NewsItem::all();

		ob_start();
		echo '<div id="newsfeed">';
		foreach($items as $it) {
			echo $it->render();
		}
		echo '</div>';

		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}
