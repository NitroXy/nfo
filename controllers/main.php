<?php

class MainController extends Controller {
	public function index() {
		return Newsfeed::Render();
	}
}
?>
