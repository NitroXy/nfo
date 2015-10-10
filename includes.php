<?php

$repo_root = __DIR__;
$root = dirname($_SERVER['SCRIPT_NAME']);

// Ensure environment is proper
require('sanity_checks.php');

// Basic functionality
require("config.php");

//NXAuth
require("nxauth.php");

// Helpers
require("helpers/authenticate.php");
require("helpers/flash.php");

// libs

require_once("libs/BasicObject/BasicObject.php");
require_once("libs/BasicObject/ValidatingBasicObject.php");
BasicObject::$output_htmlspecialchars = true;

// Models
require("model/Controller.php");
require("model/Path.php");
require("model/Menu.php");
require("model/Newsfeed.php");
require("model/Scheme.php");
require("model/DatabaseSite.php");
require("model/Rights.php");

require 'vendor/autoload.php';

spl_autoload_register(function($class){
	$filename = __DIR__ . "/classes/{$class}.php";
	if ( file_exists($filename)){
		require_once $filename;
	}
});

require("model/Form.php");
