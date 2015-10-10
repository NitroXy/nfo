<?php

use \Michelf\MarkdownExtra;

class AdminController extends Controller {
	public function pre_route($path) {
		if(!is_loggedin()) {
			throw new HTTPRedirect('/user/login');
		}
	}

	public function index() {
		$rights = get_rights();
		return $this->render('index', array('rights' => $rights));
	}

	/*
		 DatabaseSite management
	 */
	public function edit($idx = null) {
		ensure_right("Sido-moderator");

		if(!isset($idx)) {
			$sites = DatabaseSite::selection(['@order' => 'href']);
			return $this->render('picking_site', array('sites' => $sites));
		}

		$new = DatabaseSite::from_id($idx);
		if(!isset($new)) {
			flash('alert alert-danger', 'Kunde inte hitta någon sida med id='.$idx);
			return "";
		}

		if(is_post()) {
			$name = postdata('href');

			$text = postdata('text');
			$new->text = $text;
			$new->display_order = postdata('order');
			$new->display_name = postdata('name');
			//$new->name = postdata('href');
			$new->commit();

			flash('alert alert-success', 'Sidan har sparats ... ');
			throw new HTTPRedirect('/admin/edit');
		}

		return $this->render('edit', array('s' => $new, 'id' => $idx));
	}

	public function add() {
		ensure_right("Sido-moderator");
		if(is_post()) {
			//Add new one ...
			$new = new DatabaseSite;
			$new->text = postdata('text');
			$new->display_name = postdata('name');

			$path = explode('/', postdata('href'));
			if($path[0] == "") {
				array_shift($path);
			}

			if(count($path) > 1) {
				$new->name = $path[0];
				$new->href = $path[1];
			} else {
				$new->name = $path[0];
				$new->href = 'index';
			}

			$order = postdata('order');
			if(!isset($order) || $order == "") {
				$sites = DatabaseSite::selection(array());
				$order = count($sites);
			}
			$new->display_order = $order;

			if(postdata('html') == 'Yes') {
				$new->text_type = 'HTML';
			} else {
				$new->text_type = 'Markdown';
			}

			$new->commit();

			flash('alert alert-success', 'Sidan har lagts till');
			throw new HTTPRedirect('/admin/edit');
		}

		return $this->render('add');
	}

	public function delete($idx = null) {
		ensure_right("Sido-moderator");
		if(!isset($idx)) {
			return "<p class=\"alert alert-danger\"> Kan inte ta bort en sida utan id. </p>";
		}

		$new = DatabaseSite::from_id($idx);
		if(!isset($new)) {
			return '<p class="alert alert-danger"> Kunde inte hitta en sida med det angivna id. </p>';
		}

		if(is_post()) {
			//Remove it
			$new->delete();
			flash('alert alert-success', 'Sidan har tagits bort');
			throw new HTTPRedirect('/admin/edit');
		}

		return $this->render('site_confirm_delete', array('s' => $new));
	}

	public function preview() {
		if(is_post()) {
			$markdown = new MarkdownExtra();

			$markdown->no_markup = true;
			$markdown->nl2br = true;

			return html_entity_decode($markdown->transform(postdata('text')), ENT_QUOTES, "UTF-8");
		}

		return "";
	}

	/* News management */
	public function news($id = null) {
		ensure_right("Nyhets-moderator");

		if(!isset($id)) {
			//List the news
			$news = NewsItem::all();
			return $this->render('news_list', array('news' => $news));
		}

		$new = NewsItem::from_id($id);
		if(!isset($new)) {
			flash('alert alert-danger', 'Kunde inte hitta nyhet med det angivna id='.$id);
			throw new HTTPRedirect('/admin/news');
		}

		if(is_post()) {
			global $u;

			$new->topic = postdata('topic');
			$new->name = $u->username;
			$new->text = postdata('text');
			$new->commit();

			flash('alert alert-success', 'Nyheten blev uppdaterad');
			throw new HTTPRedirect('/admin/news');
		}

		return $this->render('news_edit', array('n' => $new));
	}

