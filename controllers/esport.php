<?php

class ESportController extends Controller {
	public function index() {
		return $this->render('index');
	}

	public function test() {
		return $this->render('test');
	}

	public function BuildSubMenu() {
		//TODO: Add some code that fixes this through database?!
		$submenu = new Menu();
		$submenu->AddItem("/esport/test", "Test länk", "esport/test");
		return $submenu;
	}
}

?>
