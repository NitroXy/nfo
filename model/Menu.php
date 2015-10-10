<?php

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
