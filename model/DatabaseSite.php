<?php
require_once "../libs/php-markdown/Michelf/Markdown.php";
require_once "../libs/php-markdown/Michelf/MarkdownExtra.php";
use \Michelf\MarkdownExtra;

class DatabaseSite extends BasicObject {
	protected static function table_name() {
		return "databasesite";
	}

	public static function from_only_name($name) {
		return from_field('name', $name);
	}

	public static function from_name($name, $href) {
		return static::first(array('name' => $name, 'href' => $href));
	}

	public function render() {
		if($this->text_type == "HTML") {
			return $this->text;
		} else { //Default markdown
			$markdown = new MarkdownExtra();

			$markdown->no_markup = true;
			$markdown->nl2br = true;

			return html_entity_decode($markdown->transform($this->text), ENT_QUOTES, "UTF-8");
		}
	}
}

?>
