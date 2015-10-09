<?php

class Path {
	private $filename = false;
	private $controller = false;
	private $args = NULL;
	private $format = NULL;

	/**
	 * Use `from_path_info`.
	 */
	private function __construct(){

	}

	static public function from_path_info(){
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
		$path->format = isset($pathinfo['extension']) ? $pathinfo['extension'] : null;
		return $path;
	}

	public function filename(){ return $this->filename; }
	public function controller(){ return $this->controller; }
	public function args(){ return $this->args; }
	public function format(){ return $this->format; }
	public function force_format($format){ $this->format = $format; }
}
