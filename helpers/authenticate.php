<?php

function is_loggedin() {
    return NXAuth::is_authenticated();
}

function is_admin() {
	if(!is_loggedin()) {
		return false;
	}

	$u = NXAuth::user();

	/* user has the nfo_admin right set according to nitroxy.com */
	if ( NXAPI::has_right(array('user' => $u->user_id, 'right' => 'nfo_admin')) ){
		return true;
	}

	//Must be crew in order to be admin.
	if(!NXAPI::is_crew(array('user' => $u->user_id))) {
		return false;
	}

	if(null !== get_rights()) {
		return true;
	}

	return false;
}

function ensure_right($right) {
    if(!has_right($right)) {
        throw new HTTPError403();
    }
}

function has_right($right) {
    if(is_admin()) {
        return true;
    }

    $rs = get_rights();
    if(!isset($rs)) {
        return false;
    }

    foreach($rs as $r) {
        if($right == "Administratör") {
            return true; //Has all rights .. uglyhack :D
        }
        if($right == $r) {
            return true;
        }
    }
    return false;
}

function get_rights() {
    $u = NXAuth::user();

    $rights = Right::from_username($u->username);
    if(!isset($rights)) {
        return null;
    }

    $ret = array();
    foreach($_rights as $right => $bit) {
        if($rights->permissions & (1 << $bit)) {
            $ret[] = $right;
        }
    }
    return $ret;
}

/* no idea why I put it here ... */
function postdata($s) {
    return isset($_POST[$s]) ? $_POST[$s] : null;
}

function getdata($s) {
    return isset($_GET[$s]) ? $_GET[$s] : null;
}

function is_post() {
    return (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0);
}

function ensure_post() {
    if(!is_post()) {
        throw new HTTPError403();
    }
}
