<?php

class PresetController extends Controller {
	public function route($path){
		if ( count($path) != 2 ){
			error_404();
		}

		/* convert /preset/:id/action to /preset/action/:id so parent router can handle it */
		return parent::route([$path[1], $path[0]]);
	}

	public function icon($id){
		$this->ensure_format('png');
		global $db;
		$id = (int)$id;

		/* fetch data from preset */
		if ( ($result=$db->query("SELECT `icon` FROM `scheme_presets` WHERE `scheme_preset_id` = $id LIMIT 1")) === FALSE ){
			die('not found');
			error_404();
		}

		/* test if icon is set */
		$data = $result->fetch_array();
		if ( $data === null || $data[0] === null ){
			error_404();
		}

		return $data[0];
	}
}
