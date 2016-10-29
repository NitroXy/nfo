<?php

class Image {
	public $filename;
	public $url;

	public function __construct($filename){
		$this->filename = basename($filename);
		$this->thumbnail = "thumbnail/{$this->filename}";
		$this->url = url("/images/uploaded/{$this->filename}");
		$this->thumbnail_url = url("/images/uploaded/{$this->thumbnail}");
	}

	public static function all(){
		$files = glob('images/uploaded/*.{JPG,PNG,JPEG,jpg,jpeg,png,GIF,gif}', GLOB_BRACE);
		return array_map(function($x){
			return new Image($x);
		}, $files);
	}

	/**
	 * Take an image from $_FILES, uploads and generates thumbnail.
	 *
	 * Will generate flash messages (kind of a bad side-effect but for
	 * compatibility with the legacy code it is easier this way).
	 *
	 * @return Image instance or null on failure.
	 */
	public static function upload($key){
		if ( !array_key_exists($key, $_FILES) ){
			flash('error', "Ingen fil har laddats upp");
			return null;
		}

		$file = $_FILES[$key];
		if ( $file["error"] !== 0 ) {
			flash('error', 'Fel uppstod: '.$file["error"]);
			return null;
		}

		global $upload_dir;
		$filename = preg_replace('/[^a-zA-Z0-9\-\.]+/', '_', $file["name"]);
		$dst = "{$upload_dir}/{$filename}";

		if ( file_exists($dst) ) {
			flash('error', 'En bild med detta namnet finns redan');
			return null;
		}

		if ( move_uploaded_file($file["tmp_name"], $dst) == FALSE ){
			flash('error', 'Misslyckades att ladda upp bilden av okänd anledning [move_uploaded_file]');
			return null;
		}

		$image = new Image($filename);

		if ( !$image->create_thumbnail() ){
			unlink($dst); /* to allow image to be reuploaded and not show up broken */
			return null;
		}

		flash('success', 'Bilden har laddads upp.');
		return $image;
	}

	protected function create_thumbnail(){
		global $upload_dir;

		$thumbnail_dir = "{$upload_dir}/thumbnail";
		if ( !file_exists($thumbnail_dir) ){
			mkdir($thumbnail_dir);
		}

		$src = escapeshellarg("{$upload_dir}/{$this->filename}");
		$dst = escapeshellarg("{$thumbnail_dir}/{$this->filename}");
		$cmd = "convert $src -resize 175x175^ -gravity center -crop 175x175+0+0 +repage $dst";

		exec($cmd, $output, $rc);
		if ( $rc != 0 ){
			flash('error', implode($output, "\n"));
		}

		return $rc === 0;
	}
}
