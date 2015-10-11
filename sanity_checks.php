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

if ( !is_writable($upload_dir) ){
	die("$upload_dir is not writable");
}
