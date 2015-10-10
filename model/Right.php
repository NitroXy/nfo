<?php

class Right extends BasicObject {
	protected static function table_name() {
		return "rights";
	}

	public static function from_username($usr) {
		$sel = static::selection(array('username' => $usr));
		if(empty($sel)) {
			return null;
		}

		return $sel[0];
	}
}
