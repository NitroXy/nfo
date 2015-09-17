<?php

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
