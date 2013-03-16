<?php

class ESportController extends Controller {
	public function index() {
		return $this->render('index');
	}

	public function LoL() {
		return $this->render('LoL');
	}

	public function mc() {
		return $this->render('mc');
	}

	public function sc2() {
		return $this->render('sc2');
	}

	public function tibia() {
		return $this->render('tibia');
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
