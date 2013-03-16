<?php

class NewsItem extends BasicObject {
	protected static function table_name() {
		return "news";
	}

	public static function all() {
		return static::selection(array());
	}

	public function render() {
		return "<div class=\"newsitem\"><h3>{$this->topic}</h3><span>{$this->text}</span></div>";
	}
}

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


?>
