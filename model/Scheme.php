<?php

class SchemeItem extends BasicObject {
	protected static function table_name() {
		return "scheme_items";
	}

	public static function all() {
		return static::selection(array());
	}
	public static function from_day($day)
	{
		//Todo!
	}

	public function render() {
		return "<div class=\"scheme_item\"><span class=\"datetime\">{$this->timestamp}</span><a href=\"{$this->href}\" <span>{$this->text}</span></a></div>";
	}
}

?>
