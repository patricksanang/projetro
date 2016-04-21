<?php
namespace Config;

class Config{
	protected static $attributs = array();
	public static function get($attribut){
		if(isset($this->attributs[$atribut])){
			return $attributs[$attributs];
		}
	}

	public static function set($key , $value){
		$attributs[$key] = $value;
	}
}