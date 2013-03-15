<?php

class Config {
	private static $db_host = "localhost";
	private static $db_name = "cpluss";
	private static $db_user = "nx";
	private static $db_password = "";

	public static function fix_database($username=null) {
		if(is_null($username)) {
			$username = self::$db_user;
			$password = self::$db_password;
		}
		return new MySQLi(self::$db_host, $username, $password, self::$db_name);
	}
}

require_once("model/BasicObject.php");
require_once("model/ValidatingBasicObject.php");
BasicObject::$output_htmlspecialchars = true;

//$db = Config::fix_database();
$dir = dirname(__FILE__);

?>
