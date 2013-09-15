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
                    echo '<div class="navbar"> <div class="navbar-inner"> <div class="container">';
                    echo '<ul class="nav navbar-nav">';
                } else {
                    echo "<ul class=\"".$c."\" role=\"menu\" aria-labelledby=\"dLabel\">";
                }

		foreach($this->items as $i) {
                        if(get_class($i) == 'Menu') {
                                //Render as a nice menu
                                echo '<li class="dropdown">';
                                    echo '<a class="dropdown-toggle" role="menu" data-toggle="dropdown" href="#">';
                                        echo $i->menu_name.'<span class="caret"></span>';
                                    echo '</a>';
                                $i->render($sel, 'dropdown-menu submenu');
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
}

class DatabaseMenu extends Menu {
    public function __construct() {
        //Update and sort from database
        $sites = DatabaseSite::selection(array("@order" => "display_order"));
        foreach($sites as $site) {
            $this->AddItem("/", $site->name, $site->display_name);
        }
    }
}

?>
