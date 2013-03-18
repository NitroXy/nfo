<?php

class DynamicController extends Controller {
	public function route($path) {
		if(empty($path)) {
			$path = array('index');
		}

		/* Fetch from database */
		$item = DatabaseSite::from_name(static::menu_name(), $path[0]);
		if(!isset($item))
			throw new HTTPError404();
		return $item->render();
	}

	protected static function menu_name() {
		return "";
	}
}

?>
