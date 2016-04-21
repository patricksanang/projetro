<?php
namespace Library;

class Utilities{

	public static function print_table($data){
		echo "<hr>";
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}

	public static function print_s($string){

		echo "</i>$string <br></i>";
	}
}

