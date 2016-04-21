<?php
namespace Library;
class PDOFactory
{

	protected static $db = '';
	public static function getMysqlConnexion(){
		if(PDOFactory::$db == ''){
			PDOFactory::$db = new \PDO('mysql:dbname=mydb','root','' , array(\PDO::ATTR_PERSISTENT => true));
			PDOFactory::$db->setAttribute(\PDO::ATTR_ERRMODE , \PDO::ERRMODE_EXCEPTION);
		}
		return PDOFactory::$db;

		// $db = new \PDO('mysql:dbname=mydb','dev','');
		// $db->setAttribute(\PDO::ATTR_ERRMODE , \PDO::ERRMODE_EXCEPTION);
		// return $db;
		// //return PDOFactory::$db;
	}
	

	// public static function getMysqlConnexion()
	// {
	// 	$db = new \PDO('mysql:dbname=mydb','dev','');
	// 	$db->setAttribute(\PDO::ATTR_ERRMODE , \PDO::ERRMODE_EXCEPTION);
	// 	return $db;
	// }
}
