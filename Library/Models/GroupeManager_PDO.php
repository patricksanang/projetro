<?php
namespace Library\Models;
use Library\Entities\Groupe;
use Library\Utilities;

class GroupeManager_PDO extends ManagerCrud{

	public function __construct($dao){
		parent::__construct($dao);
		$this->mapping = array(
				'id'=>'idgroupe',
				'nom'=>'nomGroupe',
			);

		$this->table_name = 'groupe';
	}
        
        public function getName($name){
		$class = $this->entity_class();
		$result = $this->find(array('nom'=>$name));
		if(count($result)>0){
			return $result[0];
		}else{
			return new $class;
		}
	}
}