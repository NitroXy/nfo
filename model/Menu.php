<?php

class MenuItem {
	private $href, $name;

	public function __construct($href, $name) {
		$this->href = $href;
		$this->name = $name;
	}

	public function render($sel) {
		if($sel == $this->href or ($sel == "main" and $this->href == "/main")) {
			$class = "selected";
		} else {
			$class = "";
		}
		echo'<li> <a class="'.$class.'" href="'.$this->href.'"> '.$this->name.' </a> </li>';
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

	public function render($sel, $c = 'nav nav-tabs') {
                $ob = false;
                if(!ob_get_status()) {
                    ob_start();
                    $ob = true;
                }

		echo "<ul class=\"".$c."\" role=\"menu\" aria-labelledby=\"dLabel\">";
		foreach($this->items as $i) {
                        if(get_class($i) == 'Menu') {
                                //Render as a nice menu
                                echo '<li class="dropdown">';
                                    echo '<a class="dropdown-toggle" role="menu" data-toggle="dropdown" href="#">';
                                        echo $i->menu_name.'<span class="caret"></span>';
                                    echo '</a>';
                                $i->render($sel, 'dropdown-menu submenu push-left');
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
}

?>
