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

	public function as_json(){
		return [
			'name' => $this->name,
			'color' => $this->color,
		];
	}
}
