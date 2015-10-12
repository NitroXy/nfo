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

	public function get_color(){
		if ( $this->preset_id ){
			return $this->SchemePreset->color;
		} else {
			return $this->color;
		}
	}

	public function have_icon(){
		if ( $this->preset_id ){
			return $this->SchemePreset->have_icon();
		} else {
			return false;
		}
	}

	public function __get($key){
		switch($key){
			case 'icon_url':
				return url('/preset/:id/icon', $this->preset_id);
			case 'begin':
				return static::to_timestamp($this->timestamp);
			case 'end':
				return static::to_timestamp($this->timestamp) + $this->duration*3600;
			default:
				return parent::__get($key);
		}
	}

	public function render() {
		return "<div class=\"scheme_item\"><span class=\"datetime\">{$this->timestamp}</span><a href=\"{$this->href}\"> <span>{$this->text}</span></a></div>";
	}

	private static function to_timestamp($date) {
		return strtotime($date);
	}
}
