<?php
require_once "../libs/php-markdown/Michelf/Markdown.php";
require_once "../libs/php-markdown/Michelf/MarkdownExtra.php";
use \Michelf\MarkdownExtra;

class MainController extends Controller {
	public function index() {
		$newsfeed = NewsItem::all();

		$markdown = new MarkdownExtra();
		$markdown->no_markup = true;
		$markdown->nl2br = true;

		$news = array();
		foreach($newsfeed as $n) {
			$text =  html_entity_decode($markdown->transform($n->text), ENT_QUOTES, "UTF-8");
			$news[] = array(
					'topic' => $n->topic,
					'text' => $text,
					'name' => $n->name,
					'timestamp' => $n->timestamp);
		}

		return $this->render('index', array('newsfeed' => $news));
	}

	public function view($id = null) {
		if(!isset($id)) {
			throw new HTTPRedirect('/news');
		}

		$new = NewsItem::from_id($id);
		if(!isset($new)) {
			return '<p class="error">Kan inte hitta nyhet med id='.$id.'</p>';
		}

		$markdown = new MarkdownExtra();
		$markdown->no_markup = true;
		$markdown->nl2br = true;
		$text = html_entity_decode($markdown->transform($new->text), ENT_QUOTES, "UTF-8");
		$n = array(
				'topic' => $new->topic,
				'text' => $text,
				'name' => $new->name,
				'timestamp' => $new->timestamp);

		return $this->render('view', array('n' => $n));
	}
}

?>
