<?php
namespace Library\Models;
use Library\Entity;
use Library\Utilities;
use Library\Entities\Numero;

class ContactHasGroupeManager_PDO extends ManagerCrud{
	public function __construct($dao){
		parent::__construct($dao);
		$this->mapping = array(
				'id'=>'id_contact_has_groupe',
				'groupe'=>'groupe_idgroupe',
				'contact'=>'contact_idcontact',
			);
		$this->table_name = "contact_has_groupe";
	}




	public function bindValue($query , Entity $entity){
		
		
        foreach($this->mapping as $key=>$val){
			if($key != 'id'){
             	$query->bindValue($key , $entity[$key]['id']);
			}
		}
		return $query;
    }

    public function bind_search($query , $data){

		foreach($data as $key=>$d){
			if($key != 'id'){
             	$query->bindValue($key , $d['id']);
			}else{
				//Utilities::print_s("bind search " . $id);
	        	$query->bindValue($key , $d);
			}
		}
		return $query;
	}


	public function fetch($query){
		
		$results = $query->fetchAll();
		$data= array();

		$groupe_manager = new GroupeManager_PDO($this->dao);
		$contact_manager = new ContactManager_PDO($this->dao);
		foreach($results as $r){
			$class = parent::entity_class();

			$element = new $class;
			
			$element['id'] = $r['id'];
			$element['groupe'] = $groupe_manager->get($r['groupe']);
			$element['contact'] = $contact_manager->get($r['contact']);
			$data[] = $element;
		}
		return $data;
	}
}