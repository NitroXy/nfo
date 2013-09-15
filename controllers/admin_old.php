<?php

class AdminController extends Controller {
	public function pre_route($path) {
		if(!is_loggedin() || !is_admin()) {
			throw new HTTPError404();
		}
	}
	public function route($path) {
		/* Ugglyhack deluxe ! */
		if(!is_post()) {
			if(empty($path)) {
				return $this->index(); 
			}

			$site = $path[0];

			if($site == "scheme") {
			    return $this->scheme($path[1]);
			}
			if($site == "add") {
				return $this->add();
			}

			return $this->generate_simple_site($site);
		}
		if($path[0] == "scheme") {
			return $this->scheme($path[1]);
		} else if($path[0] == "add") {
			return $this->add();
		} else {
			return $this->update($path[1], $path[2]);
		}
	}

	public function scheme($id=null) {
		//Update or add item 
		if(is_post()) {
			if(isset($id)) {
				$item = SchemeItem::from_id($id);
				if(!isset($item)) {
					flash('alert alert-danger', 'Hittade ingen schemaelement med id='.$id);
					throw new HTTPRedirect("/admin/scheme");
				}

				$item->timestamp = postdata('timestamp');
				$item->text = postdata('name');
				$item->href = postdata('href');
				$item->commit();

				flash('alert alert-success', 'Ändringarna har blivit sparade');
				throw new HTTPRedirect("/admin/scheme");
			}
		}

		if(!isset($id)) {
			$scheme_items = SchemeItem::all();
			return $this->render('scheme', array('items' => $scheme_items));
		}

		$item = SchemeItem::from_id($id);
		//Show individual item
		return $this->render('edit', array('id' => $id, 'item' => $item));
	}

	public function add() {
		if(is_post()) {
			$item = new SchemeItem;

			$item->timestamp = postdata('timestamp');
			$item->text = postdata('name');
			$item->href = postdata('href');
			$item->commit();

			flash('alert alert-success', 'Ändringarna har blivit sparade');
			throw new HTTPRedirect("/admin/scheme");
		}
		return $this->render('add');
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

		flash('alert alert-success', "{$mainname}/{$name} har sparats.");
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
