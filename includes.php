<?php

$repo_root = __DIR__;
$upload_dir = "{$repo_root}/public/images/uploaded";

$root = dirname($_SERVER['SCRIPT_NAME']);
if ( $root === '/' ) $root = '';

// Ensure environment is proper
require('sanity_checks.php');

// Basic functionality
require("config.php");

//NXAuth
require("nxauth.php");

// Helpers
require("helpers/authenticate.php");
require("helpers/flash.php");
require("helpers/url.php");

// libs
require_once("libs/BasicObject/BasicObject.php");
require_once("libs/BasicObject/ValidatingBasicObject.php");
require_once "libs/php-markdown/Michelf/Markdown.php";
require_once "libs/php-markdown/Michelf/MarkdownExtra.php";
BasicObject::$output_htmlspecialchars = true;

/* controller pulls lots of shit, cannot rely on autoloader unless there is some refactoring */
require("model/Controller.php");

require 'vendor/autoload.php';

spl_autoload_register(function($class){
	$filename = __DIR__ . "/model/{$class}.php";
	if ( file_exists($filename)){
		require_once $filename;
	}
});

require("model/Form.php");
