<?php

class DatabaseSite extends BasicObject {
	protected static function table_name() {
		return "databasesite";
	}

	public static function from_name($name, $href) {
		$sel = static::selection(array('name' => $name, 'href' => $href));

		if(empty($sel)) {
			return null;
		}

		return $sel[0];
	}

	public function render() {
		return html_entity_decode($this->text);
	}
}

?>
