<?php
require_once "../libs/php-markdown/Michelf/Markdown.php";
require_once "../libs/php-markdown/Michelf/MarkdownExtra.php";
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
			$sites = DatabaseSite::selection(array());
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
            if(isset($id)) {
                $its = SchemeItem::selection(array('id' => $id));
                $it = $its[0];
                if(!isset($it)) {
                    return '<p class="alert alert-danger">Kunde inte hitta schemaelement med id='.$id.'</p>';
                }

                if(is_post()) {
                    $it->timestamp = postdata('timestamp');
                    $it->text = postdata('text');
                    $it->href = postdata('href');
                    $it->commit();

                    flash('alert alert-success', 'Schemaelementet har blivit uppdaterat.');
                    throw new HTTPRedirect('/admin/timetable');
                }

                return $this->render('timetable_edit', array('it' => $it));
            }


            $items = SchemeItem::selection(array());
            return $this->render('timetable', array('meh' => $items));
        }
        public function timetable_add() {
            ensure_right("Schema-moderator");
            if(is_post()) {
                $it = new SchemeItem;
                $it->timestamp = postdata('timestamp');
                $it->text = postdata('text');
                $it->href = postdata('href');
                $it->commit();

                flash('alert alert-success', 'Schemaelementet har skapats.');
                throw new HTTPRedirect('/admin/timetable');
            }

            return $this->render('/admin/template_add');
        }
        public function timetable_del($id = null) {
            if(!isset($id)) {
                return "No id set, error...";
            }

            $it = SchemeItem::from_id($id);
            if(is_post()) {
                $it->delete();
                flash('alert alert-success', 'Schemaelementet har blivit borttaget ..');
                throw new HTTPRedirect('/admin/timetable');
            }

            return $this->render('/admin/timetable_del', array('id' => $id));
        }

        public function rights() {
            
        }
}

?>
