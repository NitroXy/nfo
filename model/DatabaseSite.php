<?php
require_once "../libs/php-markdown/Michelf/Markdown.php";
require_once "../libs/php-markdown/Michelf/MarkdownExtra.php";
use \Michelf\MarkdownExtra;

class DatabaseSite extends BasicObject {
	protected static function table_name() {
		return "databasesite";
	}

	public static function from_only_name($name) {
		$sel = static::selection(array('name' => $name));

		if(empty($sel)) {
			return null;
		}

		return $sel[0];
	}

	public static function from_name($name, $href) {
		$sel = static::selection(array('name' => $name, 'href' => $href));

		if(empty($sel)) {
			return null;
		}

		return $sel[0];
	}

	public function render() {
		return html_entity_decode($this->text, ENT_QUOTES, "UTF-8");
	}
}

?>
