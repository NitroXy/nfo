<?php

class Form extends NitroXy\PHPForms\Form {
	static protected function default_options(){
		return array(
			'layout' => 'bootstrap',
		);
	}
}

class FormSelect extends NitroXy\PHPForms\FormSelect {
	static public function from_selection($form, $key, $label_key, array $data, $label, array $attr=array()){
		$null = false;
		if ( isset($attr['null']) ){
			$null = $attr['null'];
			unset($attr['null']);
		}

		if ( $null ){
			$data = array_merge([false], $data);
		}

		return static::from_array_callback($form, $key, $data, function($x) use ($label_key) {
			return $x ? [$x->id, $x->$label_key] : ['', ''];
		}, $label, $attr);
	}
}
