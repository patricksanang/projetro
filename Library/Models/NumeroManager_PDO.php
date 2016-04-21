<?php
namespace Library\Models;
use Library\Entities\Numero;

class NumeroManager_PDO extends ManagerCrud{


	public function __construct($dao){
		parent::__construct($dao);
		$this->mapping = array(
			'id'=>'idnumero',
			'numero'=>'numero',
			'idContact'=>'contact_idcontact'
		);
		$this->table_name = 'numero';
	}
}