	public function news_add() {
		ensure_right("Sido-moderator");
		if(is_post()) {
			global $u;

			$new = new NewsItem;
			$new->topic = postdata('topic');
			$new->name = $u->username;
			$new->text = postdata('text');
			$new->commit();

			flash('alert alert-success', 'Nyheten har blivit tillagd');
			throw new HTTPRedirect('/admin/news');
		}

		return $this->render('news_add');
	}
	public function news_del($id = null) {
		ensure_right("Sido-moderator");
		if(!isset($id)) {
			flash('alert alert-danger', 'Kunde inte hitta en nyhet med id='.$id);
			throw new HTTPRedirect('/admin/news');
		}

		$new = NewsItem::from_id($id);
		if(!isset($new)) {
			flash('alert alert-danger', 'Kunde inte radera nyhet med id='.$id);
			throw new HTTPRedirect('/admin/news');
		}

		if(is_post()) {
			$new->delete();
			flash('alert alert-success', 'Tog bort nyheten "'.$new->topic.'"');
			throw new HTTPRedirect('/admin/news');
		}

		return $this->render('news_confirm_del', array('n' => $new));
	}

	/*
		 Image handling here !
	 */
	public function images() {
		ensure_right("Bild-moderator");
		$image = getdata('img');
		if(!isset($image)) {
			/*
				 List all files in the directory
				 images/uploaded
				 with the file extension of an image ... (most known images atleast)
			 */
			$files = glob('images/uploaded/*.{JPG,PNG,JPEG,jpg,jpeg,png,GIF,gif}', GLOB_BRACE);
			return $this->render('images_list', array('images' => $files));
		}

		return $this->render('images_view', array('image' => $image));
	}

	/*
		 AJAX request to list all of the images
	 */
	public function image_embedded_pick() {
		$files = glob('images/uploaded/*.{JPG,PNG,JPEG,jpg,jpeg,png,GIF,gif}', GLOB_BRACE);
		foreach($files as $f) {
			echo '<a onclick="image_insert(\''.$f.'\')" href="#"><img src="/'.$f.'"></a>';
		}
		die();
	}

	public function image_del() {
		ensure_right("Bild-moderator");
		$image = getdata('img');
		if(!isset($image)) {
			flash('alert alert-danger', 'Kunde inte hitta bilden');
			throw new HTTPRedirect('/admin/images');
		}

		if(is_post()) {
			unlink($image);
			flash('alert alert-success', 'Bilden "/'.$image.'" har blivit borttagen');
			throw new HTTPRedirect('/admin/images');
		}

		return $this->render('confirm_delete', array('image' => $image));
	}

	public function image_add() {
		ensure_right("Bild-moderator");
		//Upload new image
		if(is_post()) {
			if($_FILES["file"]["error"] > 0) {
				flash('alert alert-danger', 'Fel uppstod: '.$_FILES["file"]["error"]);
				throw new HTTPRedirect('/admin/images');
			}

			$dir = dirname(__FILE__);
			$meh = explode('/', $dir);
			array_pop($meh);
			$dir = implode('/', $meh);

			if(file_exists($dir.'/public/images/uploaded/'.$_FILES["file"]["name"])) {
				flash('alert alert-danger', 'En bild med detta namnet finns redan');
				throw new HTTPRedirect('/admin/images');
			}

			$filename = str_replace(" ", "_", $_FILES["file"]["name"]);
			move_uploaded_file($_FILES["file"]["tmp_name"], $dir."/public/images/uploaded/".$filename);

			flash('alert alert-success', 'Bilden laddades upp, och det gick förhoppningsvis bra :)');
			throw new HTTPRedirect('/admin/images');
		}

		return $this->render('image_add');
	}

