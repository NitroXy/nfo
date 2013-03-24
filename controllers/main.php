<?php

class MainController extends Controller {
	public function index() {
		ob_start();

		$items = SchemeItem::all();
		foreach($items as $item) {
			echo $item->render();
		}

		$content = ob_get_contents();
		ob_end_clean();

		return $this->render('frontpage', array('scheme' => $content, 'newsfeed' => '' /*Newsfeed::Render()*/));
	}
}
?>
