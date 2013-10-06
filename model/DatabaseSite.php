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
