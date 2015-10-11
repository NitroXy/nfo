<?php

class MainController extends Controller {
	public function index() {
		$newsfeed = NewsItem::all();

		$news = array();
		foreach($newsfeed as $n) {
			$text =  TextParser::transform($n->text);
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

		$n = array(
				'topic' => $new->topic,
				'text' => TextParser::transform($new->$text),
				'name' => $new->name,
				'timestamp' => $new->timestamp);

		return $this->render('view', array('n' => $n));
	}
}
