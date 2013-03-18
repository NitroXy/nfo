<?php

class ESportController extends Controller {
	public function route($path) {
		if(empty($path)) {
			return $this->index();
		}

		/* Fetch from database */
		$item = DatabaseSite::from_name('esport', $path[0]);
		if(!isset($item))
			throw new HTTPError404();
		return $item->render();
	}

	public function index() {
		return $this->render('index');
	}

	public function BuildSubMenu() {
		//TODO: Add some code that fixes this through database?!
		$submenu = new Menu();
		$submenu->AddItem("/esport/LoL", "League of Legends");
		$submenu->AddItem("/esport/mc", "Minecraft");
		$submenu->Additem("/esport/sc2", "Starcraft II");
		$submenu->AddItem("/esport/tibia", "Tibia");
		return $submenu;
	}
}

?>
