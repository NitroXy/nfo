<?php

class AdminController extends Controller {
	public function pre_route($path) {
		//ensure_login & ensure_admin
	}
	public function route($path) {
		if(!is_post()) {
			if(empty($path)) {
				return $this->index(); 
			}

			$site = $path[0];
			return $this->generate_simple_site($site);
		}
		return $this->update($path[1], $path[2]);
	}

	public function generate_simple_site($name) {
		$items = DatabaseSite::selection(array('name' => $name));

		if(!isset($items))
			throw new HTTPError404();

		$contents = array();
		$names = array();
		foreach($items as $item) {
			array_push($contents, $item->render());
			array_push($names, (isset($item->href) ? $item->href : $item->name));
		}

		return $this->render('simplesite', array('contents' => $contents, 'names' => $names, 'mainname' => $name));
	}

	public function update($mainname=null, $name=null)
	{
		$new_content = postdata('text');
		$item = DatabaseSite::from_name($mainname, $name);
		if(!isset($item))
			throw new HTTPError404();

		$item->text = $new_content;
		$item->commit();

		flash('success', "{$mainname}/{$name} har sparats.");
		echo 'done.';
		throw new HTTPRedirect("/admin");
	}

	public function index() {
		global $event;

		//Generate list of available entries that you can edit
		$entries = array();
		$items = DatabaseSite::selection(array('href' => 'index'));

		foreach($items as $it)
			array_push($entries, $it->name);

		return $this->render('index', array('event' => $event, 'entries' => $entries));
	}
}

?>
