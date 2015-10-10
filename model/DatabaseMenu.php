<?php

class DatabaseMenu extends Menu {
	public function __construct() {
		//Update and sort from database
		$s = DatabaseSite::selection(array("@order" => "display_order"));

		//Rebuild to include the several names for dropdowns ...
		$sites = array();
		foreach($s as $e) {
			if(isset($sites[$e->name])) {
				if(is_array($sites[$e->name])) {
					array_push($sites[$e->name], $e);
				} else {
					$sites[$e->name] = array($sites[$e->name], $e);
				}
			} else {
				$sites[$e->name] = $e;
			}
		}

		foreach($sites as $site) {
			if(is_array($site)) {
				$submenu = new Menu;
				foreach($site as $e) {
					if($e->href == "index") {
						$submenu->setMenuName($e->display_name);
					} else {
						$submenu->AddItem('/'.$e->name.'/'.$e->href, $e->display_name);
					}
				}
				$this->AddSubMenu($submenu);
			} else {
				$this->AddItem('/'.$site->name, $site->display_name);
			}
		}
	}
}
