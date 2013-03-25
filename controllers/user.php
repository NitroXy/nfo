<?php

class UserController extends Controller {
	public function login() {
		NXAuth::login();

		throw new HTTPRedirect('/');
	}
	public function logout() {
		NXAuth::logout();

		throw new HTTPRedirect('/');
	}
}

?>
