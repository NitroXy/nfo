<?php
/*
	Most of things copied from mvc_rewrite Path class
*/

class Path {
	private $filename = false;
	private $controller = false;
	private $args = NULL;
	private $raw_path;

	static public function from_path_info() {
		$parts = isset($_SERVER['PATH_INFO']) ? explode('/', rtrim($_SERVER['PATH_INFO'], '/')) : array('', 'main');
		array_shift($parts);
		array_shift($parts);

		$filename = array_pop($parts);
		$pathinfo = pathinfo($filename);
		array_push($parts, $pathinfo['filename']);

		$path = new Path;
		$path->controller = basename(array_shift($parts));
		$path->args = $parts;
		$path->filename = "../controllers/{$path->controller}.php";
		$path->raw_path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : "main";
		return $path;
	}

	public function filename(){ return $this->filename; }
	public function controller(){ return $this->controller; }
	public function args(){ return $this->args; }
	public function raw_path(){ return $this->raw_path; }
}
