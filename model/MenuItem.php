<?php

class MenuItem {
	private $href, $name;

	public function __construct($href, $name) {
		$this->href = $href;
		$this->name = $name;
	}

	public function render($sel) {
		global $root;

		$meh = explode('/', $this->href);
		array_shift($meh);

		if($sel == $meh[0] or ($sel == "main" and $this->href == "/main")) {
			$class = "active";
		} else {
			$class = "";
		}
		echo'<li class="'.$class."\"> <a href=\"{$root}{$this->href}\"> ".$this->name.' </a> </li>';
	}

	public function getLink() {
		return $this->href;
	}
	public function getName() {
		return $this->name;
	}
}
