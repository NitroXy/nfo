<?php

if ( !file_exists(__DIR__ . '/config.php') ){
	die('please create config.php (see config.php.sample)');
}

if ( !file_exists(__DIR__ . '/nxauth.php') ){
	die('please create nxauth.php (see nxauth.php.sample)');
}

if ( !file_exists(__DIR__ . '/vendor/autoload.php') ){
	die('please run `composer install`');
}
