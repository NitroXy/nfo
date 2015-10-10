<?php

class UserController extends Controller {
	public function login() {
		global $root;
		NXAuth::login();
		throw new HTTPRedirect('/');
	}

	public function logout() {
		global $root;
		NXAuth::logout();
		throw new HTTPRedirect('/');
	}
}
