<?php

function url($path){
	global $root;

	/* get optional args (excluding $path) */
	$args = func_get_args();
	array_shift($args);

	/* prepare the base url */
	$base = "{$root}{$path}";

	/* hack to replace url("/foo/:id", $id), it doesn't actually care about the name, the args are positional */
	return preg_replace_callback('/:[a-z]+/', function($m) use (&$args) {
		return array_shift($args);
	}, $base);
}
