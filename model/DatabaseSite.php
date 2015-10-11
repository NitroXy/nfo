<?php

use \Michelf\MarkdownExtra;

class DatabaseSite extends ValidatingBasicObject {
	protected static function table_name() {
		return "databasesite";
	}

	public function validation_hooks(){
		$this->validate_presence_of('display_name');
	}

	public static function from_only_name($name) {
		return from_field('name', $name);
	}

	public static function from_name($name, $href) {
		return static::first(array('name' => $name, 'href' => $href));
	}

	public function formatted_text() {
		return static::with_tmp_htmlspecialchars(false, function(){
			return TextParser::transform($this->text);
		});
	}
}
