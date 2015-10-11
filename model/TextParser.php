<?php

use \Michelf\MarkdownExtra;

class TextParser {
	public static function transform($raw){
		$markdown = new MarkdownExtra();
		$markdown->no_markup = false;
		$markdown->nl2br = true;
		return $markdown->transform($raw);
	}
}