	public function timetable($id = null) {
		ensure_right("Schema-moderator");

		/* mini router */
		if ( is_post() ){
			if ( isset($_POST['remove']) ){
				return $this->timetable_remove($id);
			} else {
				return $this->timetable_update($id);
			}
		} else {
			if ( $id === 'new' ){
				return $this->timetable_add();
			} elseif ( $id !== null ){
				return $this->timetable_show($id);
			} else {
				return $this->timetable_index();
			}
		}
	}

	protected function timetable_index(){
		$items = SchemeItem::selection(array());
		return $this->render('timetable', [
			'items' => $items
		]);
	}

	protected function timetable_add() {
		$item = new SchemeItem;
		$item->timestamp = date('Y-m-d H:00');
		$item->duration = 1;
		$item->color = '#ffffff';
		return $this->render('timetable_edit', [
			'item' => $item,
		]);
	}

	protected function timetable_remove($id){
		$item = SchemeItem::from_id($id);
		if ( $item !== null ) {
			$item->delete();
			flash('success', 'Aktiviteten togs bort.');
		} else {
			flash('error', "Kunde inte hitta aktivitet med id {$id}.");
		}
		throw new HTTPRedirect('/admin/timetable');
	}

	protected function timetable_show($id){
		$item = SchemeItem::from_id($id);
		if ( $item === null ) {
			flash('error', "Kunde inte hitta aktivitet med id {$id}.");
			throw new HTTPRedirect('/admin/timetable');
		}

		return $this->render('timetable_edit', [
			'item' => $item,
		]);

	}

	protected function timetable_update(){
		$item = SchemeItem::update_attributes(postdata('SchemeItem'), [
			'permit' => ['timestamp', 'text', 'short_name', 'href', 'duration', 'color'],
			'create' => true,
			'empty_to_null' => false,
		]);

		try {
			$exists = !!$item->id;
			$item->commit();

			if ( $exists ){
				flash('success', 'Aktiviteten uppdaterades.');
			} else {
				flash('success', 'Aktiviteten skapades.');
			}

			throw new HTTPRedirect('/admin/timetable');
		} catch ( ValidationException $e ){}

		return $this->render('timetable_edit', [
			'item' => $item,
		]);
	}

	public function timetablePreset($id=null){
		/* mini router */
		if ( is_post() ){
			if ( isset($_POST['remove']) ){
				return $this->timetablePresetRemove($id);
			} else {
				return $this->timetablePresetUpdate($id);
			}
		} else if ( $id === null ){
			return $this->timetablePresetList();
		} else if ( $id === 'new' ){
			return $this->timetablePresetNew();
		} else {
			return $this->timetablePresetEdit($id);
		}
	}

	public function timetablePresetList(){
		return $this->render('timetable/preset/list', [
			'presets' => SchemePreset::all(),
		]);
	}

	public function timetablePresetNew(){
		$preset = new SchemePreset();
		return $this->render('timetable/preset/edit', [
			'preset' => $preset,
		]);
	}

	public function timetablePresetEdit($id){
		$preset = SchemePreset::from_id($id) or error_404();
		return $this->render('timetable/preset/edit', [
			'preset' => $preset,
		]);
	}

	public function timetablePresetRemove($id){
		$preset = SchemePreset::from_id($id) or error_404();
		$preset->delete();

		flash('success', 'Mallen togs bort.');
		throw new HTTPRedirect('/admin/timetable-preset');
	}


	protected function timetablePresetUpdate(){
		$preset = SchemePreset::update_attributes(postdata('SchemePreset'), [
			'permit' => ['name', 'color'],
			'create' => true,
			'empty_to_null' => false,
		]);

		try {
			$exists = !!$preset->id;
			$preset->commit();

			if ( $exists ){
				flash('success', 'Mallen uppdaterades.');
			} else {
				flash('success', 'Mallen skapades.');
			}

			throw new HTTPRedirect('/admin/timetable-preset');
		} catch ( ValidationException $e ){}

		return $this->render('timetable/preset/edit', [
			'preset' => $preset,
		]);
	}

	public function rights() {

	}
}
