<?php
namespace Library\Models;
use Library\Entities\User;

class UserManager_PDO extends ManagerCrud{

	

	public function __construct($dao){
		parent::__construct($dao);
		$this->mapping = array(
			'id'=>'iduser',
			'nom'=>'nom',
			'prenom'=>'prenom',
			'email'=>'adressemail',
			'password'=>'motdepasse',
		);
		$this->table_name = "user";
	}
}