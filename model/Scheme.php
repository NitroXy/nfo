<?php

class SchemeItem extends ValidatingBasicObject {
	protected static function table_name() {
		return "scheme_items";
	}

	public static function all() {
		return static::selection(array("@order" => "timestamp"));
	}

	public function validation_hooks(){
		$this->validate_presence_of('timestamp');
		$this->validate_presence_of('text');
	}

	public function render() {
		return "<div class=\"scheme_item\"><span class=\"datetime\">{$this->timestamp}</span><a href=\"{$this->href}\"> <span>{$this->text}</span></a></div>";
	}
}

?>
