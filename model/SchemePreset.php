<?php

class SchemePreset extends ValidatingBasicObject {
	protected static function table_name() {
		return "scheme_presets";
	}

	public static function all() {
		return static::selection(array("@order" => "name"));
	}

	public function validation_hooks(){
		$this->validate_presence_of('name');
		$this->validate_uniqueness_of('name');
		$this->validate_presence_of('color');
	}

	public function render() {
		return "<div class=\"scheme_item\"><span class=\"datetime\">{$this->timestamp}</span><a href=\"{$this->href}\"> <span>{$this->text}</span></a></div>";
	}
}

?>
