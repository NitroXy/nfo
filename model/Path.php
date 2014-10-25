<?php
/*
	Most of things copied from mvc_rewrite Path class
*/

class Path {
	private $filename = false;
	private $controller = false;
	private $args = NULL;
	private $raw_path;
        private $raw_parts;

	static public function from_path_info() {
		$parts = isset($_SERVER['PATH_INFO']) ? explode('/', rtrim($_SERVER['PATH_INFO'], '/')) : array('', 'timetable');
		array_shift($parts);
		array_shift($parts);
                $raw_parts = $parts;

                if(empty($parts)) {
                    $parts = array('timetable');
                }

		$filename = array_pop($parts);
		$pathinfo = pathinfo($filename);
		array_push($parts, $pathinfo['filename']);

		$path = new Path;
		$path->controller = basename(array_shift($parts));
		$path->args = $parts;
		$path->filename = "../controllers/{$path->controller}.php";
		$path->raw_path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : "timetable";
                $path->raw_parts = $raw_parts;
		return $path;
	}

	public function filename(){ return $this->filename; }
	public function controller(){ return $this->controller; }
	public function args(){ return $this->args; }
	public function raw_path(){ return $this->raw_path; }
        public function raw_parts(){ return $this->raw_parts; }
}
