<?php

class NewsItem extends BasicObject {
	protected static function table_name() {
		return "news";
	}

	public static function all() {
		return static::selection(array("@order" => "timestamp"));
	}

	public function render() {
		return "<div class=\"newsitem\"><h3>{$this->topic}</h3><span>{$this->text}</span></div>";
	}
}
