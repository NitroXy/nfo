<?php

class MenuItem {
	private $href, $name;

	public function __construct($href, $name) {
		$this->href = $href;
		$this->name = $name;
	}

	public function render($sel) {
		$meh = explode('/', $this->href);
		array_shift($meh);

		if($sel == $meh[0] or ($sel == "main" and $this->href == "/main")) {
			$class = "active";
		} else {
			$class = "";
		}
		echo'<li class="'.$class.'"> <a href="'.$this->href.'"> '.$this->name.' </a> </li>';
	}

	public function getLink() {
		return $this->href;
	}
	public function getName() {
		return $this->name;
	}
}

class Menu {
	private $menu_name = "menu";
	private $items = array();

	public function AddItem($href, $name) {
		array_push($this->items, new MenuItem($href, $name));
	}
	public function AddSubMenu($menu) {
		array_push($this->items, $menu);
	}
	public function AddItemAtOrder($href, $name, $pos) {
		$tmp = array();

		$cur_pos = 0;
		foreach($this->items as $it) {
			$cur_pos += 1;
			if($cur_pos == $pos) {
				array_push($tmp, new MenuItem($href, $name));
			}

			array_push($tmp, $it);
		}

		$this->items = $tmp;
	}

	public function render($sel, $c = 'nav') {
		$ob = false;
		if(!ob_get_status()) {
			ob_start();
			$ob = true;
		}

		if($c == 'nav') {
			echo '<div class="navbar navbar-default"> <div class="navbar-inner"> <div class="container">';
			echo '<ul class="nav navbar-nav">';
		} else {
			echo "<ul class=\"".$c."\" role=\"menu\" aria-labelledby=\"dLabel\">";
		}

		foreach($this->items as $i) {
			if(get_class($i) == 'Menu') {
				$class = "";
				if(count($i->getItems()) > 0) {
					$items = $i->getItems();
					$meh = explode('/', $items[0]->getLink());
					array_shift($meh);

					if($meh[0] == $sel) {
						$class = "active";
					}
				}

				echo '<li class="dropdown '.$class.'">';
				echo '<a class="dropdown-toggle" role="menu" data-toggle="dropdown" href="#">';
				echo $i->menu_name.'<span class="caret"></span>';
				echo '</a>';
				$i->render('', 'dropdown-menu submenu');
				echo '</li>';
			} else {
				$i->render($sel);
			}
		}
		echo "</ul>";
		if($c == 'nav') {
			echo '</div></div></div>';
		}

		if($ob) {
			$content = ob_get_contents();
			ob_end_clean();
		} else {
			$content = "";
		}

		return $content;
	}

	public function setMenuName($na) {
		$this->menu_name = $na;
	}
	public function getItems() {
		return $this->items;
	}
}

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
