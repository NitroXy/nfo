<?php

function is_loggedin() {
	return NXAuth::is_authenticated();
}

function is_admin() {
	if(!is_loggedin())
		return false;
	
	return true;
}

/* no idea why I put it here ... */
function postdata($s) {
	return $_POST[$s];
}
function getdata($s) {
	return $_GET[$s];
}

function is_post() {
	return (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0);
}

function ensure_post() {
	if(!is_post())
		throw new HTTPError403();
}

?>
