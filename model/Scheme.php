<?php

class SchemeItem extends ValidatingBasicObject {
	protected static function table_name() {
		return "scheme_items";
	}

	public static function all() {
		return static::selection(array("@order" => "timestamp"));
	}
	public static function from_day($day)
	{
		//Todo!
	}

	public function render() {
		return "<div class=\"scheme_item\"><span class=\"datetime\">{$this->timestamp}</span><a href=\"{$this->href}\"> <span>{$this->text}</span></a></div>";
	}
}

?>
