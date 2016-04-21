<?php
namespace Library\Models;
use Library\Entities\Contact;

class ContactManager_PDO extends ManagerCrud{
	public function __construct($dao){
		parent::__construct($dao);
		$this->mapping = array(
				'id'=>'idcontact',
				'nom'=>'nom',
				'prenom'=>'prenom',
				'email'=>'adressemail',
			);
		$this->table_name = "contact";
	}

	public function find($data = array()){
		$result = parent::find($data);
		$numeroManager = new NumeroManager_PDO($this->dao);

		for($i = 0 ; $i < count($result) ; $i++){
			$result[$i]['numeros'] = $numeroManager->find(array('idContact'=>$result[$i]['id']));
		}

		return $result;
	}
}
