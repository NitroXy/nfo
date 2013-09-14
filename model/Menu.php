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
	private $items = array();

	public function AddItem($href, $name) {
		array_push($this->items, new MenuItem($href, $name));
	}

	public function render($sel) {
		ob_start();

		echo "<ul class=\"nav nav-tabs nav-justified\">";
		foreach($this->items as $i) {
			$i->render($sel);
		}
		echo "</ul>";

		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}

?>
