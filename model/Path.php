<?php

class Path {
	private $filename = false;
	private $controller = false;
	private $args = NULL;

	static public function from_path_info() {
		global $repo_root;

		$parts = isset($_SERVER['PATH_INFO']) ? explode('/', rtrim($_SERVER['PATH_INFO'], '/')) : array('', 'timetable');
		array_shift($parts);
		//array_shift($parts);
		$filename = array_pop($parts);
		$pathinfo = pathinfo($filename);
		array_push($parts, $pathinfo['filename']);

		$path = new Path;
		$path->controller = basename(array_shift($parts));
		$path->args = $parts;
		$path->filename = "$repo_root/controllers/{$path->controller}.php";
		$path->raw_path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : "timetable";
		return $path;
	}

	public function filename(){ return $this->filename; }
	public function controller(){ return $this->controller; }
	public function args(){ return $this->args; }
}
