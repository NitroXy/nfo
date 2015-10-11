<?php

class Image {
	public $filename;
	public $url;

	public function __construct($filename){
		$this->filename = basename($filename);
		$this->url = url("/{$filename}");
	}

	public static function all(){
		$files = glob('images/uploaded/*.{JPG,PNG,JPEG,jpg,jpeg,png,GIF,gif}', GLOB_BRACE);
		return array_map(function($x){
			return new Image($x);
		}, $files);
	}
}
