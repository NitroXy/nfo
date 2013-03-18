<?php

class ESportController extends DynamicController {
	protected static function menu_name() {
		return 'esport';
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
