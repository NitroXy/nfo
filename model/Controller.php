<?php
/*
	 Most of things from mvc_rewrite Controller class
 */

class HTTPRedirect extends Exception {
	public $url;

	public function __construct($url){
		parent::__construct();
		$this->url = $url;
	}
}

abstract class HTTPError extends Exception {
	public $code;
	public $data;

	public function __construct($code, $message=null, $data=null) {
		parent::__construct($message);
		$this->code = $code;
		$this->data = $data;
	}

	public abstract function set_http_status();
	public abstract function title();
	public abstract function message();
}

class HTTPError404 extends HTTPError {
	public function __construct() {
		parent::__construct(404);
	}

	public function set_http_status() {
		header('HTTP/1.1 404 Not Found');
	}

	public function title(){ return "404 Not Found"; }
	public function message(){ return "Sidan du försöker nå är inte tillgänglig."; }
}

class HTTPError403 extends HTTPError {
	public function __construct() {
		parent::__construct(403);
	}

	public function set_http_status() {
		header("HTTP/1.1 403 Not Found");
	}

	public function title(){ return "403 Forbidden."; }
	public function message(){ return "Du saknar behörighet till sidan du försöker nå."; }
}

/**
 * Wrapper for generating a 403 error.
 * Sample usage: "$user = User::from_id($id) or error_404();"
 */
function error_404(){
	throw new HTTPError404();
}

class Controller {
	public $name;
	protected $format;
	protected $default_format = 'html';
	private $_PASSALONG = array();

	static public function factory($path) {
		$format = $path->format();

		if(!file_exists($path->filename())) {
			//Test if a view is present
			$controller = $path->controller();
			$view = $path->args();
			$view = count($view) > 0 ? $view[0] : 'index';

			$filename = "../view/$controller/$view.php";
			if(file_exists($filename)) {
				return new SimpleController($path->controller(), $format);
			}

      $site = DatabaseSite::from_name($controller, $view);
      if(isset($site)) {
        return new DatabaseController($controller, $format);
      }

			throw new HTTPError404();
		}

		//Include the controller
		require($path->filename());
		//Create controller
		$classname = "{$path->controller()}Controller";
		return new $classname($path->controller(), $format);
	}

	public function __construct($name, $format) {
		$this->name = $name;
		$this->format = $format;
	}

	public function format(){
		return $this->format != null ? $this->format : $this->default_format;
	}

	/**
	 * Called before route, to do authentication
	 */
	public function pre_route($path) { }

	/**
	 * Check for a function named as the first index in $path, and if exists call it.
	 * Otherwise go for the 404.
	 */
	public function route($path) {
		$func = 'index';

		if(count($path) > 0) {
			$func = array_shift($path);

			/* transform foo-bar to fooBar (function names cannot contain dashes) */
			$func = preg_replace_callback('/-(.)/', function($m){ return strtoupper($m[1]); }, $func);
		}

		$func = array($this, $func);
		if(!is_callable($func)) {
			throw new HTTPError404();
		}

		return call_user_func_array($func, $path);
	}

	/**
	 * Render a view with filename $view
	 */
	public function render($view, $data=array()) {
		$path = $this->build_path_array($view);
		$this->_PASSALONG = $data;

		$filename = "../view/" . implode("/", $path);
		return $this->_render_view($filename, $data, true);
	}

	public function _render_view($filename, $data=array(), $wrap) {
		global $root;

		$fullpath = "{$filename}.php";
		if(!file_exists($fullpath)){
			throw new HTTPError404();
		}

		extract($data);
		ob_start();
		require($fullpath);
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	/**
	 * Helper function to handle paths/urls
	 */
	private function build_path_array($arg) {
		if(is_array($arg)) {
			return $arg;
		} else {
			if(count($arg) > 0 && $arg[0] == "/") {
				$url = substr($arg, 1);
			} else {
				$url = "{$this->name}/$arg";
			}
			return explode("/", $url);
		}
	}

	public function BuildSubMenu() {
		return new Menu();
	}

	protected function ensure_format() {
		if(func_num_args() < 1) {
			throw new Exception("Coder is a stupid. Send some arguments plox");
		}

		$this->default_format = func_get_arg(0);

		foreach(func_get_args() as $arg) {
			if($this->format() == $arg) {
				return;
			}
		}
		throw new HTTPError404();
	}
}

class SimpleController extends Controller {
	public function __call($name, $args) {
		BasicObject::$output_htmlspecialchars = true;
		return $this->render($name);
	}
}

class DatabaseController extends Controller {
	public function __call($name, $args) {
    $site = DatabaseSite::from_name($this->name, $name);
    if(!isset($site)) {
      //This SHOULD not happen
      return "<p> What teh fakk?! </p>";
    }

		$content = $site->render();
		return $this->render('/cms', [
			'id' => $site->id,
			'content' => $content,
		]);
	}
}
