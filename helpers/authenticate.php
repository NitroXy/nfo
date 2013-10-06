<?php

function is_loggedin() {
    return NXAuth::is_authenticated();
}

function is_admin() {
    if(!is_loggedin()) {
            return false;
    }
    
    global $event;
    $u = NXAuth::user();

    //If this is a nx administrator, he becomes such as here as well
    $groups = NXAPI::groups(array('user' => $u->user_id));
    foreach($groups as $group) {
        if($group == "Administatörer") {
            return true;
        }
    }

    //Must be crew in order to be admin.
    if(!NXAPI::is_crew(array('user' => $u->user_id))) {
        return false;
    }

    //Everybody in "Security/Info" is an administrator
    $crew_groups = NXAPI::crew_groups(array('user' => $u->user_id));
    foreach($crew_groups as $group) {
        if($group == "Security/Info") {
            return true;
        }
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
    return $_POST[$s];
}
function getdata($s) {
    return $_GET[$s];
}

function is_post() {
    return (strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0);
}

function ensure_post() {
    if(!is_post()) {
        throw new HTTPError403();
    }
}

?>
